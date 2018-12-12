<?php

namespace AppBundle\Controller {

    use BackendBundle\Entity\AnswerInee;
    use BackendBundle\Entity\AnswerIneeTeacher;
    use BackendBundle\Entity\Dimension;
    use BackendBundle\Entity\EvaluationInee;
    use BackendBundle\Entity\Indicator;
    use BackendBundle\Entity\Parameter;
    use BackendBundle\Entity\Teacher;
    use PHPExcel;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use AppBundle\Services\PDF;
	use AppBundle\Services\MultiCellBlt2;
	

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 20/08/17
     * Time: 13:30
     */
    class QuestionnaireIneeController extends Controller {

        /**
         * @var int codigo para indicar que no esta autorizado
         */
        const UNAUTHORIZED = 401;

        public function getQuestionsAction(Request $request, $dimensionId, $educationLevel, $teacherFunction) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get('app.jwt_auth');
            $authorization = $request->headers->get('X-API-KEY');
            $identity = $jwtAuth->checkToken($authorization, true);
            if (!$identity) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $parameters = $this->getDoctrine()->getRepository(Parameter::class)->findBy([
                'dimension' => $dimensionId
            ]);

            $evaluation = [];

            foreach ($parameters as $parameter) {
                $indicators = $this->getDoctrine()->getRepository(Indicator::class)->findBy([
                    'parameter' => $parameter->getId()
                ]);

                foreach ($indicators as $indicator) {
                    $questions = $this->getDoctrine()->getRepository(EvaluationInee::class)->findBy([
                        'indicator' => $indicator->getId(),
                        'educationLevel' => $educationLevel,
                        'teacherFunction' => $teacherFunction,
                    ]);

                    if (empty($questions)) {
                        continue;
                    }

                    $rand = array_rand($questions, 1);
                    $answers = $this->getDoctrine()->getRepository('BackendBundle:AnswerInee')->findBy([
                        'evaluationInee' => $questions[$rand]
                    ]);

                    $_answers = [];

                    foreach ($answers as $answer) {
                        /** @noinspection PhpUndefinedMethodInspection */
                        array_push($_answers, [
                            'id' => $answer->getId(),
                            'title' => $answer->getTitle()
                        ]);
                    }

                    $eduLevel = $this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->findOneBy([
                        'id' => $educationLevel
                    ]);

                    $tree = [];
                    /** @noinspection PhpUndefinedMethodInspection */
                    $tree['id'] = $questions[$rand]->getId();
                    $tree['educationLevel'] = $eduLevel->getName();
                    /** @noinspection PhpUndefinedMethodInspection */
                    $tree['question'] = $questions[$rand]->getReagentBase();
                    $tree['answers'] = $_answers;
                    array_push($evaluation, $tree);
                }
            }

            return $helpers->json($evaluation);
        }

        /**
         * Get profile to evaluate
         * @param Request $request
         * @return mixed
         */
        public function getDimensionsAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");
            $results = $this->get('app.inee_results');

            $authorization = $request->headers->get('X-API-KEY');
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $teacher = $this->getDoctrine()->getRepository('BackendBundle:Teacher')->findOneBy([
                'id' => $identity->teacher_id
            ]);

            if ($teacher->getEvaluationIneeFinish()) {
                $graph = $results->run($teacher);
                $graph['id'] = $teacher->getId();
                return $helpers->json($graph);
            }

            $repository = $this->getDoctrine()->getRepository(AnswerIneeTeacher::class);

            $query = $repository->createQueryBuilder('ait')
                    ->where('ait.teacher = :teacher')
                    ->setParameter('teacher', $teacher)
                    ->groupBy('ait.dimension')
                    ->getQuery();
            $dimensionsEvaluated = $query->getResult();

            if (empty($dimensionsEvaluated)) {
                $dimensions = $this->getDoctrine()->getRepository(Dimension::class)->findBy([
                    'educationLevel' => $teacher->getEducationLevel(),
                    'teacherFunction' => $teacher->getTeacherFunction()
                ]);
            } else {
                $excludeDimension = [];
                foreach ($dimensionsEvaluated as $item) {
                    array_push($excludeDimension, $item->getDimension()->getId());
                }

                $repository = $this->getDoctrine()->getRepository(Dimension::class);
                $query = $repository->createQueryBuilder('d')
                        ->where('d.educationLevel = :educationLevel')
                        ->andWhere('d.teacherFunction = :teacherFunction')
                        ->andWhere('d.id NOT IN(:dimensions)')
                        ->setParameter('educationLevel', $teacher->getEducationLevel())
                        ->setParameter('teacherFunction', $teacher->getTeacherFunction())
                        ->setParameter('dimensions', $excludeDimension)
                        ->getQuery();

                $dimensions = $query->getResult();
            }

            if (count($dimensions) === 0 && count($dimensionsEvaluated) === 0) {
                return $helpers->json(array(
                            'status' => 'noEvaluation',
                            'title' => 'Sin evaluaciones',
                            'message' => 'No existen evalaciones por el momento'
                ));
            } else if (count($dimensions) === 0 && count($dimensionsEvaluated) > 0) {
                if (!$teacher->getEvaluationIneeFinish()) {
                    $manager = $this->getDoctrine()->getManager();
                    $teacher->setEvaluationIneeFinish(1);
                    $manager->persist($teacher);
                    $manager->flush();
                }
                $graph = $results->run($teacher);
                return $helpers->json($graph);
            }

            $dimensionsCollection = [];
            foreach ($dimensions as $dimension) {
                array_push($dimensionsCollection, [
                    'id' => $dimension->getId(),
                    'dimension' => $dimension->getName(),
                    'educationLevel' => $dimension->getEducationLevel()->getId(),
                    'teacherFunction' => $dimension->getTeacherFunction()->getId()
                ]);
            }

            return $helpers->json($dimensionsCollection);
        }

        /**
         * Save evaluation for user
         * @param Request $request
         * @return mixed
         */
        public function saveAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");

            $authorization = $request->headers->get('X-API-KEY');
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $teacher = $this->getDoctrine()->getRepository(Teacher::class)->findOneBy([
                'id' => $identity->teacher_id
            ]);

            $params = json_decode($request->get("json", null));

            if (!empty($params)) {
                $dimension = (property_exists($params, "dimension")) ? $params->dimension : null;
                $answers = (property_exists($params, "answers")) ? get_object_vars($params->answers) : null;
                $dimensionEntity = $this->getDoctrine()->getRepository(Dimension::class)->find($dimension);
                $total = (property_exists($params, "total")) ? $params->total : null;
                $manager = $this->getDoctrine()->getManager();
                foreach ($answers as $question => $answer) {
                    $answerIneeTeacher = new AnswerIneeTeacher();
                    $answerIneeTeacher->setDimension($dimensionEntity)
                            ->setEvaluationInee($this->getDoctrine()->getRepository(EvaluationInee::class)->find($question))
                            ->setAnswerInee($this->getDoctrine()->getRepository(AnswerInee::class)->find($answer))
                            ->setTeacher($teacher)
                            ->setTotal($total)
                            ->setCreateTime(new \DateTime('now'));
                    $manager->persist($answerIneeTeacher);
                    $manager->flush();
                }

                return $helpers->json(array(
                            'status' => 'success',
                            'title' => 'Guardado',
                            'message' => 'La evaluación se ha guardado correctamente, la página se refrescará en automático en 5 segundos'
                ));
            }

            return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Error al guardar la evaluación'
            ));
        }

        /**
         * Save image of results evaluation
         * @param Request $request
         * @return mixed
         */
        public function saveImageAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");

            $authorization = $request->headers->get('X-API-KEY');
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $teacher = $this->getDoctrine()->getRepository(Teacher::class)->findOneBy([
                'id' => $identity->teacher_id
            ]);

            $image = $request->get("image", null);

            if (is_object($teacher) && !empty($image)) {
                $manager = $this->getDoctrine()->getManager();
                $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $image);
                $data = base64_decode($image);
                if (!file_exists("uploads")) {
                    mkdir("uploads");
                }
                if (!file_exists("uploads/evaluation_xxi_teacher_" . $teacher->getId())) {
                    mkdir("uploads/evaluation_xxi_teacher_" . $teacher->getId());
                }

                $fileName = time() . ".png";
                $dir = "uploads/evaluation_xxi_teacher_" . $teacher->getId();
                $filePath = $dir . "/" . $fileName;

                //if ($teacher->getEvaluationIneeImage() !== null && file_exists($dir . "/" . $teacher->getEvaluationIneeImage())) {
                //    return $helpers->json(array(
                //                'status' => 'success',
				//				'png' => $fileName
                //    ));
                //}

                if (file_put_contents($filePath, $data)) {
                    $teacher->setEvaluationIneeImage($fileName);
                    $manager->persist($teacher);
                    $manager->flush();
                    return $helpers->json(array(
                                'status' => 'success',
								'png' => $fileName
                    ));
                }
            }
            return $helpers->json(array(
                        'status' => 'error',
            ));
        }

        public function exportExcelAction(Request $request, $teacherId) {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            $userData = $jwt_auth->checkToken($authorization, true);
            $accessGranted = $access_control->accessGrantedForAdmin($userData);

            if (is_array($accessGranted)) {
                return $helpers->json($accessGranted);
            }

            $logo = $this->container->getParameter('serverRoot') . "/assets/images/logosinadep.png";
            $manager = $this->getDoctrine()->getManager();

            $teacher = $manager->getRepository('BackendBundle:Teacher')->find($teacherId);
            $pathToUploadDir = "uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/";

            if (!file_exists("uploads")) {
                mkdir("uploads");
            }

            if (!file_exists($pathToUploadDir)) {
                mkdir($pathToUploadDir);
            }


            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("SINADEP")
                    ->setLastModifiedBy("SINADEP")
                    ->setTitle("Resultado de Evaluación INEE" . $teacher->getFullname())
                    ->setSubject("Documento exportado desde sistema")
                    ->setDescription("Resultado de Evaluación INEE.")
                    ->setKeywords("Resultado de Evaluación INEE")
                    ->setCategory("Report");
            $objPHPExcel->setActiveSheetIndex(0);

            $activeSheet = $objPHPExcel->getActiveSheet();
            $letter = "A";
            $j = 1;
            $j = $this->putImageOnSheet($j, $activeSheet, $logo, 5);

            $activeSheet->setCellValue($letter . $j, "RESULTADOS EVALUACIÓN INEE");
            $activeSheet->getStyle($letter . $j)->getFont()->setSize(30);
            $activeSheet->mergeCells($letter . $j . ':L' . ($j + 2));

            $j += 4;

            $activeSheet->setCellValue($letter . $j, "Profesor: ");
            $letter++;
            $activeSheet->setCellValue($letter . $j, $teacher->getFullname());

            $j += 3;

            $j++;

            $this->putImageOnSheet($j, $activeSheet, $pathToUploadDir . $teacher->getEvaluationIneeImage(), 45);

            $name = "result.xlsx";
            $objPHPExcel->getActiveSheet()->setTitle("Evaluación");
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($pathToUploadDir . "/$name");
            unlink('logo.png');

            return $helpers->json(array(
                        'status' => 'success',
                        'title' => 'Exportado correctamente',
                        'message' => '¡Archivo exportado correctamente!',
                        'url' => $this->container->getParameter('serverRootApi') . "/" . $pathToUploadDir . $name,
                        'userId' => $teacher->getId()
            ));
        }

        /**
         * @param Request $request
         * @param $teacherId
         * @return mixed
         */
        public function exportPdfAction(Request $request, $teacherId) {
            $helpers = $this->get("app.helpers");
			$results = $this->get('app.inee_results');

            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

//            $userData = $jwt_auth->checkToken($authorization, true);
//            $accessGranted = $access_control->accessGrantedForAdmin($userData);
//
//            if (is_array($accessGranted)) {
//                return $helpers->json($accessGranted);
//            }

            $logo = $this->container->getParameter('serverRoot') . "/assets/images/logosinadep.png";
            $server_api = $this->container->getParameter('serverRootApi');

            $pdf = new PDF($logo, null, $orientation = 'P', $unit = 'mm', $size = 'letter');
            $pdf->title = "RESULTADOS EVALUACION SIGLO XXI";
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 12);
            $manager = $this->getDoctrine()->getManager();
            $teacher = $manager->getRepository(Teacher::class)->find($teacherId);
        //    if (!file_exists("uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/result_inee.pdf")) {

                $query = 'SELECT 
                                TCHR.ID
                               ,TCHR.USER_ID
                               ,TCHR.TEACHER_FUNCTION_ID
                               ,TCHR.SPECIALITY_ID
                               ,TCHR.EDUCATION_LEVEL_ID
                               ,TCHR.CURP
                               ,TCHR.RFC
                               ,TCHR.FULLNAME
                               ,EDLV.NAME AS EDUCATION_LEVEL_NAME
                               ,SPTY.NAME AS SPECIALITY_NAME
                               ,TEFU.NAME AS TEACHER_FUNCTION_NAME
                               ,USER.EMAIL
                               ,USER.SECTION_NAME AS SECCION_SINDICAL
                       FROM teacher TCHR 
                       INNER JOIN education_level EDLV ON 
                               TCHR.EDUCATION_LEVEL_ID = EDLV.ID 
                       INNER JOIN speciality SPTY ON 
                               TCHR.SPECIALITY_ID = SPTY.ID 
                       INNER JOIN teacher_function TEFU ON 
                               TCHR.TEACHER_FUNCTION_ID = TEFU.ID 
                       INNER JOIN user USER ON 
                               TCHR.USER_ID = USER.ID 
                       WHERE TCHR.ID =' . $teacherId;
                $statement = $manager->getConnection()->prepare($query);
                $statement->execute();
                $data = $statement->fetchAll();

                $pdf->SetFont('Times', 'BIU', '9');
                $w = array(60, 40, 45, 50);
                $header = array("Profesor", "CURP", "RFC", "Email");
                for ($i = 0; $i < count($header); $i++)
                    $pdf->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C');
                $pdf->Ln();
                // Data
                $pdf->SetFont('Times', 'BI', '8');
                $pdf->Cell($w[0], 6, utf8_decode($data[0]['FULLNAME']), 'LR');
                $pdf->Cell($w[1], 6, utf8_decode($data[0]['CURP']), 'LR');
                $pdf->Cell($w[2], 6, utf8_decode($data[0]['RFC']), 'LR');
                $pdf->Cell($w[3], 6, utf8_decode($data[0]['EMAIL']), 'LR');
                $pdf->Ln();
                $pdf->SetFont('Times', 'BIU', '9');
                $header = array("Sección sindical", "Nivel de educación", "Especialidad", "Función");
                for ($i = 0; $i < count($header); $i++)
                    $pdf->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C');
                $pdf->Ln();
                // Data
                $pdf->SetFont('Times', 'BI', '8');
                $pdf->Cell($w[0], 6, utf8_decode($data[0]['SECCION_SINDICAL']), 'LR');
                $pdf->Cell($w[1], 6, utf8_decode($data[0]['EDUCATION_LEVEL_ID']), 'LR');
                $pdf->Cell($w[2], 6, utf8_decode($data[0]['SPECIALITY_NAME']), 'LR');
                $pdf->Cell($w[3], 6, utf8_decode($data[0]['TEACHER_FUNCTION_NAME']), 'LR');
                $pdf->Ln();

                // Closing line
                $pdf->Cell(array_sum($w), 0, '', 'T');
                $dir = $server_api . "/uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/";
                $pathFile = $dir . $teacher->getEvaluationIneeImage();
                $pdf->Image($pathFile, 40, 93, 130, 130);
				
				// Cuadro de descripcion de las dimensiones
				$graph = $results->run($teacher);
				$pdf->Ln(140);
				$pdf->Cell(10, 6, "Donde:");				
				$pdf->Ln();
				$column_width = 190;
				//Test1
				$test1 = array();
				$test1['bullet'] = chr(149);
				$test1['margin'] = ' ';
				$test1['indent'] = 0;
				$test1['spacer'] = 0;
				$test1['text'] = array();
				foreach ($graph['tagDimensions'] as $clave => $valor ){
					$test1['text'][$clave] = $valor;
				}
				$pdf->SetX(10);
				$pdf->MultiCellBltArray($column_width-10,6,$test1);
				$pdf->Ln(10);
				
                $pdf->Output("uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/result_inee.pdf", 'F');

                if (file_exists("uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/result_inee.pdf")) {
                    return $helpers->json(array(
                                'status' => 'success',
                                'title' => 'Exportado correctamente',
                                'message' => '¡Archivo exportado correctamente!',
                                'userId' => $teacher->getId()
                    ));
                } else {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error al exportar',
                                'message' => '¡Ocurrio un error al exportar el archivo!',
                    ));
                }
        //    } else {
        //        return $helpers->json(array(
        //                    'status' => 'success',
        //                    'title' => 'Exportado correctamente',
        //                    'message' => '¡Archivo exportado correctamente!',
        //                    'userId' => $teacher->getId()
        //        ));
        //    }
        }

        /**
         * @param $row
         * @param $activeSheet
         * @param $path
         * @param int $howManyRowsMore
         * @param string $name
         * @param string $description
         * @param string $column
         * @return int
         */
        private function putImageOnSheet($row, $activeSheet, $path, $howManyRowsMore = 18, $name = "", $description = "", $column = "A") {
            if (file_exists($path) || $this->url_exists($path)) {
                $objDrawing = new \
                        PHPExcel_Worksheet_Drawing();
                $objDrawing->setName($name);
                $objDrawing->setDescription($description);
                if ($this->url_exists($path)) {
                    if (!file_exists('logo.png')) {
                        file_put_contents('logo.png', file_get_contents($path));
                    }
                    $objDrawing->setPath('logo.png');
                } else {
                    $objDrawing->setPath($path);
                }
                $objDrawing->setCoordinates($column . $row);
                $objDrawing->setWorksheet($activeSheet);
                $row += $howManyRowsMore;
            } else {
                $activeSheet->setCellValue("A" . $row, "No se pudo encontrar la imagen $name");
                $row += 2;
            }
            return $row;
        }

        /**
         * @param null $url
         * @return bool
         */
        function url_exists($url = NULL) {

            if (empty($url)) {
                return false;
            }

            $options['http'] = array(
                'method' => "HEAD",
                'ignore_errors' => 1,
                'max_redirects' => 0
            );
            $body = @file_get_contents($url, NULL, stream_context_create($options));

            // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
            if (isset($http_response_header)) {
                sscanf($http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode);

                //Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
                $accepted_response = array(200, 301, 302);
                if (in_array($httpcode, $accepted_response)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Elimina la evaluacion
         * @return mixed
         */
        public function resetEvaluationIneeAction($teacherId) {
            $helpers = $this->get("app.helpers");
            
            $manager = $this->getDoctrine()->getManager();
            
            $query = 'DELETE FROM answer_inee_teacher WHERE teacher_id =' . $teacherId;
            $statement = $manager->getConnection()->prepare($query);
            $statement->execute();
            
            $query = 'UPDATE teacher SET evaluation_inee_finish = 0 WHERE teacher.id = ' . $teacherId;
            $statement = $manager->getConnection()->prepare($query);
            $statement->execute();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                        'status' => 200,
                        'title' => '¡Correcto!',
                        'message' => 'Se ha reiniciado correctamente la evaluación.'
            ));
        }

	function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
    {
        if (!is_array($blt_array))
        {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }
                
        //Save x
        $bak_x = $this->x;
        
        for ($i=0; $i<sizeof($blt_array['text']); $i++)
        {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
            
            // SetX
            $this->SetX($bak_x);
            
            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);
            
            //Output bullet
            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
            
            //Output text
            $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
            
            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text'])-1)
                $this->Ln($blt_array['spacer']);
            
            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet']++;
        }
    
        //Restore x
        $this->x = $bak_x;
    }
    }

}
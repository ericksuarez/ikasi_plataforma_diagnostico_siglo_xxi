<?php

namespace AppBundle\Controller;

use BackendBundle\Entity\Teacher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\TeacherAnswerCentury;
use AppBundle\Services\PDF;
use FPDF;
use PHPExcel;
use PHPExcel_Style_Border;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet_Drawing;

class TeacherAnswerCenturyController extends Controller {

    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:TeacherAnswerCentury";
    const LOGO = "http://sinadep.wsensemx.com/assets/images/logosinadep.png";
    const SERVER_API =  "http://api.sinadep.wsensemx.com";

    public function saveAnswerAction(Request $request) {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");
        // Control de acceso
        $access_control = $this->get("app.access_control");
        if (empty($authorization)) {
            //return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        }

        $userData = $jwt_auth->checkToken($authorization, true);
        $accessGranted = $access_control->accessGrantedForAdmin($userData);
        if (is_array($accessGranted)) {
            //return $helpers->json($accessGranted);
        }

        $json = trim($request->get("json", null), ",]");
        $userId = $request->get("teacherId", null);
        $json = $json . "]";
        $json = json_decode($json);
        //var_dump($userId);
        //exit;
        if ($json != null) {
            $manager = $this->getDoctrine()->getManager();
            $user = $manager->getRepository("BackendBundle:User")->find($userId);
            $teacher = $manager->getRepository("BackendBundle:Teacher")->findOneBy(array("user" => $user));
            foreach ($json as $array) {
                foreach ($array as $key => $value) {
                    //echo "id_pregunta: " . substr($key, 2) . ": id_respuesta: " . $value . "<br>";
                    $questionId = intval(substr($key, 2));
                    $answerId = intval($value);
                    $answerCategory = $manager->getRepository("BackendBundle:AnswerCategory")->find($answerId);
                    $questionCentury = $manager->getRepository("BackendBundle:QuestionCentury")->find($questionId);

                    $existsAnswer = $manager->getRepository($this::REPOSITORY)->findOneBy(
                            array("teacher" => $teacher,
                                "questionCentury" => $questionCentury)
                    );
                    $date = new \DateTime('now');
                    if (count($existsAnswer) == 0) {
                        $answer = new TeacherAnswerCentury();
                        $answer->setCreateTime($date)
                                ->setUpdateTime($date)
                                ->setAnswerCategory($answerCategory)
                                ->setTeacher($teacher)
                                ->setQuestionCentury($questionCentury);
                    } else {
                        $answer = $existsAnswer;
                        $answer->setUpdateTime($date);
                        $answer->setAnswerCategory($answerCategory);
                    }
                    $manager->persist($answer);
                    $manager->flush();
                }
            }
            $questionCentury = $manager->getRepository("BackendBundle:QuestionCentury")->findBy(array("status" => 1));
            $answersTeacherCentury = $manager->getRepository($this::REPOSITORY)->findBy(array("teacher" => $teacher));

            if (count($questionCentury) == count($answersTeacherCentury)) {
                $teacher->setDidFinishXxiQuestionary(1);
                $manager->persist($teacher);
                $manager->flush();
            }
            return $helpers->json(array(
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡Los datos se guardaron correctamente!',
                        'id' => $answer->getId()
            ));
        }
        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Por favor verifica los datos'
        ));
    }

    public function getResultsAction(Request $request, $userId = null) {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");
        // Control de acceso
        $access_control = $this->get("app.access_control");
        if (empty($authorization)) {
            //return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        }

        $userData = $jwt_auth->checkToken($authorization, true);
        $accessGranted = $access_control->accessGrantedForAdmin($userData);
        if (is_array($accessGranted)) {
            //return $helpers->json($accessGranted);
        }
        return $this->getResult($helpers, $userId);
    }

    public function saveImageAction(Request $request) {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");
        // Control de acceso
        $access_control = $this->get("app.access_control");
        if (empty($authorization)) {
            //return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        }

        $userData = $jwt_auth->checkToken($authorization, true);
        $accessGranted = $access_control->accessGrantedForAdmin($userData);
        if (is_array($accessGranted)) {
            //return $helpers->json($accessGranted);
        }

        $image = $request->get("image", null);
        $userId = $request->get("teacherId", null);

        if ($image != null && $userId != null) {
            $manager = $this->getDoctrine()->getManager();
            $teacher = $manager->getRepository("BackendBundle:Teacher")->find($userId);

            $img = $image; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            if (!file_exists("uploads")) {
                mkdir("uploads");
            }
            if (!file_exists("uploads/evaluation_xxi_teacher_" . $teacher->getId())) {
                mkdir("uploads/evaluation_xxi_teacher_" . $teacher->getId());
            }
            $fileName = date("Ymd_his") . ".png";
            $dir = "uploads/evaluation_xxi_teacher_" . $teacher->getId();
            $filePath = $dir . "/" . $fileName;
            if (file_put_contents($filePath, $data)) {
                $teacher->setImageXxiFile($fileName);
                $manager->persist($teacher);
                $manager->flush();
                return $helpers->json(array(
                            'status' => 'success',
                            'title' => 'Imagen guardada correctamente',
                            'message' => '¡Los datos se guardaron correctamente!',
                            'file' => $teacher->getImageXxiFile(),
                            'id' => $teacher->getId()
                ));
            }
        }
        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'No se pudo guardar la gráfica',
                    'message' => '¡No se pudo guardar la gráfica!',
        ));
    }

    public function exportResultAction(Request $request, $teacherId = null) {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");
        // Control de acceso
        $access_control = $this->get("app.access_control");
        if (empty($authorization)) {
            //return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        }

        $userData = $jwt_auth->checkToken($authorization, true);
        $accessGranted = $access_control->accessGrantedForAdmin($userData);
        if (is_array($accessGranted)) {
            //return $helpers->json($accessGranted);
        }

        $this->logo = $this->container->getParameter('serverRoot') . "/assets/images/logosinadep.png";
        $this->server_api = $this->container->getParameter('serverRootApi');

        $pdf = new PDF($this->logo, null, $orientation = 'P', $unit = 'mm', $size = 'letter');
        $pdf->title = utf8_decode("RESULTADOS EVALUACION SIGLO XXI"); 
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12);
        $manager = $this->getDoctrine()->getManager();
        $teacher = $manager->getRepository("BackendBundle:Teacher")->find($teacherId);
        if (!file_exists("uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/result.pdf")) {
            $pdf->Cell(30, 10, "Profesor");
            $pdf->Cell(160, 10, utf8_decode($teacher->getFullname()));
            $dir = $this->server_api . "/uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/";
            $pathFile = $dir . $teacher->getImageXxiFile();
            $pdf->Image($pathFile, 30, 60, 130, 130);
            $data = $this->getResult($helpers, $teacherId, true);
            //var_dump(json_encode($data));exit;
            $pdf->Ln(140);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetDrawColor(255, 156, 0);
            $pdf->Cell(120, 10, "AREA", 'LRB');
            $pdf->Cell(35, 10, "RESULTADO", 'RB');
            $pdf->Cell(35, 10, "ESTADO", 'RB');
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0, 0, 0);
            $i = 0;
            foreach ($data as $skills) {
                foreach ($skills["areas"] as $area) {
                    $md = (strlen($skills["name"]) > 42) ? "..." : "";
                    if ($area["type"] == "Vulnerable") {
                        $r = 241;
                        $g = 212;
                        $b = 210;
                    } elseif ($area["type"] == "Competente") {
                        $r = 247;
                        $g = 229;
                        $b = 204;
                    } else {
                        $r = 211;
                        $g = 233;
                        $b = 211;
                    }
                    $pdf->SetFillColor($r, $g, $b);
                    $border = ($i == 0) ? 'BRL' : 1;
                    $pdf->Cell(120, 4, utf8_decode($area["name"]), $border, 0, '', true);
                    $pdf->Cell(35, 4, utf8_decode($area["result"]), $border, 0, '', true);
                    $pdf->Cell(35, 4, utf8_decode($area["type"]), $border, 0, '', true);
                    $pdf->Ln();
                    $i++;
                }
            }

            $pdf->Output("uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/result.pdf", 'F');
            if (file_exists("uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/result.pdf")) {
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
        } else {
            return $helpers->json(array(
                        'status' => 'success',
                        'title' => 'Exportado correctamente',
                        'message' => '¡Archivo exportado correctamente!',
                        'userId' => $teacher->getId()
            ));
        }
    }

    private function getResult($helpers, $teacherId, $returnArray = false) {
        $manager = $this->getDoctrine()->getManager();
        $teacher = $manager->getRepository("BackendBundle:Teacher")->find($teacherId);
        $didFinish = $teacher->getDidFinishXxiQuestionary();

        $teacherAnswers = $manager->getRepository($this::REPOSITORY)->findBy(
                array(
                    "teacher" => $teacher
                )
        );

        $i = 0;
        $data = array();
        $dat = array();
        foreach ($teacherAnswers as $answer) {

            $skillId = $answer->getQuestionCentury()->getAreaCentury()->getSkillCentury()->getId();
            $skill = $answer->getQuestionCentury()->getAreaCentury()->getSkillCentury()->getName();
            $value = $answer->getAnswerCategory()->getValue();
            $area = $answer->getQuestionCentury()->getAreaCentury()->getName();
            $minVulnerable = $answer->getQuestionCentury()->getAreaCentury()->getMinVulnerable();
            $maxVulnerable = $answer->getQuestionCentury()->getAreaCentury()->getMaxVulnerable();
            $minCompetent = $answer->getQuestionCentury()->getAreaCentury()->getMinCompetent();
            $maxCompetent = $answer->getQuestionCentury()->getAreaCentury()->getMaxCompetent();
            $minOptimum = $answer->getQuestionCentury()->getAreaCentury()->getMinOtimum();
            $maxOptimum = $answer->getQuestionCentury()->getAreaCentury()->getMaxOtimum();
            $categoryQ = $answer->getQuestionCentury()->getCategory()->getName();
            $categoryA = $answer->getAnswerCategory()->getCategory()->getName();
            $areaId = $answer->getQuestionCentury()->getAreaCentury()->getId();


            $data[$i]["value"] = $value;
            $data[$i]["skill"] = $skill;
            $data[$i]["area"] = $area;
            $data["areaVulnerable"][$areaId] = array(
                "min" => $minVulnerable,
                "max" => $maxVulnerable
            );
            $data["areaCompetent"][$areaId] = array(
                "min" => $minCompetent,
                "max" => $maxCompetent
            );
            $data["areaOptimum"][$areaId] = array(
                "min" => $minOptimum,
                "max" => $maxOptimum
            );
            $data[$areaId]["categoryFromQuestion"] = $categoryQ;
            $data[$areaId]["categoryFromAnswer"] = $categoryA;
            $i++;

            if (!isset($dat[$skill . "|-" . $skillId][$area . "|-" . $areaId])) {
                $dat[$skill . "|-" . $skillId][$area . "|-" . $areaId] = 0;
            }
            $dat[$skill . "|-" . $skillId][$area . "|-" . $areaId] += $value;
        }


        $data = array();
        $i = 0;
        foreach ($dat as $skill => $areas) {
            $j = 0;
            $arrayArea = array();
            foreach ($areas as $area => $value) {
                $exArea = explode("|-", $area);
                $areaFromBundle = $manager->getRepository("BackendBundle:AreaCentury")->find($exArea[1]);
                $type = "$value";
                $minVulnerable = $areaFromBundle->getMinVulnerable();
                $maxVulnerable = $areaFromBundle->getMaxVulnerable();
                $minCompetent = $areaFromBundle->getMinCompetent();
                $maxCompetent = $areaFromBundle->getMaxCompetent();
                $minOptimum = $areaFromBundle->getMinOtimum();
                $maxOptimum = $areaFromBundle->getMaxOtimum();
                if ($value >= $minVulnerable && $value <= $maxVulnerable) {
                    $type = "Vulnerable";
                } elseif ($value >= $minCompetent && $value <= $maxCompetent) {
                    $type = "Competente";
                } elseif ($value >= $minOptimum && $value <= $maxOptimum) {
                    $type = "Óptimo";
                }

                $arrayArea[$j] = array(
                    "name" => $exArea[0],
                    "type" => $type,
                    "result" => intval($value),
                    "vulnerableRange" => array(
                        "min" => intval($minVulnerable),
                        "max" => intval($maxVulnerable)
                    ),
                    "competentRange" => array(
                        "min" => intval($minCompetent),
                        "max" => intval($maxCompetent)
                    ),
                    "optimumRange" => array(
                        "min" => intval($minOptimum),
                        "max" => intval($maxOptimum)
                    )
                );
                $j++;
            }
            $exSkill = explode("|-", $skill);
            $data[] = array("skillId" => intval($exSkill[1]), "name" => $exSkill[0], "areas" => $arrayArea);
            $i++;
        }
        $status = "success";
        $title = "Lista de resultados por habilidad y area";
        if (count($data) == 0) {
            $status = "error";
            $title = "No se encontro ningún resultado";
        }

        if (!$returnArray) {
            return $helpers->json(
                            array(
                                'status' => $status,
                                'title' => $title,
                                'data' => $data,
                                'didFinish' => $didFinish
            ));
        } else {
            return $data;
        }
    }

    public function exportResultToExcelAction(Request $request, $teacherId = null) {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");
        // Control de acceso
        $access_control = $this->get("app.access_control");
        if (empty($authorization)) {
            //return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        }

        $userData = $jwt_auth->checkToken($authorization, true);
        $accessGranted = $access_control->accessGrantedForAdmin($userData);
        if (is_array($accessGranted)) {
            //return $helpers->json($accessGranted);
        }
        if ($teacherId != null) {

            $this->logo = $this->container->getParameter('serverRoot') . "/assets/images/logosinadep.png";
            $this->server_api = $this->container->getParameter('serverRootApi');

            $manager = $this->getDoctrine()->getManager();

            $teacher = $manager->getRepository('BackendBundle:Teacher')->find($teacherId);
            $pathToUploadDir = "uploads/evaluation_xxi_teacher_" . $teacher->getId() . "/";

            if (!file_exists("uploads")) {
                mkdir("uploads");
            }
            if (!file_exists($pathToUploadDir)) {
                mkdir($pathToUploadDir);
            }


            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->getProperties()->setCreator("SINADEP")
                    ->setLastModifiedBy("SINADEP")
                    ->setTitle("Resultado de Evaluación HABILIDADES SIGLO XXI " . $teacher->getFullname())
                    ->setSubject("Documento exportado desde sistema")
                    ->setDescription("Resultado de Evaluación HABILIDADES SIGLO XXI.")
                    ->setKeywords("Resultado de Evaluación HABILIDADES SIGLO XXI")
                    ->setCategory("Report");
            $objPHPExcel->setActiveSheetIndex(0);

            $activeSheet = $objPHPExcel->getActiveSheet();
            $letter = "A";
            $j = 1;
            $titulosRowCols = array(
                'borders' => array(
                    'outline' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => 'FF000000'),
                    ),
                ),
                'font' => array(
                    'bold' => true
                ),
            );

            $j = $this->putImageOnSheet($j, $activeSheet, $this->logo, 5);

            $activeSheet->setCellValue($letter . $j, "RESULTADOS EVALUACIÓN SIGLO XXI");
            $activeSheet->getStyle($letter . $j)->getFont()->setSize(30);
            $activeSheet->mergeCells($letter . $j . ':L' . ($j + 2));

            $j += 4;

            $activeSheet->setCellValue($letter . $j, "Profesor: ");
            $letter++;
            $activeSheet->setCellValue($letter . $j, $teacher->getFullname());
            $letter--;
            $j += 3;

            $j++;

            $letter = "A";
            $j = $this->putImageOnSheet($j, $activeSheet, $pathToUploadDir . $teacher->getImageXxiFile(), 45);


            $data = $this->getResult($helpers, $teacherId, true);
            $letter = "A";
            $activeSheet->setCellValue($letter . $j, "AREA");
            $letter++;
            $activeSheet->setCellValue($letter . $j, "RESULTADO");
            $letter++;
            $activeSheet->setCellValue($letter . $j, "ESTADO");
            $j++;
            foreach ($data as $skills) {

                foreach ($skills["areas"] as $area) {
                    $letter = "A";
                    if ($area["type"] == "Vulnerable") {
                        $r = 241;
                        $g = 212;
                        $b = 210;
                    } elseif ($area["type"] == "Competente") {
                        $r = 247;
                        $g = 229;
                        $b = 204;
                    } else {
                        $r = 211;
                        $g = 233;
                        $b = 211;
                    }
                    $activeSheet->setCellValue($letter . $j, $area["name"]);
                    $letter++;
                    $activeSheet->setCellValue($letter . $j, $area["result"]);
                    $letter++;
                    $activeSheet->setCellValue($letter . $j, $area["type"]);
                    $j++;
                }
            }


            $name = "result.xlsx";
            $objPHPExcel->getActiveSheet()->setTitle("Evaluación");
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($pathToUploadDir . "/$name");
            unlink('logo.png');
        }


        return $helpers->json(array(
                    'status' => 'success',
                    'title' => 'Exportado correctamente',
                    'message' => '¡Archivo exportado correctamente!',
                    'url' => $this->container->getParameter('serverRootApi') . "/" . $pathToUploadDir . $name,
                    'userId' => $teacher->getId()
        ));
    }

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

}

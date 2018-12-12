<?php

namespace AppBundle\Controller {

    use BackendBundle\Entity\AnswerInee;
    use BackendBundle\Entity\EvaluationInee;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Config\Definition\Exception\Exception;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 07/08/17
     * Time: 23:31
     */
    class EvaluationIneeController extends Controller
    {
        /**
         * Add new question
         * @param Request $request
         * @return mixed
         */
        public function createAction(Request $request)
        {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $params = json_decode($request->get("json", null));

            if (!empty($params)) {
                $education_level 	= (property_exists($params, "education_level"))  ? $params->education_level  : null;
                $teacher_function 	= (property_exists($params, "teacher_function")) ? $params->teacher_function : null;
                $dimension 			= (property_exists($params, "dimension")) 		 ? $params->dimension 		: null;
                $parameter 			= (property_exists($params, "parameter")) 		 ? $params->parameter 		: null;
                $indicator 			= (property_exists($params, "indicator")) 		 ? $params->indicator 		: null;
                $reagent_base 		= (property_exists($params, "reagent_base"))  	 ? strip_tags($params->reagent_base) 	: null;
                $argumentation 		= (property_exists($params, "argumentation")) 	 ? strip_tags($params->argumentation) 	: null;
                $answerCollection	= (property_exists($params, "answerCollection")) ? $params->answerCollection : null;
                $correctAnswer	  	= (property_exists($params, "correctAnswer")) 	 ? $params->correctAnswer 	: null;

                $validator = $this->get('validator');
                $question = new EvaluationInee();
                $question->setArgumentation($argumentation)
                    ->setReagentBase($reagent_base)
                    ->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level))
                    ->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function))
                    ->setDimension($this->getDoctrine()->getRepository('BackendBundle:Dimension')->find($dimension))
                    ->setParameter($this->getDoctrine()->getRepository('BackendBundle:Parameter')->find($parameter))
                    ->setIndicator($this->getDoctrine()->getRepository('BackendBundle:Indicator')->find($indicator))
                    ->setCreateTime(new \DateTime('now'));

                if (count($validator->validate($question)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($question);
                    $manager->flush();

                    $correctAnswerId = null;
                    $answersResponse = [];

                    foreach ($answerCollection as $answer) {
                        $answerArray = [];
                        $answerInee = new AnswerInee();
                        $answerInee->setTitle($answer)
                            ->setEvaluationInee($this->getDoctrine()->getRepository('BackendBundle:EvaluationInee')->find($question->getId()))
                            ->setCreateTime(new \DateTime('now'));
                        $manager->persist($answerInee);
                        $manager->flush();
                        $answerArray['id'] = $answerInee->getId();
                        $answerArray['title'] = $answerInee->getTitle();
                        array_push($answersResponse, $answerArray);
                        if ($correctAnswer == $answer) {
                            $correctAnswerId = $answerInee->getId();
                        }
                    }

                    $correct = $this->getDoctrine()->getRepository('BackendBundle:AnswerInee')->find($correctAnswerId);
                    $question->setCorrectAnswer($correct);
                    $manager->persist($question);
                    $manager->flush();

                    return $helpers->json([
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡Los datos se guardaron correctamente!',
                        'data' => [
                            'id' => $question->getId(),
                            'reagentBase' => $question->getReagentBase(),
                            'argumentation' => $question->getArgumentation(),
                            'answers' => $answersResponse,
                            'correctAnswer' => $correct->getTitle()
                        ]
                    ]);
                }
            }
            return $helpers->json(array(
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Error al crear la evaluacion.'
            ));
        }

        /**
         * Import questions from CSV
         * @param Request $request
         * @return mixed
         */
        public function importAction(Request $request)
        {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $file = $request->files->get('file', null);
            $params = json_decode($request->get("data", null));

            if (!empty($file) || empty($params)) {
                $ext = $file->getClientOriginalExtension();

                if ($ext != 'csv') {
                    return $helpers->json([
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'El archivo no es compatible'
                    ]);
                }

                $fileName = time() . "." . $ext;
                $path = "uploads/tmp";
                $file->move($path, $fileName);
                $finalPath = $path . DIRECTORY_SEPARATOR . $fileName;
                $import = $this->get("app.import_inee");
                $totalItemsImport = $import->execute($finalPath, $params);

                return $helpers->json([
                    'status' => 'success',
                    'title' => 'Importación exitosa',
                    'message' => 'Se han importado ' . $totalItemsImport . ' elementos'
                ]);
            }

            return $helpers->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'No se ha podido procesar el archivo'
            ]);

        }

        /**
         * Get evaluation
         * @param Request $request
         * @param $educationLevelId
         * @param $teacherFunctionId
         * @return mixed
         */
        public function filterEvaluationAction(Request $request, $educationLevelId, $teacherFunctionId)
        {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $questions = $this->getDoctrine()->getRepository('BackendBundle:EvaluationInee')->findBy([
                'educationLevel' => $educationLevelId,
                'teacherFunction' => $teacherFunctionId
            ]);

            if(!$questions) {
                return $helpers->json([]);
            }

            $evaluation = [];
            foreach ($questions as $question) {
                $answers = $this->getDoctrine()->getRepository('BackendBundle:AnswerInee')->findBy([
                    'evaluationInee' => $question->getId()
                ]);

                if(empty($answers)) {
                    continue;
                }

                $_answers = [];
                foreach ($answers as $answer) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    array_push($_answers, [
                        'id' => $answer->getId(),
                        'title' => $answer->getTitle()
                    ]);
                }

                $correct = $question->getCorrectAnswer();
                $_correct = isset($correct) ? $correct->getTitle() : null;

                /** @noinspection PhpUndefinedMethodInspection */
                array_push($evaluation, [
                    'id' => $question->getId(),
                    'reagentBase' => $question->getReagentBase(),
                    'argumentation' => $question->getArgumentation(),
                    'answers' => $_answers,
                    'correctAnswer' => $_correct
                ]);
            }
            return $helpers->json($evaluation);
        }

        /**
         * Delete one question
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function deleteAction(Request $request, $id)
        {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $manager = $this->getDoctrine()->getManager();

            try {
                $question = $this->getDoctrine()->getRepository('BackendBundle:EvaluationInee')->find($id);

                if(!is_object($question)) {
                    return $helpers->json([
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => '¡Ocurrio un error al eliminar el reactivo!'
                    ]);
                }

                $manager->remove($question);
                $manager->flush();

                return $helpers->json([
                    'status' => 'success',
                    'title' => 'Borrado',
                    'message' => '¡El reactivo se ha eliminado con éxito!'
                ]);
            } catch (Exception $e) {
                return $helpers->json([
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => '¡Ocurrio un error al eliminar el reactivo!'
                ]);
            }
        }

        /**
         * View single question
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function viewAction(Request $request, $id)
        {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $question = $this->getDoctrine()->getRepository('BackendBundle:EvaluationInee')->find($id);

            if(!$question) {
                return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => '¡Reactivo no encontrado!'
                ));
            }

            $answers = $this->getDoctrine()->getRepository('BackendBundle:AnswerInee')->findBy([
                'evaluationInee' => $question
            ]);

            $_answers = [];
            foreach ($answers as $answer) {
                /** @noinspection PhpUndefinedMethodInspection */
                array_push($_answers, [
                    'id' => $answer->getId(),
                    'title' => $answer->getTitle()
                ]);
            }

            $correct = $question->getCorrectAnswer();
            $_correct = isset($correct) ? $correct->getTitle() : null;

            $_question = [
                'id' => $question->getId(),
                'education_level' => $question->getEducationLevel()->getId(),
                'teacher_function' => $question->getTeacherFunction()->getId(),
                'dimension' => $question->getDimension()->getId(),
                'parameter' => $question->getParameter()->getId(),
                'indicator' => $question->getIndicator()->getId(),
                'reagent_base' => $question->getReagentBase(),
                'argumentation' => $question->getArgumentation(),
                'answers' => $_answers,
                'correctAnswer' => $_correct
            ];

            return $helpers->json($_question);
        }

        /**
         * Update question
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function updateAction(Request $request, $id)
        {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $params = json_decode($request->get("json", null));
            $question = $this->getDoctrine()->getRepository('BackendBundle:EvaluationInee')->find($id);
            $manager = $this->getDoctrine()->getManager();

            if(!empty($params) && is_object($question)) {
                $education_level = (property_exists($params, "education_level")) ? $params->education_level : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? $params->teacher_function : null;
                $dimension = (property_exists($params, "dimension")) ? $params->dimension : null;
                $parameter = (property_exists($params, "parameter")) ? $params->parameter : null;
                $indicator = (property_exists($params, "indicator")) ? $params->indicator : null;
                $reagent_base = (property_exists($params, "reagent_base")) ? $params->reagent_base : null;
                $argumentation = (property_exists($params, "argumentation")) ? $params->argumentation : null;
                $answerCollection = (property_exists($params, "answerCollection")) ? $params->answerCollection : null;
                $correctAnswer = (property_exists($params, "correctAnswer")) ? $params->correctAnswer : null;

                $question->setArgumentation($argumentation)
                    ->setReagentBase($reagent_base)
                    ->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level))
                    ->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function))
                    ->setDimension($this->getDoctrine()->getRepository('BackendBundle:Dimension')->find($dimension))
                    ->setParameter($this->getDoctrine()->getRepository('BackendBundle:Parameter')->find($parameter))
                    ->setIndicator($this->getDoctrine()->getRepository('BackendBundle:Indicator')->find($indicator))
                    ->setCorrectAnswer(null)
                    ->setUpdateTime(new \DateTime('now'));

                $manager->persist($question);
                $manager->flush();

                $correctAnswerId = null;
                $answersResponse = [];

                foreach ($answerCollection as $answer) {
                    $answerArray = [];
                    if(is_null($answer->id)) {
                        $answerInee = new AnswerInee();
                        $answerInee->setTitle($answer->title)
                            ->setEvaluationInee($question)
                            ->setCreateTime(new \DateTime('now'));
                        $manager->persist($answerInee);
                        $manager->flush();
                        $answerArray['id'] = $answerInee->getId();
                        $answerArray['title'] = $answerInee->getTitle();
                        array_push($answersResponse, $answerArray);
                        if ($correctAnswer == $answer->title) {
                            $correctAnswerId = $answerInee->getId();
                        }
                    } else {
                        $answerArray['id'] = $answer->id;
                        $answerArray['title'] = $answer->title;
                        array_push($answersResponse, $answerArray);
                        if ($correctAnswer == $answer->title) {
                            $correctAnswerId = $answer->id;
                        }
                    }

                    if(property_exists($answer, 'removed')) {
                        $answerInee = $this->getDoctrine()->getRepository(AnswerInee::class)->find($answer->id);
                        $answerInee->setEvaluationInee(null);
                        $manager->persist($answerInee);
                        $manager->remove($answerInee);
                        $manager->flush();
                    }
                }

                $correct = $this->getDoctrine()->getRepository('BackendBundle:AnswerInee')->find($correctAnswerId);
                $question->setCorrectAnswer($correct);
                $manager->persist($question);
                $manager->flush();

                return $helpers->json([
                    'status' => 'success',
                    'title' => 'Guardado',
                    'message' => '¡Los datos se actualizaron correctamente!'
                ]);
            }

            return $helpers->json(array(
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Error al actualizar el reactivo'
            ));
        }
    }
}
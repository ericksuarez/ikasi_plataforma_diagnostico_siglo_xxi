<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\QuestionCentury;
use BackendBundle\Entity\Category;
use BackendBundle\Entity\AreaCentury;
use BackendBundle\Entity\AnswerCategory;
use BackendBundle\Entity\User;
use BackendBundle\Entity\TeacherAnswerCentury;
use BackendBundle\Entity\Teacher;
use BackendBundle\Entity\AnswerCentury;

class QuestionCenturyController extends Controller {

    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:QuestionCentury";

    public function newAction(Request $request) {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");
        // Control de acceso
        $access_control = $this->get("app.access_control");
        if (empty($authorization)) {
            return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        }

        $userData = $jwt_auth->checkToken($authorization, true);
        $accessGranted = $access_control->accessGrantedForAdmin($userData);
        if (is_array($accessGranted)) {
            return $helpers->json($accessGranted);
        }

        $params = json_decode($request->get("json", null));

        if (!empty($params) && $params != null) {

            if (isset($params->name) && isset($params->area_id) && isset($params->category_id)) {
                $name = (property_exists($params, "name")) ? $params->name : null;
                $manager = $this->getDoctrine()->getManager();

                $category = $manager->getRepository("BackendBundle:Category")->find($params->category_id);
                $areaCentury = $manager->getRepository("BackendBundle:AreaCentury")->find($params->area_id);
                $questionExist = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $name));
                $questionExist = [];
                if (count($questionExist) == 0) {
                    $question = new QuestionCentury();
                    $date = new \DateTime('now');
                    $question->setName($name)
                            ->setCategory($category)
                            ->setAreaCentury($areaCentury)
                            ->setCreateTime($date)
                            ->setUpdateTime($date);
                    $manager->persist($question);
                    $manager->flush();
                    $areaName = $question->getAreaCentury()->getName();
                    $skillName = $question->getAreaCentury()->getSkillCentury()->getName();
                    $categoryName = $question->getCategory()->getName();
                    return $helpers->json(array(
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se guardaron correctamente!',
                                'id' => $question->getId(),
                                'name' => $question->getName(),
                                'areaName' => $areaName,
                                'skillName' => $skillName,
                                'categoryName' => $categoryName
                    ));
                } else {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => '¡Valor duplicado!'
                    ));
                }
            }
        }
        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Por favor verifica los datos'
        ));
    }

    public function listAction(Request $request, $areaId = null, $categoryId = null) {
        $helpers = $this->get("app.helpers");
        $manager = $this->getDoctrine()->getManager();
        $category = $manager->getRepository("BackendBundle:Category")->find($categoryId);
        $area = $manager->getRepository("BackendBundle:AreaCentury")->find($areaId);
        $questions = $manager->getRepository($this::REPOSITORY)->findBy(array("category" => $category, "areaCentury" => $area));
        return $helpers->json([
                    'status' => "success",
                    'message' => "Lista de preguntas",
                    'data' => $questions
        ]);
    }

    public function getQuestionByAreaAction(Request $request, $areaId = null, $userId = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            //return $helpers->json($comprobar);
        }

        if (isset($areaId) && $areaId > 0) {
            $areaCentury = $repository = $this->getDoctrine()->getManager()->getRepository('BackendBundle:AreaCentury')->find(intval($areaId));

            $skill = $man = $this->getDoctrine()->getManager()->getRepository("BackendBundle:SkillCentury")->findOneBy(array("id" => $areaCentury->getSkillCentury()));

            $em = $this->getDoctrine()->getRepository($this::REPOSITORY);
            $manager = $this->getDoctrine()->getManager();
            $questionsCategory = $em->findBy(array("areaCentury" => $areaCentury, "status" => 1), array("category" => "ASC"));
            $data = array();
            $i = 0;
            $j = 0;
            $tmp = 0;
            $user = $manager->getRepository("BackendBundle:User")->find($userId);

            $teacher = $manager->getRepository("BackendBundle:Teacher")->findOneBy(array("user" => $user));

            foreach ($questionsCategory as $question) {
                if ($tmp != $question->getCategory()->getId()) {
                    $i = 0;
                }
                $questions[$question->getCategory()->getId()][$i]["name"] = $question->getName();
                $questions[$question->getCategory()->getId()][$i]["id"] = $question->getId();
                $question = $manager->getRepository($this::REPOSITORY)->find($question->getId());
                $answerByQuestion = $manager->getRepository("BackendBundle:AnswerCentury")->findBy(array("questionCentury" => $question));

                if (isset($answerByQuestion)) {
                    $questions[$question->getCategory()->getId()][$i]["answers"] = $answerByQuestion;
                } else {
                    $questions[$question->getCategory()->getId()][$i]["answers"] = array();
                }

                $answer = $manager->getRepository("BackendBundle:TeacherAnswerCentury")->findOneBy(
                        array(
                            "teacher" => $teacher,
                            "questionCentury" => $question
                ));
                if (isset($answer)) {
                    $questions[$question->getCategory()->getId()][$i]["answerId"] = $answer->getAnswerCategory()->getId();
                } else {
                    $questions[$question->getCategory()->getId()][$i]["answerId"] = 0;
                }
                $i++;

                $tmp = $question->getCategory()->getId();
            }
            $i = 0;
            $tmp = "";
            foreach ($questionsCategory as $question) {
                $category = $question->getCategory();
                $categoryId = $question->getCategory()->getId();
                $j = 0;
                if ($tmp != $category->getName()) {
                    $data["categories"][$i]["name"] = $category->getName();
                    $data["categories"][$i]["id"] = $categoryId;
                    $data["categories"][$i]["questions"] = $questions[$categoryId];
                    $manager = $this->getDoctrine()->getManager();
                    $category = $manager->getRepository("BackendBundle:Category")->findOneBy(array("id" => $categoryId));
                    $answers = $manager->getRepository("BackendBundle:AnswerCategory")->findBy(array("category" => $category));
                    $data["categories"][$i]["answersOfCategory"] = $answers;
                    $i++;
                }
                $tmp = $category->getName();
            }


            $answers = $data;
            $status = "error";
            $message = "No se encontro ningún resultado";
            if (count($answers) > 0) {
                $status = "success";
                $message = "Lista de preguntas";
            }
            return $helpers->json([
                        'status' => $status,
                        'message' => $message,
                        'skill_century' => $skill->getName(),
                        'data' => $answers
            ]);
        }
    }

    public function importQuestionaryAction(Request $request, $areaId = null, $categoryId = null, $replace = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            //return $helpers->json($comprobar);
        }
        $hash = $request->get("Authorization", null);
        if ($areaId != null && $categoryId != null && $replace != null) {
            $file = $request->files->get('csv', null);
            $ext = $file->guessExtension();
            if ($ext == "csv" || $ext == "txt") {
                $manager = $this->getDoctrine()->getManager();
                $category = $manager->getRepository("BackendBundle:Category")->find($categoryId);
                $areaCentury = $manager->getRepository("BackendBundle:AreaCentury")->find($areaId);
                $lineas = file($file);
                $i = 0;
                $idsQuestions = array();
                if ($replace == 1) {
                    $qr = $manager->createQueryBuilder();
                    $q = $qr
                            ->update($this::REPOSITORY, 'r')
                            ->set('r.status', 0)
                            ->andWhere('r.category = :category')->setParameter('category', $category)
                            ->andWhere('r.areaCentury = :areaCentury')->setParameter('areaCentury', $areaCentury)
                            ->getQuery();
                    $q->execute();
                }
                foreach ($lineas as $linea_num => $linea) {
                    if ($i > 0) {
                        $question = new QuestionCentury();
                        $now = new \DateTime('now');
                        $question->setCreateTime($now);
                        $question->setUpdateTime($now);
                        $question->setAreaCentury($areaCentury);
                        $question->setCategory($category);
                        $column = explode(',', utf8_encode($linea));
                        $lastPosition = count($column) - 1;
                        $stringQuestion = "";
                        for ($j = 0; $j < $lastPosition; $j++) {
                            $stringQuestion .= $column[$j] . ", ";
                        }
                        $stringQuestion = trim($stringQuestion, ", ");
                        $answer = trim($column[$lastPosition]);
                        $question->setName($stringQuestion);
                        $existQuestion = $manager->getRepository($this::REPOSITORY)->findOneBy(
                                array(
                                    "name" => $question->getName(),
                                    "category" => $category,
                                    "areaCentury" => $areaCentury,
                                    "status" => 1
                                )
                        );
                        if (count($existQuestion) > 0) {
                            $question = $existQuestion;
                        } else {
                            $manager->persist($question);
                            $manager->flush();
                        }
                        if ($answer != '') {
                            $answerObj = new AnswerCentury();
                            $answerObj->setName($answer);
                            $answerObj->setQuestionCentury($question);
                            $answerObj->setCreateTime($now);
                            $answerObj->setUpdateTime($now);
                            $manager->persist($answerObj);
                            $manager->flush();
                        }
                        array_push($idsQuestions, $question->getId());
                    }
                    $i++;
                }
            }
        }
        if (count($idsQuestions) > 0) {
            $status = "success";
            $message = "Lista de preguntas";
        }
        return $helpers->json([
                    'status' => $status,
                    'message' => $message,
                    'data' => $idsQuestions
        ]);
    }

}

<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\AnswerCentury;

class AnswerQuestionCenturyController extends Controller{

    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:AnswerCentury";

    public function listAction(Request $request, $id = null){
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }

        if ($id != null && $id > 0) {
            $manager = $this->getDoctrine()->getManager();
            $question = $manager->getRepository("BackendBundle:QuestionCentury")->find($id);
            $answers = $manager->getRepository($this::REPOSITORY)->findBy(array("questionCentury" => $question));
            if (count($answers) > 0) {
                $page = $request->query->getInt("page", 1);
                $paginator = $this->get("knp_paginator");
                $items_per_page = 10;

                $pagination = $paginator->paginate($answers, $page, $items_per_page);
                /** @noinspection PhpUndefinedMethodInspection */
                $total_items = $pagination->getTotalItemCount();
                return $helpers->json(
                    array(
                        'status' => 'success',
                        'title' => 'Lista de Categorias',
                        'pregunta'=>$question->getName(),
                        'data' => $pagination,
                        'total_items' => $total_items,
                        'page_actual' => $page,
                        'items_per_page' => $items_per_page,
                        'total_pages' => ceil($total_items / $items_per_page)
                    ));
            }
        }
        return $helpers->json(array('status' => 'error', 'title' => 'Sin resultados', 'message' => 'No se encontrarón resultados'));
    }

    public function newAction(Request $request, $id=null){
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }

        $params = json_decode($request->get("json", null));
        if (!empty($params) && $params != null) {
            $manager = $this->getDoctrine()->getManager();
            $name = (isset($params->name)) ? $params->name : null;

            if ($id > 0 && $id != null && $name != "") {
                $question = $manager->getRepository("BackendBundle:QuestionCentury")->find($id);
                $exist = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $name, "questionCentury" => $question));
                if (count($exist) == 0) {
                    $answerQuestion = new AnswerCentury();
                    $answerQuestion->setQuestionCentury($question);
                    $answerQuestion->setCreateTime(new \DateTime('now'));
                    $answerQuestion->setUpdateTime(new \DateTime('now'));
                    $answerQuestion->setName($name);
                    $manager->persist($answerQuestion);
                    $manager->flush();
                    return $helpers->json(array(
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => 'Respuesta guardada correctamente',
                        'id' => $answerQuestion->getId(),
                        'name' => $answerQuestion->getName()
                    ));
                } else {
                    return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Respuesta duplicada'
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
}
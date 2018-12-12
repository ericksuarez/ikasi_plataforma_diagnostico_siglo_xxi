<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\SkillCentury;

class SkillCenturyController extends Controller {

    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:SkillCentury";

    /**
     * Agrega una nueva habilidad de siglo XXI
     * @return type
     */
    public function createAction(Request $request) {
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
            if (isset($params->name)) {
                $name = (property_exists($params, "name")) ? $params->name : null;

                $manager = $this->getDoctrine()->getManager();

                $skillExist = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $name));
                if (count($skillExist) == 0) {
                    $skill = new SkillCentury();
                    $date = new \DateTime('now');
                    $skill->setName($name);
                    $skill->setCreateTime($date);
                    $skill->setUpdateTime($date);
                    $skill->setStatus(1);
                    $skill->setDeleteTime(new \DateTime('0000-00-00 00:00:00'));

                    $manager->persist($skill);
                    $manager->flush();
                    return $helpers->json(array(
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se guardaron correctamente!',
                                'id' => $skill->getId(),
                                'name' => $skill->getName()
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

    /**
     * 
     * @param Request $request
     * @param type $id
     */
    public function editAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }

        $params = json_decode($request->get("json", null));
        if (!empty($params) && $params != null && $id != null) {
            $name = (property_exists($params, "name")) ? $params->name : null;
            $manager = $this->getDoctrine()->getManager();
            $skill = $manager->getRepository($this::REPOSITORY)->findOneBy(array("id" => $id));
            if ($skill != null) {
                $skillExist = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $name));

                if (count($skillExist) == 0 || $id == $skillExist->getId()) {
                    $skill->setName($name)
                            ->setUpdateTime(new \DateTime('now'));
                    $manager->persist($skill);
                    $manager->flush();
                    return $helpers->json(array(
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se modificaron correctamente!',
                                'id' => $skill->getId(),
                                'name' => $skill->getName()
                    ));
                } else {
                    return $helpers->json(array(
                                'status' => 'error',
                                'title' => 'Error',
                                'message' => '¡Valor duplicado!'
                    ));
                }
            } else {
                return $helpers->json(array(
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => '¡No existe!'
                ));
            }
        }

        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Por favor verifica los datos'
        ));
    }

    /**
     * Regresa un array con la lista de habilidades paginadas a 10 resultados
     * por página
     * @param Request $request
     * @return type
     */
    public function listAction(Request $request) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            //return $helpers->json($comprobar);
        }

        $page = $request->query->getInt("page", 1);
        $paginator = $this->get("knp_paginator");
        $items_per_page = 10;

//        $pagination = $skills = $this->getDoctrine()->getRepository($this::REPOSITORY)->findAll();
        $pagination = $skills = $this->getDoctrine()->getRepository($this::REPOSITORY)->findBy(array("status" => 1));
        $total_items = count($skills);
        if ($page > 0) {
            $pagination = $paginator->paginate($skills, $page, $items_per_page);
            $total_items = $pagination->getTotalItemCount();
        }
        /** @noinspection PhpUndefinedMethodInspection */
        return $helpers->json([
                    'total_items' => $total_items,
                    'page_actual' => $page,
                    'items_per_page' => $items_per_page,
                    'total_pages' => ceil($total_items / $items_per_page),
                    'data' => $pagination
        ]);
    }

    /**
     * Devuelve un listado con todas las especialidades
     * @return mixed
     */
    public function deleteAction($id) {
        $helpers = $this->get("app.helpers");

        $skill = $this->getDoctrine()->getRepository($this::REPOSITORY)->find($id);
        $validator = $this->get('validator');

        $skill->setDeleteTime(new \DateTime('now'));
        $skill->setStatus(0);

        if (count($validator->validate($skill)) == 0) {
            /** @noinspection PhpUndefinedMethodInspection */
            $query = $this->getDoctrine()->getManager();
            $query->persist($skill);
            $query->flush();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                        'status' => 200,
                        'title' => '¡Correcto!',
                        'message' => 'Se ha eliminado correctamente el elemento.'
            ));
        }

        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Error al tratar de eliminar, el registro.'
        ));
    }

    /**
     * Regresa un array con la lista de habilidades paginadas a 10 resultados
     * por página
     * @param Request $request
     * @return type
     */
    public function viewAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");

        $manager = $this->getDoctrine()->getManager();
        $skill = $manager->getRepository($this::REPOSITORY)->findOneBy(array("id" => $id));

        return $helpers->json(array(
                    'status' => 'success',
                    'id' => $skill->getId(),
                    'name' => $skill->getName()
        ));
    }

    /**
     * Devuelve un listado con todas las especialidades
     * @return mixed
     */
    public function deleteQuestionAction($id) {
        $helpers = $this->get("app.helpers");

        $skill = $this->getDoctrine()->getRepository("BackendBundle:QuestionCentury")->find($id);
        $validator = $this->get('validator');

        if (count($validator->validate($skill)) == 0) {
            /** @noinspection PhpUndefinedMethodInspection */
            $query = $this->getDoctrine()->getManager();
            $query->remove($skill);
            $query->flush();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                        'status' => 200,
                        'title' => '¡Correcto!',
                        'message' => 'Se ha eliminado correctamente el elemento.'
            ));
        }

        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Error al tratar de eliminar, el registro.'
        ));
    }
}
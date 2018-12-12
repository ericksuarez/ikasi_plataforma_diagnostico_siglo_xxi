<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\AreaCentury;

class AreaCenturyController extends Controller
{

    //put your code here
    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:AreaCentury";

    /**
     * Agrega un area nueva con sus rangos de calificaciones
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request)
    {
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
            $name = (isset($params->name)) ? $params->name : null;
            $skill_id = (isset($params->skill_century_id)) ? $params->skill_century_id : null;

            $min_vulnerable = (isset($params->min_vulnerable)) ? $params->min_vulnerable : null;
            $max_vulnerable = (isset($params->max_vulnerable)) ? $params->max_vulnerable : null;

            $min_competent = (isset($params->min_competent)) ? $params->min_competent : null;
            $max_competent = (isset($params->max_competent)) ? $params->max_competent : null;

            $min_optimum = (isset($params->min_optimum)) ? $params->min_optimum : null;
            $max_optimum = (isset($params->max_optimum)) ? $params->max_optimum : null;


            if ($name != null && $skill_id != null && $min_vulnerable != null && $max_vulnerable != null && $min_competent != NULL && $max_competent != null && $min_optimum != NULL && $max_optimum != null) {

                $compareRangse = $this->compareRangeOfGrade($min_vulnerable, $max_vulnerable, $min_competent, $max_competent, $min_optimum, $max_optimum);

                if (is_array($compareRangse)) {
                    return $helpers->json($compareRangse);
                } else {

                    $areaCentury = new AreaCentury();
                    $manager = $this->getDoctrine()->getManager();
                    $skillCentury = $manager->getRepository("BackendBundle:SkillCentury")->findOneBy(array("id" => $skill_id));

                    $areaCentury->setCreateTime(new \DateTime('now'));
                    $areaCentury->setUpdateTime(new \DateTime('now'));
                    $areaCentury->setMaxCompetent($max_competent);
                    $areaCentury->setMaxOtimum($max_optimum);
                    $areaCentury->setMaxVulnerable($max_vulnerable);
                    $areaCentury->setMinCompetent($min_competent);
                    $areaCentury->setMinOtimum($min_optimum);
                    $areaCentury->setMinVulnerable($min_vulnerable);
                    $areaCentury->setName($name);
                    $areaCentury->setSkillCentury($skillCentury);
                    $areaCentury->setStatus(1);

                    $manager->persist($areaCentury);
                    $manager->flush();

                    return $helpers->json(array(
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡Los datos se guardaron correctamente!',
                        'id' => $areaCentury->getId(),
                        'name' => $areaCentury->getName()
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
     * Edita el nombre y el rango de calificaciones
     * @param Request $request
     * @param type $id
     * @return type
     */
    public function editAction(Request $request, $id = null)
    {
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
        if (!empty($params) && $params != null && $id != null & $id > 0) {
            $name = (isset($params->name)) ? $params->name : null;

            $min_vulnerable = (isset($params->min_vulnerable)) ? $params->min_vulnerable : null;
            $max_vulnerable = (isset($params->max_vulnerable)) ? $params->max_vulnerable : null;

            $min_competent = (isset($params->min_competent)) ? $params->min_competent : null;
            $max_competent = (isset($params->max_competent)) ? $params->max_competent : null;

            $min_optimum = (isset($params->min_optimum)) ? $params->min_optimum : null;
            $max_optimum = (isset($params->max_optimum)) ? $params->max_optimum : null;


            if ($name != null && $min_vulnerable != null && $max_vulnerable != null && $min_competent != NULL && $max_competent != null && $min_optimum != NULL && $max_optimum != null) {

                $manager = $this->getDoctrine()->getManager();

                $areaCentury = $manager->getRepository("BackendBundle:AreaCentury")->findOneBy(array("id" => $id));
                if (count($areaCentury) > 0) {
                    $areaCentury->setCreateTime(new \DateTime('now'));
                    $areaCentury->setMaxCompetent($max_competent);
                    $areaCentury->setMaxOtimum($max_optimum);
                    $areaCentury->setMaxVulnerable($max_vulnerable);
                    $areaCentury->setMinCompetent($min_competent);
                    $areaCentury->setMinOtimum($min_optimum);
                    $areaCentury->setMinVulnerable($min_vulnerable);
                    $areaCentury->setName($name);
                    $areaCentury->setStatus(1);

                    $compareRanges = $this->compareRangeOfGrade($min_vulnerable, $max_vulnerable, $min_competent, $max_competent, $min_optimum, $max_optimum);
                    if (is_array($compareRanges)) {
                        return $helpers->json($compareRanges);
                    } else {

                        $manager->persist($areaCentury);
                        $manager->flush();

                        return $helpers->json(array(
                            'status' => 'success',
                            'title' => 'Guardado',
                            'message' => '¡Los datos se guardaron correctamente!',
                            'id' => $areaCentury->getId(),
                            'name' => $areaCentury->getName()
                        ));
                    }
                } else {
                    return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'No existe el area solicitada'
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
     * Compara que las cantidades de maximos y minimos sean aceptables
     * @param type $min_vulnerable
     * @param type $max_vulnerable
     * @param type $min_competent
     * @param type $max_competent
     * @param type $min_optimum
     * @param type $max_optimum
     * @return mixed
     */
    private function compareRangeOfGrade($min_vulnerable, $max_vulnerable, $min_competent, $max_competent, $min_optimum, $max_optimum)
    {
        if ($min_vulnerable >= $max_vulnerable) {
            return array(
                'status' => 'error',
                'title' => 'Error',
                'message' => 'El maximo vulnerable debe ser mayor al minimo vulverable'
            );
        }
        if ($max_vulnerable >= $min_competent) {
            return array(
                'status' => 'error',
                'title' => 'Error',
                'message' => 'El minimo competente debe ser mayor al maximo vulnerable');
        }
        if ($min_competent >= $max_competent) {
            return array('status' => 'error',
                'title' => 'Error',
                'message' => 'El maximo competente debe ser mayor o igual al minimo competente');
        }
        if ($max_competent >= $min_optimum) {
            return array('status' => 'error',
                'title' => 'Error',
                'message' => 'El minimo optimo debe ser mayor al maximo competente');
        }
        if ($min_optimum >= $max_optimum) {
            return array('status' => 'error',
                'title' => 'Error',
                'message' => 'El maximo optimo debe ser mayor al minimo optimo');
        }
        return true;
    }

    public function listAction(Request $request, $id = null)
    {
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
        $manager = $this->getDoctrine()->getManager();
        $skillCentury = $manager->getRepository("BackendBundle:SkillCentury")->findOneBy(array("id" => $id));
        if (count($skillCentury) > 0) {
            $areas = $manager->getRepository($this::REPOSITORY)->findBy(array("skillCentury" => $skillCentury));
            if (count($areas) > 0) {
                $page = $request->query->getInt("page", 1);
                $paginator = $this->get("knp_paginator");
                $items_per_page = 10;

                /** @noinspection PhpUndefinedMethodInspection */
                $total_items = count($areas);
                if ($page > 0) {
                    $pagination = $paginator->paginate($areas, $page, $items_per_page);
                    /** @noinspection PhpUndefinedMethodInspection */
                    $total_items = $pagination->getTotalItemCount();
                } else {
                    $pagination = $areas;
                    $teacherId = $request->query->getInt("userId", 0);
                    if ($teacherId > 0) {
                        $i = 0;
                        //$user = $manager->getRepository("BackendBundle:User")->find($userId);
                        $teacher = $manager->getRepository("BackendBundle:Teacher")->find($teacherId);
                        foreach ($pagination as $pages) {
                            $data[$i]["id"] = $pages->getId();
                            $data[$i]["name"] = $pages->getName();
                            $data[$i]["totalQuestions"] = count($manager->getRepository("BackendBundle:QuestionCentury")->findBy(array("areaCentury" => $pages, "status" => 1)));
                            $area = $manager->getRepository($this::REPOSITORY)->find($pages->getId());
                            $questions = $manager->getRepository("BackendBundle:QuestionCentury")->findBy(array("areaCentury"=>$area,"status"=>1));
                            $data[$i]["questionsAnswered"] = count($manager->getRepository("BackendBundle:TeacherAnswerCentury")->findBy(array("teacher" => $teacher, "questionCentury"=>$questions)));
                            $i++;
                        }

                        $pagination = $data;
                    }
                }
                return $helpers->json(
                    array(
                        'status' => 'success',
                        'title' => 'Lista de Areas',
                        'data' => $pagination,
                        'total_items' => $total_items,
                        'page_actual' => $page,
                        'items_per_page' => $items_per_page,
                        'total_pages' => ceil($total_items / $items_per_page)
                    ));
            } else {
                return $helpers->json(array('status' => 'error', 'title' => 'Sin resultados', 'message' => 'No se encontraron resultado'));
            }
        } else {
            return $helpers->json(array(
                'status' => 'error',
                'title' => 'Sin resultados',
                'message' => 'No existe la habilidad que estas tratando de consultar'));
        }
    }

    public function detailAction(Request $request, $id = null)
    {
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
        $manager = $this->getDoctrine()->getManager();
        if ($id != null && $id > 0) {
            $areaCentury = $manager->getRepository("BackendBundle:AreaCentury")->findOneBy(array("id" => $id));
            if (count($areaCentury) > 0) {
                return $helpers->json(array('status' => 'success', 'title' => 'Detalle de area', 'data' => $areaCentury));
            } else {
                return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Sin resultados',
                    'message' => 'No existe el area que estas tratando de consultar'));
            }
        }
    }

    public function deactivateAction(Request $request, $id = null)
    {
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
        $manager = $this->getDoctrine()->getManager();
        if ($id != null && $id > 0) {
            $areaCentury = $manager->getRepository("BackendBundle:AreaCentury")->findOneBy(array("id" => $id));
            $areaCentury->setStatus(0);
            $manager->persist($areaCentury);
            $manager->flush();

            return $helpers->json(array(
                'status' => 'success',
                'title' => 'Guardado',
                'message' => '¡Desactivado correctamente!',
                'id' => $areaCentury->getId(),
                'name' => $areaCentury->getName()
            ));
        }
    }

}

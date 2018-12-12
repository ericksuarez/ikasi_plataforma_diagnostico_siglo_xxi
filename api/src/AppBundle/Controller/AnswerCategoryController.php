<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\AnswerCategory;

class AnswerCategoryController extends Controller {

    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:AnswerCategory";

    public function createAction(Request $request) {
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
            $category_id = (isset($params->category_id)) ? $params->category_id : null;
            $name = (isset($params->name)) ? $params->name : null;
            $value = (isset($params->value)) ? $params->value : null;

            if ($category_id > 0 && $category_id != null && $name != "" && $value != "") {
                $category = $manager->getRepository("BackendBundle:Category")->find($category_id);
                $exist = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $name, "category" => $category));
                if (count($exist) == 0) {
                    $answerCategory = new AnswerCategory();
                    $answerCategory->setCategory($category);
                    $answerCategory->setCreateTime(new \DateTime('now'));
                    $answerCategory->setUpdateTime(new \DateTime('now'));
                    $answerCategory->setName($name);
                    $answerCategory->setValue($value);
                    $manager->persist($answerCategory);
                    $manager->flush();
                    return $helpers->json(array(
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => 'Respuesta guardada correctamente',
                                'id' => $answerCategory->getId(),
                                'name' => $answerCategory->getName()
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

    public function editAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }

        $params = json_decode($request->get("json", null));
        if (!empty($params) && $params != null && $id != null && $id > 0) {
            $manager = $this->getDoctrine()->getManager();
            $answerCategory = $manager->getRepository($this::REPOSITORY)->find($id);
            if (isset($params->name) && $params->name != null) {
                $name = $params->name;
                $category = $manager->getRepository("BackendBundle:Category")->find($answerCategory->getCategory()->getId());
                $exist = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $name, "category" => $category));
                if (count($exist) == 0 || $exist->getId() == $id) {
                    $value = (isset($params->value)) ? $params->value : $category->getValue();
                    $answerCategory->setName($name);
                    $answerCategory->setValue($value);
                    $answerCategory->setUpdateTime(new \DateTime('now'));
                    $manager->persist($answerCategory);
                    $manager->flush();
                    return $helpers->json(array(
                                'status' => 'success',
                                'title' => 'Modificado',
                                'message' => 'Respuesta modificada correctamente',
                                'id' => $answerCategory->getId(),
                                'name' => $answerCategory->getName()
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

    public function detailAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }
        $manager = $this->getDoctrine()->getManager();
        if ($id != null && $id > 0) {
            $answerCategory = $manager->getRepository($this::REPOSITORY)->find($id);
            if (count($answerCategory) > 0) {
                return $helpers->json(array(
                            'status' => 'success',
                            'title' => 'Detalle',
                            'data' => $answerCategory
                ));
            }
            return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'No existe el registro'
            ));
        }
        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Por favor verifica los datos'
        ));
    }

    public function deactivateAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }

        if ($id != null && $id > 0) {
            $manager = $this->getDoctrine()->getManager();
            $answerCategory = $manager->getRepository($this::REPOSITORY)->find($id);
            if (count($answerCategory) > 0) {
                $answerCategory->setStatus(0);
                $manager->persist($answerCategory);
                $manager->flush();
                return $helpers->json(array('status' => 'success', 'title' => 'Exito', 'message' => 'Desactivado correctamente'));
            }
            return $helpers->json(array('status' => 'error', 'title' => 'Error', 'message' => 'No existe el registro'));
        }
        return $helpers->json(array('status' => 'error', 'title' => 'Error', 'message' => 'Por favor verifica los datos'));
    }

    public function listAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");
        $jwtAuth = $this->get("app.jwt_auth");
        $access_control = $this->get("app.access_control");
        $comprobar = $jwtAuth->isAuthorizedToChange($request, $access_control);
        if (is_array($comprobar)) {
            return $helpers->json($comprobar);
        }

        if ($id != null && $id > 0) {
            $manager = $this->getDoctrine()->getManager();
            $category = $manager->getRepository("BackendBundle:Category")->findOneBy(array("id" => $id));
            $answers = $manager->getRepository($this::REPOSITORY)->findBy(array("category" => $category, "status" => 1));
            if (count($answers) > 0) {
                if (count($category) > 0) {
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
                                        'data' => $pagination,
                                        'total_items' => $total_items,
                                        'page_actual' => $page,
                                        'items_per_page' => $items_per_page,
                                        'total_pages' => ceil($total_items / $items_per_page)
                    ));
                }
            }
        }
        return $helpers->json(array('status' => 'error', 'title' => 'Sin resultados', 'message' => 'No se encontrarón resultados'));
    }
	
	/**
	 * Elimina un regirtro
	 * @return mixed
	 */
	public function deleteAction($id)
	{
		$helpers = $this->get("app.helpers");

		$teacherFunction = $this->getDoctrine()->getRepository($this::REPOSITORY)->find($id);
		$teacherFunction->setStatus(FALSE);

		/** @noinspection PhpUndefinedMethodInspection */
		$query = $this->getDoctrine()->getManager();
		//$query->remove($teacherFunction);
		$query->persist($teacherFunction);
		$query->flush();

		/** @noinspection PhpUndefinedMethodInspection */
		return $helpers->json(array(
			'status' => 200,
			'title' => '¡Correcto!',
			'message' => 'Se ha eliminado correctamente el elemento.'
		));
	}

}

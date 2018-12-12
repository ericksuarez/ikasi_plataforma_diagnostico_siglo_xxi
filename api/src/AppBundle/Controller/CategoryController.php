<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use BackendBundle\Entity\Category;

class CategoryController extends Controller {

    const UNAUTHORIZED = 401;
    const REPOSITORY = "BackendBundle:Category";
    const STATUS_ACTIVATED_CATEGORY = 1;

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

        if (!empty($params) && $params != null && isset($params->name)) {
            $name = ($params->name);
            $manager = $this->getDoctrine()->getManager();
            $existCategory = $manager->getRepository("BackendBundle:Category")->findOneBy(array("name" => $name, "status" => 1));

            if (count($existCategory) == 0) {
                $category = new Category();
                $category->setName($name);
                $category->setCreateTime(new \DateTime('now'));
                $category->setUpdateTime(new \DateTime('now'));
				$category->setDeleteTime(new \DateTime('0000-00-00 00:00:00'));
                $category->setStatus(1);
                $manager->persist($category);
                $manager->flush();
                return $helpers->json(array(
                            'status' => 'success',
                            'title' => 'Guardado',
                            'message' => 'Categoria guardada con exito',
                            'id' => $category->getId(),
                            'name' => $category->getName()
                ));
            } else {
                return $helpers->json(array(
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'Categoria duplicada favor de revisar tus datos'));
            }
        }
        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'Por favor verifica los datos'
        ));
    }

    public function editAction(Request $request, $id = null) {
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
        if (!empty($params) && $params != null && isset($params->name)) {
            $name = ($params->name);
            $manager = $this->getDoctrine()->getManager();
            $category = $manager->getRepository($this::REPOSITORY)->findOneBy(array("id" => $id));
            $existCate = $manager->getRepository($this::REPOSITORY)->findOneBy(array("name" => $params->name));
            $this::REPOSITORY;

            if ((count($existCate) == 0 || $existCate->getId() == $id)) {
                //
            } else {
                return $helpers->json(array(
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'Registro duplicado'));
            }
            if (count($category) > 0) {
                $category->setName($name);
                $category->setUpdateTime(new \DateTime('now'));
                $manager->persist($category);
                $manager->flush();
                return $helpers->json(array(
                            'status' => 'success',
                            'title' => 'Guardado',
                            'message' => 'Categoria actualizada con exito',
                            'id' => $category->getId(),
                            'name' => $category->getName()
                ));
            } else {
                return $helpers->json(array(
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'Por favor verifica los datos'));
            }
        }
    }

    public function listAction(Request $request) {
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
//        $manager = $this->getDoctrine()->getManager();
//        $category = $manager->getRepository($this::REPOSITORY)->findAll();
        $repository = $this->getDoctrine()->getRepository($this::REPOSITORY);
        $sql_category = $repository->createQueryBuilder('p')
                ->select(['p'])
                ->where('p.status = :status')
                ->setParameter('status', self::STATUS_ACTIVATED_CATEGORY)
                ->getQuery();
        $category = $sql_category->getResult();
        
        if (count($category) > 0) {
            $page = $request->query->getInt("page", 1);
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $pagination = $category;
            $total_items = count($category);
            if ($page > 0) {
                $pagination = $paginator->paginate($category, $page, $items_per_page);
                /** @noinspection PhpUndefinedMethodInspection */
                $total_items = $pagination->getTotalItemCount();
            }
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
        return $helpers->json(array('status' => 'error', 'title' => 'Sin resultados', 'message' => 'No se encontraron resultado'));
    }

    public function deactivateAction(Request $request, $id = null) {
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
        $manager = $this->getDoctrine()->getManager();

        if ($id != null) {
            $category = $manager->getRepository($this::REPOSITORY)->findOneBy(array("id" => $id, "status" => self::STATUS_ACTIVATED_CATEGORY));
            if (count($category) > 0) {
                $category->setStatus(0);
                $manager->persist($category);
                $manager->flush();
                return $helpers->json(array(
                            'status' => 200,
                            'title' => 'Desactivado',
                            'message' => 'La categoria fue desaactivada'
                ));
            } else {
                return $helpers->json(array(
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => '¡No existe la categoria!'
                ));
            }
        }

        return $helpers->json(array(
                    'status' => 'error',
                    'title' => 'Error',
                    'message' => 'No fue posible desactivar el registro'
        ));
    }

	/**
	 * Eliminar registro
	 * @return mixed
	 */
	public function deleteAction($id) {
		$helpers = $this->get("app.helpers");

		$speciality = $this->getDoctrine()->getRepository($this::REPOSITORY)->find($id);
		$validator = $this->get('validator');
		
		$speciality->setDeleteTime(new \DateTime('now'));
		$speciality->setStatus(0);
    
		if (count($validator->validate($speciality)) == 0) {
			/** @noinspection PhpUndefinedMethodInspection */
			$query = $this->getDoctrine()->getManager();
			$query->persist($speciality);
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

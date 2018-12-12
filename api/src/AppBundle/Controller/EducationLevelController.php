<?php

namespace AppBundle\Controller {

    use BackendBundle\Entity\EducationLevel;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 19/10/16
     * Time: 13:16
     */
    class EducationLevelController extends Controller {

        const UNAUTHORIZED = 401;

        /**
         * Devuelve un listado con todas las especialidades
         * @return mixed
         */
        public function listAction() {
            $helpers = $this->get("app.helpers");

            $repository = $this->getDoctrine()->getRepository('BackendBundle:EducationLevel');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('el')
                    ->select(['el.id', 'el.name'])
                    ->where('el.status = 1')
                    ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json($query->getResult());
        }

        /**
         * Devuelve el listado de especialidades
         * @param Request $request
         * @return mixed
         */
        public function allAction(Request $request) {
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

            $page = $request->query->getInt("page", 1);
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $pagination = $paginator->paginate($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->findBy(array("status" => "1")), $page, $items_per_page);
            /** @noinspection PhpUndefinedMethodInspection */
            $total_items = $pagination->getTotalItemCount();

            return $helpers->json([
                        'total_items' => $total_items,
                        'page_actual' => $page,
                        'items_per_page' => $items_per_page,
                        'total_pages' => ceil($total_items / $items_per_page),
                        'data' => $pagination
            ]);
        }

        /**
         * Método para crear una nuevo nivel
         * @param Request $request
         * @return mixed
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

            if (!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;
                $educationLevel = new EducationLevel();
                $educationLevel->setName($name);
                $educationLevel->setStatus(1);
                $educationLevel->setDeleteTime(new \DateTime('0000-00-00 00:00:00'));
                $educationLevel->setCreateTime(new \DateTime('now'));

                $validator = $this->get('validator');

                if (count($validator->validate($educationLevel)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($educationLevel);
                    $manager->flush();
                    return $helpers->json([
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se guardaron correctamente!',
                                'id' => $educationLevel->getId(),
                                'name' => $educationLevel->getName()
                    ]);
                }
            }

            return $helpers->json([
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Por favor verifica los datos'
            ]);
        }

        /**
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function updateAction(Request $request, $id) {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $params = json_decode($request->get("json", null));

            if (!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;

                $educationLevel = $this->getDoctrine()->getRepository(EducationLevel::class)->find($id);
                $validator = $this->get('validator');

                $educationLevel->setName($name)
                        ->setUpdateTime(new \DateTime('now'));

                if (count($validator->validate($educationLevel)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($educationLevel);
                    $manager->flush();

                    return $helpers->json([
                                'status' => 'success',
                                'title' => 'Guardado',
                                'message' => '¡Los datos se guardaron correctamente!'
                    ]);
                }
            }

            return $helpers->json(array(
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'Error al guardar el curso'
            ));
        }

        /**
         * Elimina un regirtro
         * @return mixed
         */
        public function deleteAction($id) {
            $helpers = $this->get("app.helpers");

            $educationLevel = $this->getDoctrine()->getRepository(EducationLevel::class)->find($id);
            $validator = $this->get('validator');

            $educationLevel->setDeleteTime(new \DateTime('now'));
            $educationLevel->setStatus(0);

            if (count($validator->validate($educationLevel)) == 0) {

                /** @noinspection PhpUndefinedMethodInspection */
                $query = $this->getDoctrine()->getManager();
                $query->persist($educationLevel);
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

}
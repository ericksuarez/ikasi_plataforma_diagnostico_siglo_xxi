<?php

namespace AppBundle\Controller {

    use BackendBundle\Entity\TeacherFunction;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 19/10/16
     * Time: 13:11
     */
    class TeacherFunctionController extends Controller
    {
        const UNAUTHORIZED = 401;

        /**
         * Devuelve un listado con todas las especialidades
         * @return mixed
         */
        public function listAction()
        {
            $helpers = $this->get("app.helpers");

            $repository = $this->getDoctrine()->getRepository('BackendBundle:TeacherFunction');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('tf')
                ->select(['tf.id', 'tf.name'])
                ->where('tf.status = 1')
                ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json($query->getResult());
        }

        /**
         * Devuelve el listado de especialidades
         * @param Request $request
         * @return mixed
         */
        public function allAction(Request $request)
        {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            if(empty($authorization)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $userData = $jwt_auth->checkToken($authorization, true);
            $accessGranted = $access_control->accessGrantedForAdmin($userData);

            if(is_array($accessGranted)) {
                return $helpers->json($accessGranted);
            }

            $page = $request->query->getInt("page", 1);
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $pagination = $paginator->paginate($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->findBy(array("status" => 1)), $page, $items_per_page);
//            $pagination = $paginator->paginate($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->findAll(), $page, $items_per_page);
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
         * Método para crear una nueva función de profesor
         * @param Request $request
         * @return mixed
         */
        public function createAction(Request $request)
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

            if (!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;
                $teacherFunction = new TeacherFunction();
                $teacherFunction->setName($name);
                $teacherFunction->setStatus(1);
                $teacherFunction->setDeleteTime(new \DateTime('0000-00-00 00:00:00'));
                $teacherFunction->setCreateTime(new \DateTime('now'));
                $validator = $this->get('validator');

                if (count($validator->validate($teacherFunction)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($teacherFunction);
                    $manager->flush();
                    return $helpers->json([
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡Los datos se guardaron correctamente!',
                        'id' => $teacherFunction->getId(),
                        'name' => $teacherFunction->getName()
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

            if(!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;

                $teacherFunction = $this->getDoctrine()->getRepository(TeacherFunction::class)->find($id);
                $validator = $this->get('validator');

                $teacherFunction->setName($name)
                    ->setUpdateTime(new \DateTime('now'));

                if (count($validator->validate($teacherFunction)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($teacherFunction);
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
        public function deleteAction($id)
        {
            $helpers = $this->get("app.helpers");

            $teacherFunction = $this->getDoctrine()->getRepository(TeacherFunction::class)->find($id);
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
}
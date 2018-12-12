<?php

namespace AppBundle\Controller {

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 04/11/16
     * Time: 10:34
     */
    class TeacherController extends Controller {

        const UNAUTHORIZED = 401;

        /**
         * Devuelve todos los profesores registrados
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

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Teacher');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('t')
                    ->select(['t.id', 't.fullname', 't.curp', 't.createTime', 't.updateTime', 't.didFinishXxiQuestionary', 't.evaluationIneeFinish'])
                    ->where('t.status = 1')
                    ->getQuery();

            $pagination = $paginator->paginate($query, $page, $items_per_page);
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
         * Devuelve el perfil de un profesor
         * @param Request $request
         * @return mixed
         */
        public function profileAction(Request $request) {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            $id = $request->query->getInt("id", null);

        //    if (empty($authorization) || empty($id)) {
        //        return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
        //    }
        //
        //    $userData = $jwt_auth->checkToken($authorization, true);
        //    $accessGranted = $access_control->accessGrantedForAdmin($userData);
        //
        //    if (is_array($accessGranted)) {
        //        return $helpers->json($accessGranted);
        //    }

            return $helpers->json($this->getDoctrine()->getRepository('BackendBundle:Teacher')->find($id));
        }

        /**
         * Actualiza la información de inicio de sesión  de un profesor
         * @param Request $request
         * @return mixed
         */
        public function updateUserAction(Request $request) {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");
            $params = json_decode($request->get("json", null));
            $encrypt = $this->get('app.encrypt');
            $validator = $this->get('validator');

            if (empty($authorization) || empty($params)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $userData = $jwt_auth->checkToken($authorization, true);
            $accessGranted = $access_control->accessGrantedForAdmin($userData);

            if (is_array($accessGranted)) {
                return $helpers->json($accessGranted);
            }

            $id = (property_exists($params, "id")) ? trim($params->id) : null;
            $email = (property_exists($params, "email")) ? $params->email : null;
            $password = (property_exists($params, "password")) ? trim($params->password) : null;
            $status = (property_exists($params, "status")) ? trim($params->status) : null;

            $user = $this->getDoctrine()->getRepository('BackendBundle:User')->find($id);
            $user->setEmail($email)
                    ->setStatus($status)
                    ->setUpdateTime(new \DateTime('now'));

            if (!empty($password)) {
                $user->setPasswordHash($encrypt->encrypt($password));
            }

            if (count($validator->validate($user)) == 0) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($user);
                $manager->flush();

                return $helpers->json([
                            'status' => 'success',
                            'title' => 'Guardado',
                            'message' => 'Los datos del usuario se han actualizado correctamente'
                ]);
            }

            return $helpers->json([
                        'status' => 'error',
                        'title' => 'Error',
                        'message' => 'No se ha guardado la información del usuario'
            ]);
        }

        /**
         * Listado de usuarios preregistrados
         * @param Request $request
         * @return mixed
         */
        public function listPreregisterAction(Request $request) {
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            $check = $jwt_auth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $page = $request->query->getInt("page", 1);
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $repository = $this->getDoctrine()->getRepository('BackendBundle:PreRegister');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('t')
                    ->select(['t.id', 't.name', 't.curp', 't.email'])
                    ->getQuery();

            $pagination = $paginator->paginate($query, $page, $items_per_page);
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
         * Importación de profesores a través de un archivo CSV
         * @param Request $request
         * @return mixed
         */
        public function importAction(Request $request) {
            $helpers = $this->get("app.helpers");
            $jwtAuth = $this->get("app.jwt_auth");
            $access_control = $this->get("app.access_control");
            $check = $jwtAuth->isAuthorizedToChange($request, $access_control);

            if (is_array($check)) {
                return $helpers->json($check);
            }

            $file = $request->files->get('file', null);

            if (!empty($file)) {
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
                $import = $this->get("app.import_teacher");
                $totalItemsImport = $import->execute($finalPath);

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
		* Funcion borrado de teacher, evaluaciones siglos xxi y evaluation diagnostica
		* @param teacherId
		* @param opcion valores de opcion 
		*	1 => Elimiar al Profesor
		*	2 => Elimiar al Evaluación Siglo XXI
		*	3 => Elimiar al Evaluación Diagnostica
		*/
        public function deleteAction($id,$opcion) {
            $helpers = $this->get("app.helpers");
			$msj = $id.$opcion;

            switch($opcion){
				case "1":
					$teacherFunction = $this->getDoctrine()->getRepository('BackendBundle:Teacher')->find($id);
					$teacherFunction->setStatus(FALSE);
					/** @noinspection PhpUndefinedMethodInspection */
					$query = $this->getDoctrine()->getManager();
					$query->persist($teacherFunction);
					$query->flush();
					$msj = 'Se ha eliminado correctamente el elemento.';
				break;
				
				case "2":
					$manager = $this->getDoctrine()->getManager();
					$query = 'DELETE FROM teacher_answer_century WHERE teacher_id =' . $id;
					$statement = $manager->getConnection()->prepare($query);
					$statement->execute();
					$query = 'UPDATE teacher SET did_finish_xxi_questionary = NULL WHERE teacher.id = ' . $id;
					$statement = $manager->getConnection()->prepare($query);
					$statement->execute();
					$msj = 'Se ha eliminado correctamente la Evaluación Siglo XXI.';
				break;
				
				case "3":
					$manager = $this->getDoctrine()->getManager();
					$query = 'DELETE FROM answer_inee_teacher WHERE teacher_id =' . $id;
					$statement = $manager->getConnection()->prepare($query);
					$statement->execute();
					$query = 'UPDATE teacher SET evaluation_inee_finish = 0 WHERE teacher.id = ' . $id;
					$statement = $manager->getConnection()->prepare($query);
					$statement->execute();
					$msj = 'Se ha eliminado correctamente la Evaluación Diagnostica.';				
				break;
				
			}

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                        'status' => 200,
                        'title' => '¡Correcto!',
                        'message' => $msj
            ));
        }

        /**
         * Devuelve todos los profesores registrados
         * @param Request $request
         * @return mixed
         */
        public function allfullnameAction(Request $request) {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
//            $jwt_auth = $this->get("app.jwt_auth");
//            // Control de acceso
//            $access_control = $this->get("app.access_control");
//
//            if (empty($authorization)) {
//                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
//            }
//
//            $userData = $jwt_auth->checkToken($authorization, true);
//            $accessGranted = $access_control->accessGrantedForAdmin($userData);
//
//            if (is_array($accessGranted)) {
//                return $helpers->json($accessGranted);
//            }
            $params = $_GET["fullname"];
            
            $page = 1;
            $paginator = $this->get("knp_paginator");
            $items_per_page = 10;

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Teacher');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('t')
                    ->select(['t.id', 't.fullname', 't.curp', 't.createTime', 't.updateTime', 't.didFinishXxiQuestionary', 't.evaluationIneeFinish'])
                    ->andWhere('t.status = 1')
                    ->andWhere('t.fullname LIKE :fullname')
                    ->setParameter('fullname', '%' . $params . '%')
                    ->getQuery();

            $pagination = $paginator->paginate($query, $page, $items_per_page);
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

    }

}
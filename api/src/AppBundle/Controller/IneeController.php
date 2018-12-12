<?php

namespace AppBundle\Controller {

    use BackendBundle\Entity\Dimension;
    use BackendBundle\Entity\Indicator;
    use BackendBundle\Entity\Parameter;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 16/11/16
     * Time: 16:08
     */
    class IneeController extends Controller
    {
        const UNAUTHORIZED = 401;
        const NOT_FOUND = 404;

        /**
         * Método para crear una nueva dimensión
         * @param Request $request
         * @return mixed
         */
        public function createDimensionAction(Request $request)
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
				$id 			  = (property_exists($params, "id")) 			   ? strip_tags($params->id)			   : 0;
                $name 			  = (property_exists($params, "name")) 			   ? strip_tags($params->name)			   : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? strip_tags($params->teacher_function) : null;
                $education_level  = (property_exists($params, "education_level"))  ? strip_tags($params->education_level)  : null;
				
				$validator = $this->get('validator');
        
				if ($id > 0) {
					
					$dimension_exist = $this->getDoctrine()->getRepository(Dimension::class)->find($id);
					$dimension_exist->setName($name);
					$dimension_exist->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level));
					$dimension_exist->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function));
					$dimension_exist->setUpdateTime(new \DateTime('now'));
					
					$manager = $this->getDoctrine()->getManager();
                    $manager->persist($dimension_exist);
                    $manager->flush();
                    return $helpers->json([
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡Los datos se actualizaron correctamente!',
                        'id' => $dimension_exist->getId()
                    ]);
				} else {				
					$dimension = new Dimension();
					$dimension->setName($name);
					$dimension->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level));
					$dimension->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function));
					$dimension->setCreateTime(new \DateTime('now'));
        
					if (count($validator->validate($dimension)) == 0) {
						$manager = $this->getDoctrine()->getManager();
						$manager->persist($dimension);
						$manager->flush();
						return $helpers->json([
							'status' => 'success',
							'title' => 'Guardado',
							'message' => '¡Los datos se guardaron correctamente!',
							'id' => $dimension->getId()
						]);
					} 
				}
            }

            return $helpers->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Error al guardar los datos!!!'
            ]);
        }

        /**
         * Método para obtener una dimensión y sus parametros
         * @param Request $request
         * @param null $id
         * @return mixed
         */
        public function getDimensionAction(Request $request, $id = null)
        {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            if (empty($authorization) || empty($id)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $userData = $jwt_auth->checkToken($authorization, true);
            $accessGranted = $access_control->accessGrantedForAdmin($userData);

            if (is_array($accessGranted)) {
                return $helpers->json($accessGranted);
            }

            $dimension = $this->getDoctrine()->getRepository('BackendBundle:Dimension')->find($id);

            if (!is_object($dimension)) {
                return $helpers->json(['status' => 'error', 'code' => $this::NOT_FOUND, 'message' => 'Página no encontrada']);
            }

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Parameter');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('p')
                ->select(['p.id', 'p.name'])
                ->where('p.dimension = :id')
                ->setParameter('id', $dimension)
                ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json([
                'status' => 'success',
                'dimension' => $dimension,
                'parameters' => $query->getResult()
            ]);

        }

        /**
         * Crea un nuevo parametro
         * @param Request $request
         * @param null $id
         * @return mixed
         */
        public function createParameterAction(Request $request, $id = null)
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
                $dimension = $this->getDoctrine()->getRepository('BackendBundle:Dimension')->find($id);

                $name = (property_exists($params, "name")) ? strip_tags($params->name) : null;
                $parameter = new Parameter();
                $parameter->setName($name)
                    ->setDimension($dimension)
                    ->setCreateTime(new \DateTime('now'));
                $validator = $this->get('validator');

                if (count($validator->validate($parameter)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($parameter);
                    $manager->flush();
                    return $helpers->json([
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡El parámetro se agrego correctamente!',
                        'data' => [
                            'id' => $parameter->getId(),
                            'name' => $parameter->getName()
                        ]
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
         * Método para obtener una parámetro y sus indicadores
         * @param Request $request
         * @param null $id
         * @return mixed
         */
        public function getParameterAction(Request $request, $id = null)
        {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            if (empty($authorization) || empty($id)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $userData = $jwt_auth->checkToken($authorization, true);
            $accessGranted = $access_control->accessGrantedForAdmin($userData);

            if (is_array($accessGranted)) {
                return $helpers->json($accessGranted);
            }

            $parameter = $this->getDoctrine()->getRepository('BackendBundle:Parameter')->find($id);

            if (!is_object($parameter)) {
                return $helpers->json(['status' => 'error', 'code' => $this::NOT_FOUND, 'message' => 'Página no encontrada']);
            }

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Indicator');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('p')
                ->select(['p.id', 'p.name'])
                ->where('p.parameter = :id')
                ->setParameter('id', $parameter)
                ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json([
                'status' => 'success',
                'parameter' => $parameter,
                'indicators' => $query->getResult()
            ]);
        }

        /**
         * Crea un nuevo parametro
         * @param Request $request
         * @param null $id
         * @return mixed
         */
        public function createIndicatorAction(Request $request, $id = null)
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
                $parameter = $this->getDoctrine()->getRepository('BackendBundle:Parameter')->find($id);

                $name = (property_exists($params, "name")) ? strip_tags($params->name) : null;
                $indicator = new Indicator();
                $indicator->setName($name)
                    ->setParameter($parameter)
                    ->setCreateTime(new \DateTime('now'));
                $validator = $this->get('validator');

                if (count($validator->validate($indicator)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($indicator);
                    $manager->flush();
                    return $helpers->json([
                        'status' => 'success',
                        'title' => 'Guardado',
                        'message' => '¡El parámetro se agrego correctamente!',
                        'data' => [
                            'id' => $indicator->getId(),
                            'name' => $indicator->getName()
                        ]
                    ]);
                }
            }

            return $helpers->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Por favor verifica los datos'
            ]);
        }

        public function filterDimensionAction(Request $request, $educationLevelId, $teacherFunctionId)
        {
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio Helpers
            $helpers = $this->get("app.helpers");
            // Servicio del JWT
            $jwt_auth = $this->get("app.jwt_auth");
            // Control de acceso
            $access_control = $this->get("app.access_control");

            if (empty($authorization) || empty($educationLevelId) || empty($teacherFunctionId)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $userData = $jwt_auth->checkToken($authorization, true);
            $accessGranted = $access_control->accessGrantedForAdmin($userData);

            if (is_array($accessGranted)) {
                return $helpers->json($accessGranted);
            }

            $dimensions = $this->getDoctrine()->getRepository('BackendBundle:Dimension')->findBy([
                'educationLevel' => $educationLevelId,
                'teacherFunction' => $teacherFunctionId
            ]);

            $data = [];

            foreach ($dimensions as $dimension) {
                $tree = [];
                /** @noinspection PhpUndefinedMethodInspection */
                $tree['id'] = $dimension->getId();
                /** @noinspection PhpUndefinedMethodInspection */
                $tree['name'] = $dimension->getName();

                $parameters = [];
                $_parameters = $this->getDoctrine()->getRepository('BackendBundle:Parameter')->findBy([
                    'dimension' => $dimension,
                ]);

                foreach ($_parameters as $parameter) {
                    $indicators = [];
                    $_indicators = $this->getDoctrine()->getRepository('BackendBundle:Indicator')->findBy([
                        'parameter' => $parameter,
                    ]);
                    foreach ($_indicators as $indicator) {
                        /** @noinspection PhpUndefinedMethodInspection */
                        /** @noinspection PhpUndefinedMethodInspection */
                        array_push($indicators, [
                            'id' => $indicator->getId(),
                            'name' => $indicator->getName()
                        ]);
                    }
                    /** @noinspection PhpUndefinedMethodInspection */
                    array_push($parameters, [
                        'id' => $parameter->getId(),
                        'name' => $parameter->getName(),
                        'indicators' => $indicators
                    ]);
                }
                $tree['parameters'] = $parameters;
                array_push($data, $tree);
            }

            return $helpers->json($data);
        }

        /**
         * Importación de perfiles del INEE
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
         * Devuelve un listado con todas las especialidades
         * @param $educationLevelId
         * @param $teacherFunctionId
         * @return mixed
         */
        public function listDimensionAction($educationLevelId, $teacherFunctionId)
        {
            $helpers = $this->get("app.helpers");

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Dimension');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('dim')
                ->select(['dim.id', 'dim.name'])
                ->where('dim.educationLevel = :education AND dim.teacherFunction = :teacherF')
                ->setParameter('education', $educationLevelId)
                ->setParameter('teacherF', $teacherFunctionId)
                ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json($query->getResult());
        }

        /**
         * Listado de parámetros basado en el identificador de la dimensión
         * @param $dimensionId
         * @return mixed
         */
        public function listParameterAction($dimensionId)
        {
            $helpers = $this->get("app.helpers");

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Parameter');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('dim')
                ->select(['dim.id', 'dim.name'])
                ->where('dim.dimension = :dimension')
                ->setParameter('dimension', $dimensionId)
                ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json($query->getResult());
        }

        /**
         * Listado de indicadores basado en el identificador del parametro
         * @param $parameterId
         * @return mixed
         */
        public function listIndicatorAction($parameterId)
        {
            $helpers = $this->get("app.helpers");

            $repository = $this->getDoctrine()->getRepository('BackendBundle:Indicator');

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $repository->createQueryBuilder('ind')
                ->select(['ind.id', 'ind.name'])
                ->where('ind.parameter = :parameter')
                ->setParameter('parameter', $parameterId)
                ->getQuery();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json($query->getResult());
        }
    
	    /**
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function updateParameterAction(Request $request, $id)
        {
            $helpers = $this->get("app.helpers");

            $params = json_decode($request->get("json", null));

            if(!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;

                $parameter = $this->getDoctrine()->getRepository(Parameter::class)->find($id);
                $validator = $this->get('validator');

                $parameter->setName($name)
                    ->setUpdateTime(new \DateTime('now'));

                if (count($validator->validate($parameter)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($parameter);
                    $manager->flush();

                    return $helpers->json([
                        'status' => 200
						,
                        'title' => 'Guardado',
                        'message' => '¡Los datos se guardaron correctamente!'
                    ]);
                }
            }

            return $helpers->json(array(
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Error al guardar el parametro.'
            ));
        }
        
        /**
         * Elimina un regirtro
         * @return mixed
         */
        public function deleteParameterAction($id)
        {
            $helpers = $this->get("app.helpers");

            $parameter = $this->getDoctrine()->getRepository(Parameter::class)->find($id);

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $this->getDoctrine()->getManager();
            $query->remove($parameter);
            $query->flush();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                'status' => 200,
                'title' => '¡Correcto!',
                'message' => 'Se ha eliminado correctamente el elemento.'
            ));
        }
		
			    /**
         * @param Request $request
         * @param $id
         * @return mixed
         */
        public function updateIndicatorAction(Request $request, $id)
        {
            $helpers = $this->get("app.helpers");

            $params = json_decode($request->get("json", null));

            if(!empty($params)) {
                $name = (property_exists($params, "name")) ? $params->name : null;

                $indicator = $this->getDoctrine()->getRepository(Indicator::class)->find($id);
                $validator = $this->get('validator');

                $indicator->setName($name)
                    ->setUpdateTime(new \DateTime('now'));

                if (count($validator->validate($indicator)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($indicator);
                    $manager->flush();

                    return $helpers->json([
                        'status' => 200
						,
                        'title' => 'Guardado',
                        'message' => '¡Los datos se guardaron correctamente!'
                    ]);
                }
            }

            return $helpers->json(array(
                'status' => 'error',
                'title' => 'Error',
                'message' => 'Error al guardar el indicador.'
            ));
        }
        
        /**
         * Elimina un regirtro
         * @return mixed
         */
        public function deleteIndicatorAction($id)
        {
            $helpers = $this->get("app.helpers");

            $indicator = $this->getDoctrine()->getRepository(Indicator::class)->find($id);

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $this->getDoctrine()->getManager();
            $query->remove($indicator);
            $query->flush();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                'status' => 200,
                'title' => '¡Correcto!',
                'message' => 'Se ha eliminado correctamente el elemento.'
            ));
        }
		
		/**
         * Elimina un regirtro
         * @return mixed
         */
        public function deleteDimensionAction($id)
        {
            $helpers = $this->get("app.helpers");

            $dimension = $this->getDoctrine()->getRepository(Dimension::class)->find($id);

            /** @noinspection PhpUndefinedMethodInspection */
            $query = $this->getDoctrine()->getManager();
            $query->remove($dimension);
            $query->flush();

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                'status' => 200,
                'title' => '¡Correcto!',
                'message' => 'Se ha eliminado correctamente el elemento.'
            ));
        }
	
		public function getGraphDashboardAction(){
		
		$helpers = $this->get("app.helpers");
		
	//	$manager = $this->getDoctrine()->getManager();
	//	$niveles = 'SELECT 
	//				 EDLE.name AS NIVEL
	//				,SUM(TECH.did_finish_xxi_questionary) AS SIGLOXXI
	//				,SUM(TECH.evaluation_inee_finish) AS DIAGNOSTICA
	//				,COUNT(EDLE.id) AS INSCRITOS
	//			FROM education_level EDLE
	//			INNER JOIN teacher TECH ON
	//				EDLE.id = TECH.education_level_id
	//			WHERE TECH.status = 1
	//			GROUP BY EDLE.id';
	//	$statement = $manager->getConnection()->prepare($niveles);
	//	$statement->execute();
	//	$data = $statement->fetchAll();
		
				
		/** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                'status' => 200,
                'title' => '¡Correcto!',
                'message' => 'Se ha eliminado correctamente el elemento.'
            ));
			
		}
	
	}
}











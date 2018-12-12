<?php

namespace AppBundle\Controller {

    use AppBundle\Services\Email;
    use BackendBundle\Entity\Teacher;
    use BackendBundle\Entity\User;
    use Firebase\JWT\JWT;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 13/10/16
     * Time: 12:33
     */
    class UserController extends Controller {

        /**
         * @var int codigo para indicar que no esta autorizado
         */
        const UNAUTHORIZED = 401;

        /**
         * @var string $secret_key Clave secreta para codificar el token
         */
        protected $secret_key = "PhehAfRe7Ef4xaCu7emu3h5s";

        /**
         * Método para registrar un nuevo usuario en la plataforma
         * @param Request $request
         * @return mixed
         */
        public function registerAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $encrypt = $this->get('app.encrypt');
            $validator = $this->get('validator');
            $mail = $this->get('app.email');

            $params = json_decode($request->get("json", null));

            if (!empty($params)) {
                $email = (property_exists($params, "email")) ? $params->email : null;
                $password = (property_exists($params, "password")) ? trim($params->password) : null;
                $fullname = (property_exists($params, "fullname")) ? $params->fullname : null;
                $curp = (property_exists($params, "curp")) ? $params->curp : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? $params->teacher_function : null;
                $education_level = (property_exists($params, "education_level")) ? $params->education_level : null;
                $specialty = (property_exists($params, "specialty")) ? $params->specialty : null;
                $seccionSindical = (property_exists($params, "seccionSindical")) ? $params->seccionSindical : null;

                $uniqueUser = $this->getDoctrine()->getRepository('BackendBundle:User')->findOneBy([
                    'email' => $email
                ]);

                if (is_object($uniqueUser)) {
                    return $helpers->json([
                                'status' => 'error',
                                'message' => 'El correo electrónico ya esta registrado'
                    ]);
                }

                $uniqueTeacher = $this->getDoctrine()->getRepository('BackendBundle:Teacher')->findOneBy([
                    'curp' => $curp
                ]);

                if (is_object($uniqueTeacher)) {
                    return $helpers->json([
                                'status' => 'error',
                                'message' => 'El CURP ya esta registrado'
                    ]);
                }

                $role = $this->getDoctrine()->getRepository('BackendBundle:UserRole')->findOneBy([
                    'name' => 'teacher'
                ]);

                $authKey = bin2hex(mcrypt_create_iv(18, MCRYPT_DEV_URANDOM));

                $user = new User();
                $user->setEmail($email);
                $user->setPasswordHash($encrypt->encrypt($password));
                $user->setUserRole($role);
                $user->setAuthKey($authKey);
                $user->setCreateTime(new \DateTime('now'));
                $user->setSection_name($seccionSindical);

                if (count($validator->validate($user)) == 0) {
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);
                    $manager->flush();
                    // Creamos al profesor
                    $teacher = new Teacher();
                    $teacher->setFullname($fullname);
                    $teacher->setCurp($curp);
                    $teacher->setUser($user);
                    $teacher->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level));
                    $teacher->setSpeciality($this->getDoctrine()->getRepository('BackendBundle:Speciality')->find($specialty));
                    $teacher->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function));
                    $teacher->setCreateTime(new \DateTime('now'));
                    $teacher->setStatus(1);
                    $teacher->setDeleteTime(new \DateTime('0000-00-00 00:00:00'));

                    //if (count($validator->validate($teacher)) == 0) {
                    $manager->persist($teacher);
                    $manager->flush();
                    /** @noinspection PhpUndefinedFieldInspection */
                    $domain = $this->container->getParameter('serverRoot');
                    $mail->send(Email::ACTIVATE, ['id' => $user->getId(), 'authKey' => $authKey, 'domain' => $domain], [$email]);
                    return $helpers->json([
                                'status' => 'success',
                                'message' => 'El usuario ha sido creado con éxito'
                    ]);
                    //}
                }
            }

            return $helpers->json([
                        'status' => 'error',
                        'message' => 'Error al guardar datos'
            ]);
        }

        /**
         * Método para activar una cuenta
         * @param Request $request
         * @return mixed
         */
        public function activateAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $id = $request->get('id', null);
            $authKey = $request->get('authKey', null);

            $error = $helpers->json([
                'status' => 'error',
                'message' => 'Error al activar la cuenta'
            ]);

            if (empty($id) || empty($authKey)) {
                return $error;
            }

            $user = $this->getDoctrine()->getRepository('BackendBundle:User')->find($id);

            if (is_object($user)) {
                if ($user->getAuthKey() == $authKey) {
                    $user->setStatus(User::STATUS_ACTIVE);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($user);
                    $manager->flush();

                    return $helpers->json([
                                'status' => 'success',
                                'message' => 'Cuenta activada'
                    ]);
                }
            }

            return $error;
        }

        /**
         * Recuperación de contraseña
         * @param Request $request
         * @return mixed
         */
        public function passwordRecoveryAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $mail = $this->get('app.email');
            $email = $request->get('email', null);

            $error = $helpers->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'El correo electrónico no se encuentra registrado'
            ]);

            if (empty($email)) {
                return $error;
            }

            $user = $this->getDoctrine()->getRepository('BackendBundle:User')->findOneBy([
                'email' => $email
            ]);

            if (!is_object($user)) {
                return $error;
            }

            $passwordResetToken = bin2hex(mcrypt_create_iv(18, MCRYPT_DEV_URANDOM));
            $user->setPasswordResetToken($passwordResetToken);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            /** @noinspection PhpUndefinedFieldInspection */
            $domain = $this->container->getParameter('serverRoot');

            $mail->send(Email::PASSWORD_RECOVERY, ['id' => $user->getId(), 'passwordResetToken' => $passwordResetToken, 'domain' => $domain], [$email]);

            return $helpers->json([
                        'status' => 'success',
                        'title' => 'Mensaje enviado',
                        'message' => 'Se ha enviado un mensaje al correo proporcionado'
            ]);
        }

        /**
         * Genera una nueva contraseña para el usuario
         * @param Request $request
         * @return mixed
         */
        public function changePasswordTokenAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $params = json_decode($request->get('json', null));
            $encrypt = $this->get('app.encrypt');

            $error = $helpers->json([
                'status' => 'error',
                'title' => 'Error',
                'message' => 'No se ha podido cambiar la contraseña'
            ]);

            if (empty($params)) {
                return $error;
            }

            $password = (property_exists($params, "password")) ? trim($params->password) : null;
            $token = (property_exists($params, "token")) ? trim($params->token) : null;
            $id = (property_exists($params, "id")) ? $params->id : null;

            $user = $this->getDoctrine()->getRepository('BackendBundle:User')->findOneBy([
                'id' => $id,
                'passwordResetToken' => $token
            ]);

            if (!is_object($user)) {
                return $error;
            }

            $user->setPasswordHash($encrypt->encrypt($password))
                    ->setPasswordResetToken(null);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $helpers->json([
                        'status' => 'success',
                        'title' => 'Contraseña reseteada',
                        'message' => 'La contraseña se ha reseteado correctamente'
            ]);
        }

        /**
         * Cambio de contraseña desde el perfil del usuario
         * @param Request $request
         * @return mixed
         */
        public function changePasswordAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");
            $encrypt = $this->get('app.encrypt');

            $authorization = $request->headers->get('X-API-KEY');
            $params = json_decode($request->get('json', null));
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity || empty($params)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $oldPassword = (property_exists($params, "oldPassword")) ? trim($params->oldPassword) : null;
            $newPassword = (property_exists($params, "newPassword")) ? trim($params->newPassword) : null;

            // Verificamos que la contraseña anterior sea correcta
            $login = $jwtAuth->signup($identity->email, $oldPassword);

            if (!array_key_exists('token', $login)) {
                return $helpers->json([
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'Tu contraseña anterior es incorrecta'
                ]);
            }

            $user = $this->getDoctrine()->getRepository('BackendBundle:User')->findOneBy([
                'id' => $identity->sub
            ]);

            $user->setPasswordHash($encrypt->encrypt($newPassword));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $helpers->json([
                        'status' => 'success',
                        'title' => 'Contraseña cambiada',
                        'message' => 'La contraseña se ha cambiado correctamente'
            ]);
        }

        /**
         * Método para cambiar el correo electrónico
         * @param Request $request
         * @return mixed
         */
        public function changeEmailAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");

            $authorization = $request->headers->get('X-API-KEY');
            $params = json_decode($request->get('json', null));
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity || empty($params)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $newEmail = (property_exists($params, "email")) ? trim($params->email) : null;

            $uniqueUser = $this->getDoctrine()->getRepository('BackendBundle:User')->findOneBy([
                'email' => $newEmail
            ]);

            if (is_object($uniqueUser)) {
                return $helpers->json([
                            'status' => 'error',
                            'title' => 'Error',
                            'message' => 'El correo electrónico ya esta registrado'
                ]);
            }

            $user = $this->getDoctrine()->getRepository('BackendBundle:User')->findOneBy([
                'id' => $identity->sub
            ]);

            $user->setEmail($newEmail);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            // Generamos el nuevo token
            $token = [
                "sub" => $user->getId(),
                "email" => $user->getEmail(),
                "iat" => time(),
                "expire" => time() + (7 * 24 * 60 * 60)
            ];

            $jwt = JWT::encode($token, $this->secret_key, 'HS256');

            return $helpers->json([
                        'status' => 'success',
                        'title' => 'Email cambiado',
                        'message' => 'El correo electrónico se ha cambiado correctamente',
                        'token' => $jwt
            ]);
        }

        /**
         * Método para actualizar el perfil del profesor
         * @param Request $request
         * @return mixed
         */
        public function updateProfileAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $jwtAuth = $this->get("app.jwt_auth");

            $authorization = $request->headers->get('X-API-KEY');
            $params = json_decode($request->get('json', null));
            $identity = $jwtAuth->checkToken($authorization, true);

            if (!$identity || empty($params)) {
                return $helpers->json(['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized']);
            }

            $teacher = $this->getDoctrine()->getRepository('BackendBundle:Teacher')->findOneBy([
                'id' => $identity->teacher_id
            ]);

        //    if ($teacher->getEvaluationIneeFinish() == 0) {
                $fullname = (property_exists($params, "fullname")) ? trim($params->fullname) : null;
                $curp = (property_exists($params, "curp")) ? trim($params->curp) : null;
                $teacher_function = (property_exists($params, "teacher_function")) ? trim($params->teacher_function) : null;
                $specialty = (property_exists($params, "specialty")) ? trim($params->specialty) : null;
                $education_level = (property_exists($params, "education_level")) ? trim($params->education_level) : null;

                $teacher->setFullname($fullname)
                        ->setCurp($curp)
                        ->setEducationLevel($this->getDoctrine()->getRepository('BackendBundle:EducationLevel')->find($education_level))
                        ->setSpeciality($this->getDoctrine()->getRepository('BackendBundle:Speciality')->find($specialty))
                        ->setTeacherFunction($this->getDoctrine()->getRepository('BackendBundle:TeacherFunction')->find($teacher_function))
                        ->setUpdateTime(new \DateTime('now'));

                $manager = $this->getDoctrine()->getManager();
                $manager->persist($teacher);
                $manager->flush();
				
				// Borramos las evaluaciones hechas
				// Elimina la Evaluacion diagnostica
				$query = 'DELETE FROM answer_inee_teacher WHERE teacher_id =' . $identity->teacher_id;
				$statement = $manager->getConnection()->prepare($query);
				$statement->execute();
				$query = 'UPDATE teacher SET evaluation_inee_finish = 0 WHERE teacher.id = ' . $identity->teacher_id;
				$statement = $manager->getConnection()->prepare($query);
				$statement->execute();
				$manager->flush();
				// Elimina la Evaluacion Siglo XXI
				$query = 'DELETE FROM teacher_answer_century WHERE teacher_id =' . $identity->teacher_id;
				$statement = $manager->getConnection()->prepare($query);
				$statement->execute();
				$query = 'UPDATE teacher SET did_finish_xxi_questionary = NULL WHERE teacher.id = ' . $identity->teacher_id;
				$statement = $manager->getConnection()->prepare($query);
				$statement->execute();
				$manager->flush();

                // Generamos el nuevo token
                $token = [
                    "sub" => $teacher->getUser()->getId(),
                    "email" => $teacher->getUser()->getEmail(),
                    "iat" => time(),
                    "expire" => time() + (7 * 24 * 60 * 60),
                    'teacher_id' => $teacher->getId(),
                    'fullname' => $teacher->getFullname(),
                    'curp' => $teacher->getCurp(),
                    'speciality_id' => $teacher->getSpeciality()->getId(),
                    'speciality' => $teacher->getSpeciality()->getName(),
                    'teacher_function_id' => $teacher->getTeacherFunction()->getId(),
                    'teacher_function' => $teacher->getTeacherFunction()->getName(),
                    'educational_level_id' => $teacher->getEducationLevel()->getId(),
                    'educational_level' => $teacher->getEducationLevel()->getName()
                ];

                $jwt = JWT::encode($token, $this->secret_key, 'HS256');

                return $helpers->json([
                            'status' => 'success',
                            'title' => 'Perfil actualizado',
                            'message' => 'La información se ha guardado correctamente',
                            'token' => $jwt
                ]);
        //    } else {
        //        return $helpers->json([
        //                    'status' => 'error',
        //                    'title' => 'Perfil no se puede actualizar!',
        //                    'message' => 'La información no se puede actualizar, porque tiene evaluaciones activas.'
        //        ]);
        //    }
        }

        /**
         * Método para validar si un CURP existe en la tabla de pre-registro
         * @param Request $request
         * @return mixed
         */
        public function checkCurpAction(Request $request) {
            $helpers = $this->get("app.helpers");
            $params = json_decode($request->get('json', null));

            $curp = (property_exists($params, "curp")) ? trim($params->curp) : null;

            $exists = $this->getDoctrine()->getRepository('BackendBundle:Teacher')->findOneBy([
                'curp' => $curp
            ]);

            if (is_object($exists)) {
                return $helpers->json([
                            'status' => 'error',
                            'code' => 1000,
                            'title' => 'CURP previamente registrado',
                            'message' => 'El CURP que has proporcionado ya esta registrado en el sistema'
                ]);
            }

            $teacher = $this->getDoctrine()->getRepository('BackendBundle:PreRegister')->findOneBy([
                'curp' => $curp
            ]);

            if (is_object($teacher)) {
                return $helpers->json([
                            'status' => 'success',
                            'title' => 'CURP encontrado',
                            'message' => 'Tu CURP se ha validado con éxito',
                            'data' => $teacher
                ]);
            }
            return $helpers->json([
                        'status' => 'error',
                        'code' => 1001,
                        'title' => 'CURP no encontrado',
                        'message' => 'No hemos podido validar tu CURP, sin embargo podrás continuar con tu registro'
            ]);
        }

        public function changeHomeAction(Request $request) {
            $helpers = $this->get("app.helpers");
            $params = json_decode($request->get('json', null));

            $manager = $this->getDoctrine()->getManager();

            if ($params->accionType == 1) {
                $query = 'UPDATE dashboard SET text_left = "' . trim($params->text_left) . '" ,text_right = "' . trim($params->text_right) . '" WHERE dashboard.id = 1;';
                $statement = $manager->getConnection()->prepare($query);
                $statement->execute();
            }

            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                        'status' => 200,
                        'title' => '¡Correcto!',
                        'message' => 'Se ha modificado correctamente el elemento.'
            ));
        }

        public function getHomeAction($id) {
            $helpers = $this->get("app.helpers");

            $manager = $this->getDoctrine()->getManager();

            $query = 'SELECT * FROM dashboard';
            $statement = $manager->getConnection()->prepare($query);
            $statement->execute();
            $data = $statement->fetchAll();
			
			// SIGLO XXI PARTICIPACIÓN NIVEL ESCOLAR
			$niveles = 'SELECT 
						EDLE.name AS NIVEL
						,SUM(TECH.did_finish_xxi_questionary) AS SIGLOXXI
						,SUM(TECH.evaluation_inee_finish) AS DIAGNOSTICA
						,COUNT(EDLE.id) AS INSCRITOS
					FROM education_level EDLE
					LEFT JOIN teacher TECH ON
						EDLE.id = TECH.education_level_id
					WHERE TECH.status = 1
					GROUP BY EDLE.id';
			$statement = $manager->getConnection()->prepare($niveles);
			$statement->execute();
			$data_1["niveles_educativos"] = $statement->fetchAll();
			
			$niveles = array(array('Nivel Escolar', '% Porcentaje'),);
			for($i=0; $i<count($data_1["niveles_educativos"]); $i++){
				$aux = array(
							$data_1["niveles_educativos"][$i]["NIVEL"],
							intval($data_1["niveles_educativos"][$i]["SIGLOXXI"])
							);
				$niveles[$i+1] = $aux; 
				$aux = array();
			}
			$_niveles_ = array("graph_nivel" => $niveles); 
			
			// EVALUACIÓN DIAGNÓSTICA PARTICIPACIÓN NIVEL ESCOLAR 			
			$graph_diagnostica = array(array('Nivel Escolar', '% Porcentaje'),);
			for($i=0; $i<count($data_1["niveles_educativos"]); $i++){
				$aux = array(
							$data_1["niveles_educativos"][$i]["NIVEL"],
							intval($data_1["niveles_educativos"][$i]["DIAGNOSTICA"])
							);
				$graph_diagnostica[$i+1] = $aux; 
				$aux = array();
			}
			$_graph_diagnostica_ = array("graph_diagnostica" => $graph_diagnostica); 
			
			// SIGLO XXI RESULTADOS  GLOBALES
			$result_global = 'SELECT 
								 SS.CVE_STATES
								,COALESCE(TOTAL,1) AS TOTAL
							FROM states_sigloxxi SS
							LEFT JOIN(
									SELECT 
										ESTADO
										,COUNT(ESTADO) AS TOTAL
									FROM(
										SELECT
											 met.skill_century_id	,met.habilidad
											,met.area_century_id	,met.area
											,met.resultado
											,CASE WHEN met.resultado BETWEEN met.min_vulnerable AND met.max_vulnerable THEN "VULNERABLE"
												  WHEN met.resultado BETWEEN met.min_competent  AND met.max_competent  THEN "COMPETENTE"
												  WHEN met.resultado BETWEEN met.min_otimum	    AND met.max_otimum	   THEN "OPTIMO"
												  ELSE "SIN APLICAR"
											END AS estado
											,met.fullname
										FROM(
											SELECT 
												 ac.skill_century_id
												,sc.name AS habilidad
												,qc.area_century_id
												,ac.name AS area
												,ac.min_vulnerable	,ac.max_vulnerable
												,ac.min_competent	,ac.max_competent
												,ac.min_otimum		,ac.max_otimum
												,SUM(aca.value) AS resultado
												,t.fullname
											FROM teacher_answer_century tac
											INNER JOIN question_century qc ON 
												tac.question_century_id = qc.id
											INNER JOIN area_century ac ON 
												qc.area_century_id = ac.id
											INNER JOIN skill_century sc ON 
												sc.id = ac.skill_century_id
											INNER JOIN answer_category aca ON
												tac.answer_category_id = aca.id
											INNER JOIN teacher t ON
												t.id = tac.teacher_id
											WHERE t.did_finish_xxi_questionary = 1
											GROUP BY
												 t.fullname
												,sc.name	,ac.name
												,ac.min_vulnerable	,ac.max_vulnerable
												,ac.min_competent   ,ac.max_competent
												,ac.min_otimum	    ,ac.max_otimum
											) met
										) core
									GROUP BY estado
									) RES ON
								SS.CVE_STATES = RES.ESTADO';
			$statement = $manager->getConnection()->prepare($result_global);
			$statement->execute();
			$data_2["estatus_nivel"] = $statement->fetchAll();
			
			$result_global = array(array('Estatus', '% Porcentaje'),);
			for($i=0; $i<count($data_2["estatus_nivel"]); $i++){
				$aux = array(
							$data_2["estatus_nivel"][$i]["CVE_STATES"],
							intval($data_2["estatus_nivel"][$i]["TOTAL"])
							);
				$result_global[$i+1] = $aux; 
				$aux = array();
			}
			$_result_global_ = array("estatus_nivel" => $result_global); 
			
			// EVALUACIÓN DIAGNÓSTICA RESULTADOS  GLOBALES
			$globales_diagnostica = 'SELECT 
										 d.name as dimesion
										,COUNT(ei.dimension_id) as total
									FROM evaluation_inee ei
									INNER JOIN dimension d ON
										d.id = ei.dimension_id
									GROUP BY ei.dimension_id';
			$statement = $manager->getConnection()->prepare($globales_diagnostica);
			$statement->execute();
			$data_3["globales_diagnostica"] = $statement->fetchAll();
			
			$globales_diagnostica = array(array('Nivel Escolar', '% Porcentaje'),);
			$labels = array();
			$sets = array();
			for($i=0; $i<count($data_3["globales_diagnostica"]); $i++){
				$aux = array(
							$data_3["globales_diagnostica"][$i]["dimesion"],
							intval($data_3["globales_diagnostica"][$i]["total"])
							);
				$globales_diagnostica[$i+1] = $aux; 
				$aux = array();
			}
			$_globales_diagnostica_ = array("globales_diagnostica" => $globales_diagnostica); 	
			
			// ESTATUS PROMEDIO EN LOS NIVELES EDUCATIVOS
			$globales_diagnostica = 'SELECT 
										 el.id as cve
										,d.id as cve_dimension
										,d.name as dimesion
										,COUNT(ei.dimension_id) as total
										,el.name as education_level
									FROM evaluation_inee ei
									INNER JOIN dimension d ON
										d.id = ei.dimension_id
									INNER JOIN education_level el ON
										ei.education_level_id = el.id
									GROUP BY ei.dimension_id
									ORDER BY d.id';
			$statement = $manager->getConnection()->prepare($globales_diagnostica);
			$statement->execute();
			$data_4["chart_data"] = $statement->fetchAll();
			
			$labels = array();
			$label = array();
			$values = array();
			$datasets = array();
			$sets = array();
			for($i=0; $i<count($data_4["chart_data"]); $i++){
				
				if($i == 0)
					$prev = intval($data_4["chart_data"][$i]["cve"]);
				
				array_push($labels , $data_4["chart_data"][$i]["cve_dimension"]);
				
				if($prev == intval($data_4["chart_data"][$i]["cve"])){
					array_push($values, intval($data_4["chart_data"][$i]["total"]));
				} else {
					$values = array();
					array_push($values, intval($data_4["chart_data"][$i]["total"]));
				}
				
				$color = "rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",0.2)";
				
				$zeros = array_fill(0,(count($data_4["chart_data"]) - count($values)),0);
				$val_zero = array_merge($values, $zeros);
				$sets[intval($data_4["chart_data"][$i]["cve"])] = 
																array(
																	 "label" => $data_4["chart_data"][$i]["education_level"],
																	 "backgroundColor" => $color,
																	 "data" => $val_zero
																	);
				$prev = intval($data_4["chart_data"][$i]["cve"]);
				
			}
			
			foreach($sets as $set){
				array_push($datasets, $set);
			}
			
			$chart_data = array("chart_data" => 
							array(
								array("labels" => $labels),
								array("datasets" => $datasets)
								 )
								);
								
			$info = array_merge($data, $data_1, $_niveles_, $_graph_diagnostica_, $_result_global_, $_globales_diagnostica_, $chart_data);
			
            /** @noinspection PhpUndefinedMethodInspection */
            return $helpers->json(array(
                        'status' => 200,
                        'data' => $info //data[0]
            ));
        }

    }

}
    
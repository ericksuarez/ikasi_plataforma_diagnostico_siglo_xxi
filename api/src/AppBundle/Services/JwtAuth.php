<?php

namespace AppBundle\Services {

    use BackendBundle\Entity\User;
    use Doctrine\ORM\EntityManager;
    use Firebase\JWT\JWT;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 12/10/16
     * Time: 19:15
     */
    class JwtAuth {

        /**
         * @var EntityManager $manager
         */
        private $manager;

        /**
         * @var Encrypt $encrypt
         */
        private $encrypt;

        /**
         * @var AccessControl $accessControl
         */
        private $accessControl;

        /**
         * @var string $secret_key Clave secreta para codificar el token
         */
        protected $secret_key = "PhehAfRe7Ef4xaCu7emu3h5s";
        
        /**
         * @var int codigo para indicar que no esta autorizado
         */
        const UNAUTHORIZED = 401;
        /**
         * JwtAuth constructor.
         * @param EntityManager $manager
         * @param Encrypt $encrypt
         * @param AccessControl $accessControl
         */
        public function __construct(EntityManager $manager, Encrypt $encrypt, AccessControl $accessControl) {
            $this->manager = $manager;
            $this->encrypt = $encrypt;
            $this->accessControl = $accessControl;
        }

        /**
         * Comprueba las credenciales de un usuario
         * @param $email
         * @param $password
         * @return array|object|string
         */
        public function signup($email, $password) {
            $user = $this->manager->getRepository('BackendBundle:User')->findOneBy([
                'email' => $email,
                'passwordHash' => $this->encrypt->encrypt($password)
            ]);

            if (is_object($user)) {
                if ($user->getStatus() == User::STATUS_INACTIVE) {
                    return ['status' => 'error', 'message' => 'La cuenta esta desactivada'];
                }

                /** @noinspection PhpUndefinedMethodInspection */
                $teacher = $this->manager->getRepository('BackendBundle:Teacher')->findOneBy([
                    'user' => $user->getId()
                ]);

                $token = [
                    "sub" => $user->getId(),
                    "email" => $user->getEmail(),
                    "iat" => time(),
                    "expire" => time() + (7 * 24 * 60 * 60)
                ];

                if (is_object($teacher)) {
                    $token['teacher_id'] = $teacher->getId();
                    $token['fullname'] = $teacher->getFullname();
                    $token['curp'] = $teacher->getCurp();
                    $token['speciality_id'] = $teacher->getSpeciality()->getId();
                    $token['speciality'] = $teacher->getSpeciality()->getName();
                    $token['teacher_function_id'] = $teacher->getTeacherFunction()->getId();
                    $token['teacher_function'] = $teacher->getTeacherFunction()->getName();
                    $token['educational_level_id'] = $teacher->getEducationLevel()->getId();
                    $token['educational_level'] = $teacher->getEducationLevel()->getName();
                }

                $jwt = JWT::encode($token, $this->secret_key, 'HS256');

                if ($this->accessControl->canManagement($user)) {
                    return ['status' => 'succes', 'token' => $jwt, 'canManagement' => time()];
                }

                return ['status' => 'succes', 'token' => $jwt];
            }

            return ['status' => 'error', 'message' => 'Usuario y/o contraseña incorrectos'];
        }

        /**
         * Valida el token obtenido
         * @param $jwt
         * @param bool $getIdentity
         * @return bool|object
         */
        public function checkToken($jwt, $getIdentity = false) {
            // Por default el login es false
            $auth = false;

            try {
                $decoded = JWT::decode($jwt, $this->secret_key, ['HS256']);
            } catch (\UnexpectedValueException $e) {
                return false;
            } catch (\DomainException $e) {
                return false;
            }

            if (property_exists($decoded, 'sub')) {
                $auth = true;
            }

            return $getIdentity == true ? $decoded : $auth;
        }

        /**
         * Regresa false si el usuario tiene permitido realizar modificaciones
         * como administrador o regresa un arreglo con el detalle del error
         * @param Request $request
         * @param $access_control
         * @return array|bool
         */
        public function isAuthorizedToChange(Request $request, $access_control) {
            $error = false;
            $authorization = $request->headers->get('X-API-KEY');
            // Servicio del JWT

            // Control de acceso
            if (empty($authorization)) {
                return ['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized'];
            }

            $userData = $this->checkToken($authorization, true);
            /** @noinspection PhpUndefinedMethodInspection */
            $accessGranted = $access_control->accessGrantedForAdmin($userData);
            if (is_array($accessGranted)) {
                return $accessGranted;
            }
            return $error;
        }

    }

}
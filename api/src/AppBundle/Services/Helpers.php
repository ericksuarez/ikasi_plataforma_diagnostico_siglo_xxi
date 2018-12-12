<?php

/**
 * Created by PhpStorm.
 * User: wsense
 * Date: 12/10/16
 * Time: 18:50
 */
namespace AppBundle\Services {

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Serializer\Encoder\JsonEncoder;
    use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
    use Symfony\Component\Serializer\Serializer;

    class Helpers
    {
        /**
         * @var JwtAuth $jwt_auth
         */
        public $jwt_auth;

        /**
         * Helpers constructor.
         * @param JwtAuth $jwt_auth
         */
        public function __construct(JwtAuth $jwt_auth)
        {
            $this->jwt_auth = $jwt_auth;
        }

        /**
         * Checa si el usuario tiene acceso para consumir el API
         * @param $hash
         * @param bool $getIdentity
         * @return bool|object
         */
        public function authCheck($hash, $getIdentity = false)
        {
            $auth = false;

            if (!empty($hash)) {
                if ($getIdentity === false) {
                    $check_token = $this->jwt_auth->checkToken($hash);
                    if ($check_token) {
                        $auth = true;
                    }
                } else {
                    $check_token = $this->jwt_auth->checkToken($hash, $getIdentity);
                    if (is_object($check_token)) {
                        $auth = $check_token;
                    }
                }
            }

            return $auth;
        }

        /**
         * Convierte una respuesta en objeto json
         * @param $data
         * @return Response
         */
        public function json($data)
        {
            $normailizer = [new GetSetMethodNormalizer()];
            $encoders = [new JsonEncoder()];

            $serializer = new Serializer($normailizer, $encoders);

            $json = $serializer->serialize($data, 'json');

            $response = new Response();
            $response->setContent($json);
            $response->headers->set("Content-Type", "application/json");

            return $response;
        }
    }
}
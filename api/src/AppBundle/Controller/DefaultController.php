<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * Login de usuario
     * Compara email y contraseña, en caso de éxito se devuelve un token, en caso de fallo se regresa un json con la
     * respuesta
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        // Servicio Helpers
       
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");

        $json = $request->get("json", null);

        if (!empty($json)) {
            $params = json_decode($json);
            $email = (isset($params->email)) ? $params->email : null;
            $password = (isset($params->password)) ? $params->password : null;

            $emailConstraint = new Email();
            $emailConstraint->message = "El formato del email es inválido";

            $validate_email = $this->get("validator")->validate($email, $emailConstraint);

            if (count($validate_email) === 0 && !empty($password)) {
                return new JsonResponse($jwt_auth->signup($email, $password));
            } else {
                return $helpers->json(['status' => 'error', 'message' => 'Error al validar los datos']);
            }

        }

        return $helpers->json(['status' => 'error', 'message' => 'Parametros requeridos ausentes']);
    }

    /**
     * Perfil de usuario
     * @param Request $request
     * @return JsonResponse
     */
    public function profileAction(Request $request)
    {
        $authorization = $request->headers->get('X-API-KEY');
        // Servicio Helpers
        $helpers = $this->get("app.helpers");
        // Servicio del JWT
        $jwt_auth = $this->get("app.jwt_auth");

        if(empty($authorization)) {
            return $helpers->json(['status' => 'error', 'message' => 'Imposible verificar datos']);
        }

        return new JsonResponse($jwt_auth->checkToken($authorization, true));
    }
}

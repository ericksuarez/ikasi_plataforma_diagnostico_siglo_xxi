<?php

namespace AppBundle\Controller {

    use AppBundle\Services\Email;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 26/10/16
     * Time: 13:52
     */
    class ContactController extends Controller {

        /**
         * Envía un correo electrónico
         * @param Request $request
         * @return mixed
         */
        public function sendAction(Request $request) {
            $helpers = $this->get('app.helpers');
            $access_control = $this->get('app.access_control');
            $params = json_decode($request->get("json", null));

            if (!empty($params)) {
                $mail = $this->get('app.email');
                $emailListAdmin = $access_control->getEmailAdmin();

                $emails = array_map(function ($item) {
                    return $item['email'];
                }, $emailListAdmin);

                $mail->send(Email::CONTACT, get_object_vars($params), $emails);
                return $helpers->json([
                            'status' => 'success',
                            'message' => 'El mensaje se ha enviado correctamente'
                ]);
            }

            return $helpers->json([
                        'status' => 'error',
                        'message' => 'Ocurrio un error al enviar el mensaje, intente más tarde'
            ]);
        }

        public function sendTestAction(Request $request) {
            $mail = $this->get('app.email');
            $helpers = $this->get('app.helpers');
            
            $emails = "erick.suarez.buendia@gmail.com";
            $msj = $mail->send(Email::CONTACT, array("name" => "Erick", "email" => "5d48+", "subject" => "123", "message" => "mensaje"), $emails);
            return $helpers->json([
                        'status' => 'success',
                        'message' => $msj
            ]);
        }

    }

}
<?php

namespace AppBundle\Services {

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 24/10/16
     * Time: 16:24
     */
    class Email
    {
        protected $templating;

        protected $mailer;

        // Clave para hacer el envio de un mail de activación de cuenta
        const ACTIVATE = 1;
        // Clave para hacer el envio de un mail de contacto
        const CONTACT = 2;
        // Clave para hacer el envio de un email de recuperación de contraseña
        const PASSWORD_RECOVERY = 3;

        /**
         * Configuración de plantillas del sistema
         * @var array
         */
        protected $templates = [
            self::ACTIVATE => [
                'subject' => 'Bienvenido al Sinadep - Activa tu cuenta',
                'template' => 'AppBundle:Email:confirmation.html.twig'
            ],
            self::CONTACT => [
                'subject' => 'Contacto',
                'template' => 'AppBundle:Email:contact.html.twig'
            ],
            self::PASSWORD_RECOVERY => [
                'subject' => 'Recuperación de contraseña',
                'template' => 'AppBundle:Email:password_recovery.html.twig'
            ]
        ];

        /**
         * Email constructor.
         * @param $templating
         * @param $mailer
         */
        public function __construct($templating, $mailer)
        {
            $this->templating = $templating;
            $this->mailer = $mailer;
        }

        /**
         * Función para enviar un correo electrónico
         * @param $case
         * @param $data
         * @param $receivers
         */
 public function send($case, $data, $receivers) {
            $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
            $this->mailer->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));

            /** @noinspection PhpUndefinedMethodInspection */
//            $message = (new \Swift_Message('Hello Email'))
            $message = \Swift_Message::newInstance()
                    ->setSubject($this->templates[$case]['subject'])
                    ->setFrom('contacto@diagnosticosxxi.org')
                    ->setTo($receivers)
                    ->setBcc($receivers)
                    ->setBody(
                    $this->templating->render($this->templates[$case]['template'], $data), 'text/html'
            );

            /** @noinspection PhpUndefinedMethodInspection */
//            $this->mailer->send($message);
            if ($this->mailer->send($message)) {
                return '[SEND EMAIL]' . $mailLogger->dump();
            } else {
                return '[NOT SENDING EMAIL]: ' . $mailLogger->dump();
            }
        }
    }
}
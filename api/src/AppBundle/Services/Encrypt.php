<?php

namespace AppBundle\Services {

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 13/10/16
     * Time: 13:36
     */
    class Encrypt
    {
        protected $salt = "CAdAprabRezunasPeHufr82A";

        /**
         * Encripta un string
         * @param $text
         * @return string
         */
        public function encrypt($text)
        {
            return trim(base64_encode(
                    mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->salt, $text, MCRYPT_MODE_ECB,
                        mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))
                )
            );
        }

        /**
         * Desencripta un string
         * @param $text
         * @return string
         */
        public function decrypt($text)
        {
            return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->salt, base64_decode($text), MCRYPT_MODE_ECB,
                mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)
            ));
        }
    }
}
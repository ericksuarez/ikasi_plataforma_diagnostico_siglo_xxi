<?php

namespace AppBundle\Services {

    use BackendBundle\Entity\User;
    use Doctrine\ORM\EntityManager;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 26/10/16
     * Time: 17:01
     */
    class AccessControl
    {
        const UNAUTHORIZED = 401;

        /**
         * @var EntityManager $manager
         */
        private $manager;

        /**
         * AccessControl constructor.
         * @param EntityManager $manager
         */
        public function __construct(EntityManager $manager)
        {
            $this->manager = $manager;
        }

        /**
         * Devuelve el email del administrador
         * @return array
         */
        public function getEmailAdmin()
        {
            $repository = $this->manager->getRepository('BackendBundle:User');

            $query = $repository->createQueryBuilder('u')
                ->select(['u.email'])
                ->where('u.userRole = :userRole')
                ->setParameter('userRole', $this->getAdminRole())
                ->getQuery();

            return $query->getResult();
        }

        /**
         * Devuelve los datos del usuario
         * @param $id
         * @return null|object
         */
        public function getUser($id)
        {
            return $this->manager->getRepository('BackendBundle:User')->find($id);
        }

        /**
         * Verifica si el usuario es administrador
         * @param User $user
         * @return bool
         */
        public function canManagement(User $user)
        {
            if ($user->getUserRole() == $this->getAdminRole()) {
                return true;
            }

            return false;
        }

        /**
         * Devuelve el rol de admnistrador
         * @return null|object
         */
        private function getAdminRole()
        {
            return $this->manager->getRepository('BackendBundle:UserRole')->findOneBy([
                'name' => 'administrator'
            ]);
        }

        /**
         * Verifica si el usuario que hace la petición tiene permiso de administrador
         * @param $userData
         * @return array|bool
         */
        public function accessGrantedForAdmin($userData)
        {
            if (!$userData) {
                return ['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized'];
            }

            $user = $this->getUser($userData->sub);

            if (empty($user)) {
                return ['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized'];
            }

            /** @noinspection PhpParamsInspection */
            return ($this->canManagement($user)) ? true : ['status' => 'error', 'code' => $this::UNAUTHORIZED, 'message' => 'Unauthorized'];
        }
    }
}
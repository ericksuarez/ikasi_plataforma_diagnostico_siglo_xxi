<?php

namespace AppBundle\Services {

    use BackendBundle\Entity\PreRegister;
    use Doctrine\ORM\EntityManager;
    use Symfony\Component\Validator\Validator\RecursiveValidator;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 20/01/17
     * Time: 12:40
     */
    class ImportTeacher
    {
        /**
         * @var EntityManager $manager
         */
        private $manager;

        /**
         * @var RecursiveValidator $validator
         */
        private $validator;

        public $headers;

        protected $attributes = [
            'nombre_completo' => 'name',
            'curp' => 'curp',
            'funcion' => 'teacher_function',
            'nivel' => 'education_level',
            'especialidad' => 'speciality',
            'email' => 'email'
        ];

        /**
         * AccessControl constructor.
         * @param EntityManager $manager
         * @param RecursiveValidator $validator
         */
        public function __construct(EntityManager $manager, RecursiveValidator $validator)
        {
            $this->manager = $manager;
            $this->validator = $validator;
        }

        /**
         * Método para importación de datos
         * @param $file
         * @return int
         */
        public function execute($file)
        {
            $totalItemsImport = 0;
            if (($handle = fopen($file, 'r')) !== false) {
                $this->headers = $this->getHeaders($handle);
                $data = $this->getDataImport($handle);
                foreach ($data as $insert) {
                    /** @noinspection SqlDialectInspection */
                    /** @noinspection SqlNoDataSourceInspection */
                    $queryEducationLevel = $this->manager->createQuery(
                        'SELECT el.id
                        FROM BackendBundle:EducationLevel el
                        WHERE el.name LIKE :education_level'
                    )->setParameter('education_level', '%' .strtolower($insert['education_level']) . '%');
                    $educationLevel = $queryEducationLevel->getOneOrNullResult();
                    $_educationLevel = (empty($educationLevel)) ? $educationLevel : $educationLevel['id'];
                    /** @noinspection SqlDialectInspection */
                    /** @noinspection SqlNoDataSourceInspection */
                    $querySpeciality = $this->manager->createQuery(
                        'SELECT el.id
                        FROM BackendBundle:Speciality el
                        WHERE el.name LIKE :speciality'
                    )->setParameter('speciality', '%' .strtolower($insert['speciality']) . '%');
                    $speciality = $querySpeciality->getOneOrNullResult();
                    $_speciality = (empty($speciality)) ? $speciality : $speciality['id'];
                    /** @noinspection SqlDialectInspection */
                    /** @noinspection SqlNoDataSourceInspection */
                    $queryTeacherFunction = $this->manager->createQuery(
                        'SELECT el.id
                        FROM BackendBundle:TeacherFunction el
                        WHERE el.name LIKE :teacher_function'
                    )->setParameter('teacher_function', '%' .strtolower($insert['teacher_function']) . '%');
                    $teacherFunction = $queryTeacherFunction->getOneOrNullResult();
                    $_teacherFunction = (empty($teacherFunction)) ? $teacherFunction : $teacherFunction['id'];

                    $teacher = new PreRegister();
                    $teacher->setName($insert['name'])
                    ->setCurp($insert['curp'])
                    ->setEducationLevel($_educationLevel)
                    ->setSpeciality($_speciality)
                    ->setTeacherFunction($_teacherFunction)
                    ->setEmail($insert['email']);

                    $this->manager->persist($teacher);
                    if(count($this->validator->validate($teacher)) == 0) {
                        $this->manager->flush();
                        $totalItemsImport++;
                    }
                }
            }

            return $totalItemsImport;
        }

        /**
         * @param $handle
         * @return array
         */
        private function getHeaders($handle)
        {
            // Obtenemos la primera linea de la lectura
            $headers = fgetcsv($handle, 1000, ",");

            $headers = array_map(function ($item) {
                return $item;
            }, $headers);

            return $headers;
        }

        /**
         * @param $handle
         * @return array
         */
        private function getDataImport($handle)
        {
            $collection = [];
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                $single = [];
                foreach ($data as $key => $col) {
                    // Atributo a buscar
                    $_header = $this->headers[$key];
                    foreach ($this->attributes as $attr_key => $attribute) {
                        if ($_header == $attr_key) {
                            $single[$attribute] = utf8_encode($col);
                        }
                    }
                }

                // Agregamos a la colección de modelos
                array_push($collection, $single);
            }
            return $collection;
        }
    }
}
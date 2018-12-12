<?php

namespace AppBundle\Services {

    use BackendBundle\Entity\AnswerInee;
    use BackendBundle\Entity\Dimension;
    use BackendBundle\Entity\EvaluationInee;
    use BackendBundle\Entity\Indicator;
    use BackendBundle\Entity\Parameter;
    use Doctrine\ORM\EntityManager;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 02/03/17
     * Time: 17:34
     */
    class ImportInee
    {
        /**
         * @var EntityManager $manager
         */
        private $manager;

        /**
         * @var string Parametros para guardar perfiles
         */
        private $params;

        /**
         * @var string File to import
         */
        private $file;

        /**
         * ImportInee constructor.
         * @param EntityManager $manager
         */
        public function __construct(EntityManager $manager)
        {
            $this->manager = $manager;
        }

        /**
         * Importación de perfiles del INEE
         * @param $file
         * @param $params
         * @return int
         */
        public function execute($file, $params)
        {
            $this->params = $params;
            $this->file = $file;

            switch ($params->typeImport) {
                case 1:
                    $totalItems = $this->importDimension();
                    break;
                case 2:
                    $totalItems = $this->importParameter();
                    break;
                case 3:
                    $totalItems = $this->importIndicator();
                    break;
                case 4:
                    $totalItems = $this->importQuestions();
                    break;
                default:
                    $totalItems = 0;
                    break;
            }

            return $totalItems;
        }

        /**
         * Importación de dimensiones
         * @return int
         */
        private function importDimension()
        {
            $totalItemsImport = 0;
            if (($handle = fopen($this->file, 'r')) !== false) {
                while (($data = fgetcsv($handle, 0, "|")) !== false) {
                    foreach ($data as $import) {
                        $dimension = new Dimension();
                        /** @noinspection PhpUndefinedFieldInspection */
                        $dimension->setName($import)
                            ->setEducationLevel($this->manager->getRepository('BackendBundle:EducationLevel')->find($this->params->education_level))
                            ->setTeacherFunction($this->manager->getRepository('BackendBundle:TeacherFunction')->find($this->params->teacher_function))
                            ->setCreateTime(new \DateTime('now'));
                        $this->manager->persist($dimension);
                        $this->manager->flush();
                        $totalItemsImport++;
                    }
                }
            }

            return $totalItemsImport;
        }

        /**
         * Importación de parámetros
         * @return int
         */
        private function importParameter()
        {
            $totalItemsImport = 0;
            if (($handle = fopen($this->file, 'r')) !== false) {
                while (($data = fgetcsv($handle, 0, "|")) !== false) {
                    foreach ($data as $import) {
                        $parameter = new Parameter();
                        /** @noinspection PhpUndefinedFieldInspection */
                        $parameter->setName($import)
                            ->setDimension($this->manager->getRepository('BackendBundle:Dimension')->find($this->params->dimension))
                            ->setCreateTime(new \DateTime('now'));
                        $this->manager->persist($parameter);
                        $this->manager->flush();
                        $totalItemsImport++;
                    }
                }
            }

            return $totalItemsImport;
        }

        /**
         * Importación de indicadores
         * @return int
         */
        private function importIndicator()
        {
            $totalItemsImport = 0;
            if (($handle = fopen($this->file, 'r')) !== false) {
                while (($data = fgetcsv($handle, 0, "|")) !== false) {
                    foreach ($data as $import) {
                        $indicator = new Indicator();
                        /** @noinspection PhpUndefinedFieldInspection */
                        $indicator->setName($import)
                            ->setParameter($this->manager->getRepository('BackendBundle:Parameter')->find($this->params->parameter))
                            ->setCreateTime(new \DateTime('now'));
                        $this->manager->persist($indicator);
                        $this->manager->flush();
                        $totalItemsImport++;
                    }
                }
            }

            return $totalItemsImport;
        }

        /**
         * Import questions from csv
         * @return int
         */
        private function importQuestions()
        {
            $totalItemsImport = 0;
            if (($handle = fopen($this->file, 'r')) !== false) {
                while (($questionCsv = fgetcsv($handle, 0, "|")) !== false) {
                    $question = new EvaluationInee();
                    $question->setArgumentation($questionCsv[0])
                        ->setReagentBase($questionCsv[1])
                        ->setEducationLevel($this->manager->getRepository('BackendBundle:EducationLevel')->find($this->params->education_level))
                        ->setTeacherFunction($this->manager->getRepository('BackendBundle:TeacherFunction')->find($this->params->teacher_function))
                        ->setDimension($this->manager->getRepository('BackendBundle:Dimension')->find($this->params->dimension))
                        ->setParameter($this->manager->getRepository('BackendBundle:Parameter')->find($this->params->parameter))
                        ->setIndicator($this->manager->getRepository('BackendBundle:Indicator')->find($this->params->indicator))
                        ->setCreateTime(new \DateTime('now'));

                    $this->manager->persist($question);
                    $this->manager->flush();
                    $answerCollection = explode("¬", $questionCsv[2]);
                    $correctAnswerId = null;

                    foreach ($answerCollection as $answer) {
                        $answer = trim($answer);
                        $answerInee = new AnswerInee();
                        $answerInee->setTitle($answer)
                            ->setEvaluationInee($this->manager->getRepository('BackendBundle:EvaluationInee')->find($question->getId()))
                            ->setCreateTime(new \DateTime('now'));
                        $this->manager->persist($answerInee);
                        $this->manager->flush();
                        if(trim($questionCsv[3]) == $answer) {
                            $correctAnswerId = $answerInee->getId();
                        }
                    }

                    $question->setCorrectAnswer($this->manager->getRepository('BackendBundle:AnswerInee')->find($correctAnswerId));
                    $this->manager->persist($question);
                    $this->manager->flush();
                    $totalItemsImport++;
                }
            }
            return $totalItemsImport;
        }
    }
}
<?php

namespace AppBundle\Services {

    use BackendBundle\Entity\AnswerIneeTeacher;
    use Doctrine\ORM\EntityManager;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 17/09/17
     * Time: 15:57
     */
    class IneeResults {

        /**
         * @var EntityManager $manager
         */
        private $manager;

        /**
         * AccessControl constructor.
         * @param EntityManager $manager
         */
        public function __construct(EntityManager $manager) {
            $this->manager = $manager;
        }

        public function run($teacher) {
            $answers = $this->manager->getRepository(AnswerIneeTeacher::class)->findBy([
                'teacher' => $teacher
            ]);

            $dimensions = [];
			$tagDimensions = [];
            $ideal = ['data' => [], 'label' => 'Porcentaje ideal'];
            $user = ['data' => [], 'label' => $teacher->getFullname()];
            $vulnerable = [];
            $count = 0;
            $countDimension = 1;

            foreach ($answers as $key => $answer) {
                if ($answer->getEvaluationInee()->getCorrectAnswer()->getId() === $answer->getAnswerInee()->getId()) {
                    $count++;
                }

                if (array_key_exists($key + 1, $answers)) {
                    if ($answer->getDimension()->getName() !== $answers[$key + 1]->getDimension()->getName()) {
                        array_push($user['data'], $count);
                    //    array_push($dimensions, substr($answer->getDimension()->getName(), 0, 50)."...");
						$dimension_tag = "D-" . $countDimension++;
						array_push($dimensions, $dimension_tag);
						array_push($tagDimensions, $dimension_tag." .- ".$answer->getDimension()->getName());
                        array_push($ideal['data'], $answer->getTotal());
                        if ($count != $answer->getTotal()) {
                            array_push($vulnerable, $answer->getDimension()->getId());
                        }
                        $count = 0;
                    }
                } else {
                    array_push($user['data'], $count);
                //    array_push($dimensions, substr($answer->getDimension()->getName(), 0, 50)."...");
					$dimension_tag = "D-" . $countDimension++;
					array_push($dimensions, $dimension_tag);
					array_push($tagDimensions, $dimension_tag." .- ".$answer->getDimension()->getName());
                    array_push($ideal['data'], $answer->getTotal());
                    if ($count != $answer->getTotal()) {
                        array_push($vulnerable, $answer->getDimension()->getId());
                    }
                }
            }

            return [
                'dimensions' => $dimensions,
				'tagDimensions' => $tagDimensions,
                'data' => [$ideal, $user],
                'vulnerable' => $vulnerable
            ];
        }

    }

}
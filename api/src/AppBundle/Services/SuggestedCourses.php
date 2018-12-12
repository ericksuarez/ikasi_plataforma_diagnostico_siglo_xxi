<?php

namespace AppBundle\Services {

    use BackendBundle\Entity\Course;
    use Doctrine\ORM\EntityManager;

    /**
     * Created by PhpStorm.
     * User: aldorodriguez
     * Date: 29/12/16
     * Time: 17:48
     */
    class SuggestedCourses {

        /**
         * @var EntityManager $manager
         */
        private $manager;

        /**
         * @var IneeResults $ineeResults
         */
        private $ineeResults;

        /**
         * AccessControl constructor.
         * @param EntityManager $manager
         * @param IneeResults $ineeResults
         */
        public function __construct(EntityManager $manager, IneeResults $ineeResults) {
            $this->manager = $manager;
            $this->ineeResults = $ineeResults;
        }

        /**
         * Corre el algoritmo de sugerencia de cursos basado en habiidades del siglo XXI
         * @param $teacherId
         * @return array
         */
        public function run($teacherId) {
            $suggestionsXXI = [];
            $suggestionsINEE = [];
            $teacher = $this->manager->getRepository('BackendBundle:Teacher')->findOneBy([
                'id' => $teacherId
            ]);

//            if (!is_null($teacher->getDidFinishXxiQuestionary())) {
//                $areas = $this->manager->getRepository("BackendBundle:AreaCentury")->findAll();
//
//                $vulnerables = $this->getVulnerables($areas, $teacher);
//
//                $query = $this->manager->getRepository('BackendBundle:Course')
//                        ->createQueryBuilder('c')
//                        ->where('c.skillCentury IN (:ids)')
//                        ->setParameter('ids', $vulnerables['skills'])
//                        ->getQuery();
//                $courses = $query->getResult();
//
//                $suggestionsXXI = $this->getSuggestions($courses, $vulnerables['areas'], $teacher);
//            }
//
//            if (!is_null($teacher->getEvaluationIneeFinish())) {
            $query = 'SELECT sugc.id
                        FROM(
                            SELECT
                                met.skill_century_id	,met.habilidad
                               ,met.area_century_id	,met.area
                               ,met.resultado
                               ,CASE WHEN met.resultado BETWEEN met.min_vulnerable AND met.max_vulnerable THEN "VULNERABLE"
                                         WHEN met.resultado BETWEEN met.min_competent  AND met.max_competent  THEN "COMPETENTE"
                                         WHEN met.resultado BETWEEN met.min_otimum	    AND met.max_otimum	   THEN "OPTIMO"
                               END AS estado
                           FROM(
                                SELECT 
                                         ac.skill_century_id
                                        ,sc.name AS habilidad
                                        ,qc.area_century_id
                                        ,ac.name AS area
                                        ,ac.min_vulnerable	,ac.max_vulnerable
                                        ,ac.min_competent	,ac.max_competent
                                        ,ac.min_otimum		,ac.max_otimum
                                        ,SUM(aca.value) AS resultado
                                FROM teacher_answer_century tac
                                INNER JOIN question_century qc ON 
                                        tac.question_century_id = qc.id
                                INNER JOIN area_century ac ON 
                                        qc.area_century_id = ac.id
                                INNER JOIN skill_century sc ON 
                                        sc.id = ac.skill_century_id
                                INNER JOIN answer_category aca ON
                                        tac.answer_category_id = aca.id
                                WHERE tac.teacher_id = ' . $teacherId . '
                                GROUP BY
                                         sc.name	,ac.name
                                        ,ac.min_vulnerable	,ac.max_vulnerable
                                        ,ac.min_competent   ,ac.max_competent
                                        ,ac.min_otimum	    ,ac.max_otimum
                                ) met
                            ) core
                        INNER JOIN(
                                SELECT 
                                    c.id
                                   ,c.name
                                   ,c.description
                                   ,c.link
                                   ,c.image
                                   ,c.teacher_function_id
                                   ,c.speciality_id
                                   ,c.education_level_id
                                   ,c.type_suggestion
                                   ,c.skill_century_id
                                   ,c.area_century_ids
                                   ,c.dimension_id
                                   ,c.create_time
                                   ,c.update_time
                                   ,c.status
                                   ,c.delete_time
                                   ,sc.area_century_id
                                   ,sc.state
                                FROM suggested_course sc
                                INNER JOIN course c ON
                                    sc.course_id = c.id
                                ) sugc	ON
                    sugc.skill_century_id = core.skill_century_id	AND
                    sugc.area_century_id  = core.area_century_id		AND
                    sugc.state = core.estado';
            $statement = $this->manager->getConnection()->prepare($query);
            $statement->execute();
            $data = $statement->fetchAll();

//                $resultsInee = $this->ineeResults->run($teacher);
            $query = $this->manager->getRepository(Course::class)
                    ->createQueryBuilder('c')
                    ->where('c.id IN (:ids)')
                    ->setParameter('ids', $data)
//                        ->setParameter('ids', $resultsInee['vulnerable'])
                    ->getQuery();
            $suggestionsINEE = $query->getResult();
//            }
//            var_dump($suggestionsXXI); exit;

            foreach ($suggestionsINEE as $key => $value) {
                $query = $this->manager->getRepository(\BackendBundle\Entity\AreaCentury::class)
                        ->createQueryBuilder('c')
                        ->where('c.id IN (:ids)')
                        ->setParameter('ids', explode(",", str_replace("]", "", str_replace("[", "", $value->getAreaCenturyIds()))))
                        ->getQuery();
                $areas = $query->getResult();

                $areaNames = "";
                foreach ($areas as $key => $area) {
                    $areaNames .=  $area->getName() . ",";
                }
                $value->setAreaCenturyIds($areaNames);
            }
            return array_merge($suggestionsINEE);
        }

        /**
         * Obtiene las áreas vulnerables del profesor
         * @param $areas
         * @param $teacher
         * @return array
         */
        private function getVulnerables($areas, $teacher) {
            $vulnerableAreas = [];
            $skills = [];

            foreach ($areas as $area) {
                /** @noinspection SqlNoDataSourceInspection */
                /** @noinspection SqlDialectInspection */
                $query = $this->manager->createQuery(
                                'SELECT SUM(ac.value) 
                    FROM BackendBundle:TeacherAnswerCentury tac
                    INNER JOIN BackendBundle:AnswerCategory ac
                    WITH tac.answerCategory = ac.id
                    INNER JOIN BackendBundle:QuestionCentury qc
                    WITH tac.questionCentury = qc.id
                    WHERE tac.teacher = :teacher_id AND qc.areaCentury = :area_century_id'
                        )->setParameter('teacher_id', $teacher->getId())
                        ->setParameter('area_century_id', $area->getId());

                $result = $query->getSingleResult();

                /** @noinspection PhpUndefinedMethodInspection */
                if ($result[1] <= $area->getMaxCompetent()) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    array_push($skills, $area->getSkillCentury()->getId());
                    /** @noinspection PhpUndefinedMethodInspection */
                    array_push($vulnerableAreas, $area->getId());
                }
            }

            return [
                'skills' => array_unique($skills),
                'areas' => $vulnerableAreas
            ];
        }

        /**
         * Devuelve los cursos que coincidan con las áreas vulnerables del profesor
         * @param $courses
         * @param $areas
         * @param $teacher
         * @return array
         */
        private function getSuggestions($courses, $areas, $teacher) {
            $suggestions = [];
            foreach ($courses as $course) {
                $match = 0;
                $matchProfile = 0;
                /** @noinspection PhpUndefinedMethodInspection */
                if ($course->getTeacherFunction()->getId() == $teacher->getTeacherFunction()->getId())
                    $matchProfile++;
                /** @noinspection PhpUndefinedMethodInspection */
                if ($course->getSpeciality()->getId() == $teacher->getSpeciality()->getId())
                    $matchProfile++;
                /** @noinspection PhpUndefinedMethodInspection */
                if ($course->getEducationLevel()->getId() == $teacher->getEducationLevel()->getId())
                    $matchProfile++;

                if ($matchProfile == 0)
                    continue;

                /** @noinspection PhpUndefinedMethodInspection */
                $config = json_decode($course->getAreaCenturyIds());
                foreach ($config as $item) {
                    if (in_array($item, $areas)) {
                        $match++;
                    }
                }
                if ($match > 0) {
                    array_push($suggestions, $course);
                }
            }

            return $suggestions;
        }

    }

}
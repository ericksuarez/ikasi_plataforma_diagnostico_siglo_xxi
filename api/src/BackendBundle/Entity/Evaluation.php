<?php

namespace BackendBundle\Entity;

/**
 * Evaluation
 */
class Evaluation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $numberQuestions;

    /**
     * @var integer
     */
    private $minimumRating;

    /**
     * @var integer
     */
    private $timeResolve;

    /**
     * @var \DateTime
     */
    private $createTime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     */
    private $updateTime = '0000-00-00 00:00:00';

    /**
     * @var TeacherFunction
     */
    private $teacherFunction;

    /**
     * @var Speciality
     */
    private $speciality;

    /**
     * @var EducationLevel
     */
    private $educationLevel;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Evaluation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evaluation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set numberQuestions
     *
     * @param integer $numberQuestions
     *
     * @return Evaluation
     */
    public function setNumberQuestions($numberQuestions)
    {
        $this->numberQuestions = $numberQuestions;

        return $this;
    }

    /**
     * Get numberQuestions
     *
     * @return integer
     */
    public function getNumberQuestions()
    {
        return $this->numberQuestions;
    }

    /**
     * Set minimumRating
     *
     * @param integer $minimumRating
     *
     * @return Evaluation
     */
    public function setMinimumRating($minimumRating)
    {
        $this->minimumRating = $minimumRating;

        return $this;
    }

    /**
     * Get minimumRating
     *
     * @return integer
     */
    public function getMinimumRating()
    {
        return $this->minimumRating;
    }

    /**
     * Set timeResolve
     *
     * @param integer $timeResolve
     *
     * @return Evaluation
     */
    public function setTimeResolve($timeResolve)
    {
        $this->timeResolve = $timeResolve;

        return $this;
    }

    /**
     * Get timeResolve
     *
     * @return integer
     */
    public function getTimeResolve()
    {
        return $this->timeResolve;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Evaluation
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return Evaluation
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set teacherFunction
     *
     * @param TeacherFunction $teacherFunction
     *
     * @return Evaluation
     */
    public function setTeacherFunction(TeacherFunction $teacherFunction = null)
    {
        $this->teacherFunction = $teacherFunction;

        return $this;
    }

    /**
     * Get teacherFunction
     *
     * @return TeacherFunction
     */
    public function getTeacherFunction()
    {
        return $this->teacherFunction;
    }

    /**
     * Set speciality
     *
     * @param Speciality $speciality
     *
     * @return Evaluation
     */
    public function setSpeciality(Speciality $speciality = null)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return Speciality
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set educationLevel
     *
     * @param EducationLevel $educationLevel
     *
     * @return Evaluation
     */
    public function setEducationLevel(EducationLevel $educationLevel = null)
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    /**
     * Get educationLevel
     *
     * @return EducationLevel
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }
}

<?php

namespace BackendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * EvaluationInee
 */
class EvaluationInee
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BackendBundle\Entity\EducationLevel
     * @Assert\NotBlank()
     */
    private $educationLevel;

    /**
     * @var \BackendBundle\Entity\TeacherFunction
     * @Assert\NotBlank()
     */
    private $teacherFunction;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $reagentBase;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $argumentation;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var \BackendBundle\Entity\Dimension
     * @Assert\NotBlank()
     */
    private $dimension;

    /**
     * @var \BackendBundle\Entity\Parameter
     * @Assert\NotBlank()
     */
    private $parameter;

    /**
     * @var \BackendBundle\Entity\Indicator
     * @Assert\NotBlank()
     */
    private $indicator;

    /**
     * @var \BackendBundle\Entity\AnswerInee
     */
    private $correctAnswer;


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
     * Set reagentBase
     *
     * @param string $reagentBase
     *
     * @return EvaluationInee
     */
    public function setReagentBase($reagentBase)
    {
        $this->reagentBase = $reagentBase;

        return $this;
    }

    /**
     * Get reagentBase
     *
     * @return string
     */
    public function getReagentBase()
    {
        return $this->reagentBase;
    }

    /**
     * Set argumentation
     *
     * @param string $argumentation
     *
     * @return EvaluationInee
     */
    public function setArgumentation($argumentation)
    {
        $this->argumentation = $argumentation;

        return $this;
    }

    /**
     * Get argumentation
     *
     * @return string
     */
    public function getArgumentation()
    {
        return $this->argumentation;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return EvaluationInee
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return EvaluationInee
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
     * @return EvaluationInee
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
     * Set dimension
     *
     * @param \BackendBundle\Entity\Dimension $dimension
     *
     * @return EvaluationInee
     */
    public function setDimension(\BackendBundle\Entity\Dimension $dimension = null)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return \BackendBundle\Entity\Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set parameter
     *
     * @param \BackendBundle\Entity\Parameter $parameter
     *
     * @return EvaluationInee
     */
    public function setParameter(\BackendBundle\Entity\Parameter $parameter = null)
    {
        $this->parameter = $parameter;

        return $this;
    }

    /**
     * Get parameter
     *
     * @return \BackendBundle\Entity\Parameter
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * Set indicator
     *
     * @param \BackendBundle\Entity\Indicator $indicator
     *
     * @return EvaluationInee
     */
    public function setIndicator(\BackendBundle\Entity\Indicator $indicator = null)
    {
        $this->indicator = $indicator;

        return $this;
    }

    /**
     * Get indicator
     *
     * @return \BackendBundle\Entity\Indicator
     */
    public function getIndicator()
    {
        return $this->indicator;
    }

    /**
     * Set correctAnswer
     *
     * @param \BackendBundle\Entity\AnswerInee $correctAnswer
     *
     * @return EvaluationInee
     */
    public function setCorrectAnswer(\BackendBundle\Entity\AnswerInee $correctAnswer = null)
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }

    /**
     * Get correctAnswer
     *
     * @return \BackendBundle\Entity\AnswerInee
     */
    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    /**
     * Set educationLevel
     *
     * @param \BackendBundle\Entity\EducationLevel $educationLevel
     *
     * @return EvaluationInee
     */
    public function setEducationLevel(\BackendBundle\Entity\EducationLevel $educationLevel = null)
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    /**
     * Get educationLevel
     *
     * @return \BackendBundle\Entity\EducationLevel
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }

    /**
     * Set teacherFunction
     *
     * @param \BackendBundle\Entity\TeacherFunction $teacherFunction
     *
     * @return EvaluationInee
     */
    public function setTeacherFunction(\BackendBundle\Entity\TeacherFunction $teacherFunction = null)
    {
        $this->teacherFunction = $teacherFunction;

        return $this;
    }

    /**
     * Get teacherFunction
     *
     * @return \BackendBundle\Entity\TeacherFunction
     */
    public function getTeacherFunction()
    {
        return $this->teacherFunction;
    }
}

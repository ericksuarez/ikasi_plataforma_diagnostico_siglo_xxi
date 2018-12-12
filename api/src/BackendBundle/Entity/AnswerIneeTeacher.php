<?php

namespace BackendBundle\Entity;

/**
 * AnswerIneeTeacher
 */
class AnswerIneeTeacher
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var \BackendBundle\Entity\EvaluationInee
     */
    private $evaluationInee;

    /**
     * @var \BackendBundle\Entity\Teacher
     */
    private $teacher;

    /**
     * @var \BackendBundle\Entity\AnswerInee
     */
    private $answerInee;


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
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return AnswerIneeTeacher
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
     * @return AnswerIneeTeacher
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
     * Set evaluationInee
     *
     * @param \BackendBundle\Entity\EvaluationInee $evaluationInee
     *
     * @return AnswerIneeTeacher
     */
    public function setEvaluationInee(\BackendBundle\Entity\EvaluationInee $evaluationInee = null)
    {
        $this->evaluationInee = $evaluationInee;

        return $this;
    }

    /**
     * Get evaluationInee
     *
     * @return \BackendBundle\Entity\EvaluationInee
     */
    public function getEvaluationInee()
    {
        return $this->evaluationInee;
    }

    /**
     * Set teacher
     *
     * @param \BackendBundle\Entity\Teacher $teacher
     *
     * @return AnswerIneeTeacher
     */
    public function setTeacher(\BackendBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \BackendBundle\Entity\Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set answerInee
     *
     * @param \BackendBundle\Entity\AnswerInee $answerInee
     *
     * @return AnswerIneeTeacher
     */
    public function setAnswerInee(\BackendBundle\Entity\AnswerInee $answerInee = null)
    {
        $this->answerInee = $answerInee;

        return $this;
    }

    /**
     * Get answerInee
     *
     * @return \BackendBundle\Entity\AnswerInee
     */
    public function getAnswerInee()
    {
        return $this->answerInee;
    }
    /**
     * @var \BackendBundle\Entity\Dimension
     */
    private $dimension;


    /**
     * Set dimension
     *
     * @param \BackendBundle\Entity\Dimension $dimension
     *
     * @return AnswerIneeTeacher
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
     * @var integer
     */
    private $total;


    /**
     * Set total
     *
     * @param integer $total
     *
     * @return AnswerIneeTeacher
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }
}

<?php

namespace BackendBundle\Entity;

/**
 * EvaluationTeacher
 */
class EvaluationTeacher
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $score;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createTime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     */
    private $updateTime = '0000-00-00 00:00:00';

    /**
     * @var Teacher
     */
    private $teacher;

    /**
     * @var Evaluation
     */
    private $evaluation;


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
     * Set score
     *
     * @param string $score
     *
     * @return EvaluationTeacher
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EvaluationTeacher
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return EvaluationTeacher
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
     * @return EvaluationTeacher
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
     * Set teacher
     *
     * @param Teacher $teacher
     *
     * @return EvaluationTeacher
     */
    public function setTeacher(Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set evaluation
     *
     * @param Evaluation $evaluation
     *
     * @return EvaluationTeacher
     */
    public function setEvaluation(Evaluation $evaluation = null)
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * Get evaluation
     *
     * @return Evaluation
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }
}

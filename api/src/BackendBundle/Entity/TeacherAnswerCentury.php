<?php

namespace BackendBundle\Entity;

/**
 * TeacherAnswerCentury
 */
class TeacherAnswerCentury
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
     * @var \BackendBundle\Entity\AnswerCategory
     */
    private $answerCategory;

    /**
     * @var \BackendBundle\Entity\Teacher
     */
    private $teacher;

    /**
     * @var \BackendBundle\Entity\QuestionCentury
     */
    private $questionCentury;


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
     * @return TeacherAnswerCentury
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
     * @return TeacherAnswerCentury
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
     * Set answerCategory
     *
     * @param \BackendBundle\Entity\AnswerCategory $answerCategory
     *
     * @return TeacherAnswerCentury
     */
    public function setAnswerCategory(\BackendBundle\Entity\AnswerCategory $answerCategory = null)
    {
        $this->answerCategory = $answerCategory;

        return $this;
    }

    /**
     * Get answerCategory
     *
     * @return \BackendBundle\Entity\AnswerCategory
     */
    public function getAnswerCategory()
    {
        return $this->answerCategory;
    }

    /**
     * Set teacher
     *
     * @param \BackendBundle\Entity\Teacher $teacher
     *
     * @return TeacherAnswerCentury
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
     * Set questionCentury
     *
     * @param \BackendBundle\Entity\QuestionCentury $questionCentury
     *
     * @return TeacherAnswerCentury
     */
    public function setQuestionCentury(\BackendBundle\Entity\QuestionCentury $questionCentury = null)
    {
        $this->questionCentury = $questionCentury;

        return $this;
    }

    /**
     * Get questionCentury
     *
     * @return \BackendBundle\Entity\QuestionCentury
     */
    public function getQuestionCentury()
    {
        return $this->questionCentury;
    }
}

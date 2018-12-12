<?php

namespace BackendBundle\Entity;

/**
 * AnswerTeacher
 */
class AnswerTeacher
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createTime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     */
    private $updateTime = '0000-00-00 00:00:00';

    /**
     * @var EvaluationTeacher
     */
    private $evaluationTeacher;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Answer
     */
    private $answer;


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
     * @return AnswerTeacher
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
     * @return AnswerTeacher
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
     * Set evaluationTeacher
     *
     * @param EvaluationTeacher $evaluationTeacher
     *
     * @return AnswerTeacher
     */
    public function setEvaluationTeacher(EvaluationTeacher $evaluationTeacher = null)
    {
        $this->evaluationTeacher = $evaluationTeacher;

        return $this;
    }

    /**
     * Get evaluationTeacher
     *
     * @return EvaluationTeacher
     */
    public function getEvaluationTeacher()
    {
        return $this->evaluationTeacher;
    }

    /**
     * Set question
     *
     * @param Question $question
     *
     * @return AnswerTeacher
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     *
     * @param Answer $answer
     *
     * @return AnswerTeacher
     */
    public function setAnswer(Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return Answer
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}

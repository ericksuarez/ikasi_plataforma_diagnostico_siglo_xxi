<?php

namespace BackendBundle\Entity;

/**
 * Question
 */
class Question
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $typeQuestion;

    /**
     * @var integer
     */
    private $correctAnswer;

    /**
     * @var \DateTime
     */
    private $createTime = '0000-00-00 00:00:00';

    /**
     * @var \DateTime
     */
    private $updateTime = '0000-00-00 00:00:00';

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
     * Set description
     *
     * @param string $description
     *
     * @return Question
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
     * Set typeQuestion
     *
     * @param integer $typeQuestion
     *
     * @return Question
     */
    public function setTypeQuestion($typeQuestion)
    {
        $this->typeQuestion = $typeQuestion;

        return $this;
    }

    /**
     * Get typeQuestion
     *
     * @return integer
     */
    public function getTypeQuestion()
    {
        return $this->typeQuestion;
    }

    /**
     * Set correctAnswer
     *
     * @param integer $correctAnswer
     *
     * @return Question
     */
    public function setCorrectAnswer($correctAnswer)
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }

    /**
     * Get correctAnswer
     *
     * @return integer
     */
    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Question
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
     * @return Question
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
     * Set evaluation
     *
     * @param Evaluation $evaluation
     *
     * @return Question
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

<?php

namespace BackendBundle\Entity;

/**
 * AnswerInee
 */
class AnswerInee
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return AnswerInee
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return AnswerInee
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
     * @return AnswerInee
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
     * @return AnswerInee
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
}


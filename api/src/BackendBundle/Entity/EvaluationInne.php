<?php

namespace BackendBundle\Entity;

/**
 * EvaluationInne
 */
class EvaluationInne
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
     * @var Evaluation
     */
    private $evaluation;

    /**
     * @var SkillInne
     */
    private $skillInne;


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
     * @return EvaluationInne
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
     * @return EvaluationInne
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
     * @return EvaluationInne
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

    /**
     * Set skillInne
     *
     * @param SkillInne $skillInne
     *
     * @return EvaluationInne
     */
    public function setSkillInne(SkillInne $skillInne = null)
    {
        $this->skillInne = $skillInne;

        return $this;
    }

    /**
     * Get skillInne
     *
     * @return SkillInne
     */
    public function getSkillInne()
    {
        return $this->skillInne;
    }
}

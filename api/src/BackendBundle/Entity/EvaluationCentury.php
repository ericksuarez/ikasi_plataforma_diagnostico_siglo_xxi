<?php

namespace BackendBundle\Entity;

/**
 * EvaluationCentury
 */
class EvaluationCentury
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
     * @var SkillCentury
     */
    private $skillCentury;


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
     * @return EvaluationCentury
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
     * @return EvaluationCentury
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
     * @return EvaluationCentury
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
     * Set skillCentury
     *
     * @param SkillCentury $skillCentury
     *
     * @return EvaluationCentury
     */
    public function setSkillCentury(SkillCentury $skillCentury = null)
    {
        $this->skillCentury = $skillCentury;

        return $this;
    }

    /**
     * Get skillCentury
     *
     * @return SkillCentury
     */
    public function getSkillCentury()
    {
        return $this->skillCentury;
    }
}

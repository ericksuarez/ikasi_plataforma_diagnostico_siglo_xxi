<?php

namespace BackendBundle\Entity;

/**
 * AreaCentury
 */
class AreaCentury
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
     * @var integer
     */
    private $minVulnerable;

    /**
     * @var integer
     */
    private $maxVulnerable;

    /**
     * @var integer
     */
    private $minCompetent;

    /**
     * @var integer
     */
    private $maxCompetent;

    /**
     * @var integer
     */
    private $minOtimum;

    /**
     * @var integer
     */
    private $maxOtimum;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var \BackendBundle\Entity\SkillCentury
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
     * Set name
     *
     * @param string $name
     *
     * @return AreaCentury
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
     * Set minVulnerable
     *
     * @param integer $minVulnerable
     *
     * @return AreaCentury
     */
    public function setMinVulnerable($minVulnerable)
    {
        $this->minVulnerable = $minVulnerable;

        return $this;
    }

    /**
     * Get minVulnerable
     *
     * @return integer
     */
    public function getMinVulnerable()
    {
        return $this->minVulnerable;
    }

    /**
     * Set maxVulnerable
     *
     * @param integer $maxVulnerable
     *
     * @return AreaCentury
     */
    public function setMaxVulnerable($maxVulnerable)
    {
        $this->maxVulnerable = $maxVulnerable;

        return $this;
    }

    /**
     * Get maxVulnerable
     *
     * @return integer
     */
    public function getMaxVulnerable()
    {
        return $this->maxVulnerable;
    }

    /**
     * Set minCompetent
     *
     * @param integer $minCompetent
     *
     * @return AreaCentury
     */
    public function setMinCompetent($minCompetent)
    {
        $this->minCompetent = $minCompetent;

        return $this;
    }

    /**
     * Get minCompetent
     *
     * @return integer
     */
    public function getMinCompetent()
    {
        return $this->minCompetent;
    }

    /**
     * Set maxCompetent
     *
     * @param integer $maxCompetent
     *
     * @return AreaCentury
     */
    public function setMaxCompetent($maxCompetent)
    {
        $this->maxCompetent = $maxCompetent;

        return $this;
    }

    /**
     * Get maxCompetent
     *
     * @return integer
     */
    public function getMaxCompetent()
    {
        return $this->maxCompetent;
    }

    /**
     * Set minOtimum
     *
     * @param integer $minOtimum
     *
     * @return AreaCentury
     */
    public function setMinOtimum($minOtimum)
    {
        $this->minOtimum = $minOtimum;

        return $this;
    }

    /**
     * Get minOtimum
     *
     * @return integer
     */
    public function getMinOtimum()
    {
        return $this->minOtimum;
    }

    /**
     * Set maxOtimum
     *
     * @param integer $maxOtimum
     *
     * @return AreaCentury
     */
    public function setMaxOtimum($maxOtimum)
    {
        $this->maxOtimum = $maxOtimum;

        return $this;
    }

    /**
     * Get maxOtimum
     *
     * @return integer
     */
    public function getMaxOtimum()
    {
        return $this->maxOtimum;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return AreaCentury
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
     * @return AreaCentury
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
     * @return AreaCentury
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
     * Set skillCentury
     *
     * @param \BackendBundle\Entity\SkillCentury $skillCentury
     *
     * @return AreaCentury
     */
    public function setSkillCentury(\BackendBundle\Entity\SkillCentury $skillCentury = null)
    {
        $this->skillCentury = $skillCentury;

        return $this;
    }

    /**
     * Get skillCentury
     *
     * @return \BackendBundle\Entity\SkillCentury
     */
    public function getSkillCentury()
    {
        return $this->skillCentury;
    }
}

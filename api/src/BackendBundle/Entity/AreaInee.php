<?php

namespace BackendBundle\Entity;

/**
 * AreaInee
 */
class AreaInee
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
    private $skillIneeId;

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
     * @return AreaInee
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
     * Set skillIneeId
     *
     * @param integer $skillIneeId
     *
     * @return AreaInee
     */
    public function setSkillIneeId($skillIneeId)
    {
        $this->skillIneeId = $skillIneeId;

        return $this;
    }

    /**
     * Get skillIneeId
     *
     * @return integer
     */
    public function getSkillIneeId()
    {
        return $this->skillIneeId;
    }

    /**
     * Set minVulnerable
     *
     * @param integer $minVulnerable
     *
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
     * @return AreaInee
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
}

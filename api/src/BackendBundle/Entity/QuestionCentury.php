<?php

namespace BackendBundle\Entity;

/**
 * QuestionCentury
 */
class QuestionCentury
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
    private $status = '1';

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var \BackendBundle\Entity\AreaCentury
     */
    

    /**
     * @var \BackendBundle\Entity\Category
     */
    private $category;


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
     * @return QuestionCentury
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
     * Set status
     *
     * @param integer $status
     *
     * @return QuestionCentury
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
     * @return QuestionCentury
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
     * @return QuestionCentury
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
     * Set category
     *
     * @param \BackendBundle\Entity\Category $category
     *
     * @return QuestionCentury
     */
    public function setCategory(\BackendBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \BackendBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * @var \BackendBundle\Entity\AreaCentury
     */
    private $areaCentury;


    /**
     * Set areaCentury
     *
     * @param \BackendBundle\Entity\AreaCentury $areaCentury
     *
     * @return QuestionCentury
     */
    public function setAreaCentury(\BackendBundle\Entity\AreaCentury $areaCentury = null)
    {
        $this->areaCentury = $areaCentury;

        return $this;
    }

    /**
     * Get areaCentury
     *
     * @return \BackendBundle\Entity\AreaCentury
     */
    public function getAreaCentury()
    {
        return $this->areaCentury;
    }
}

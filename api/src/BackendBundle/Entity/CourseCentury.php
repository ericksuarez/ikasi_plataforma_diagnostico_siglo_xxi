<?php

namespace BackendBundle\Entity;

/**
 * CourseCentury
 */
class CourseCentury
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
     * @var SkillCentury
     */
    private $skillCentury;

    /**
     * @var Course
     */
    private $course;


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
     * @return CourseCentury
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
     * @return CourseCentury
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
     * @param SkillCentury $skillCentury
     *
     * @return CourseCentury
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

    /**
     * Set course
     *
     * @param Course $course
     *
     * @return CourseCentury
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }
}

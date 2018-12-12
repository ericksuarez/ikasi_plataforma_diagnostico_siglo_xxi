<?php

namespace BackendBundle\Entity;

/**
 * CourseInne
 */
class CourseInne
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
     * @var Course
     */
    private $course;

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
     * @return CourseInne
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
     * @return CourseInne
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
     * Set course
     *
     * @param Course $course
     *
     * @return CourseInne
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

    /**
     * Set skillInne
     *
     * @param SkillInne $skillInne
     *
     * @return CourseInne
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

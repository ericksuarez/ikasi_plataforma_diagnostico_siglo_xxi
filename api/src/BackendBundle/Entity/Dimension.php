<?php

namespace BackendBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Dimension
 */
class Dimension
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var EducationLevel
     * @Assert\NotBlank()
     */
    private $educationLevel;

    /**
     * @var TeacherFunction
     * @Assert\NotBlank()
     */
    private $teacherFunction;

    /**
     * @var Speciality
     */
    private $speciality;

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
     * @return Dimension
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
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Dimension
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
     * @return Dimension
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
     * Set educationLevel
     *
     * @param EducationLevel $educationLevel
     *
     * @return Dimension
     */
    public function setEducationLevel(EducationLevel $educationLevel = null)
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    /**
     * Get educationLevel
     *
     * @return EducationLevel
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }

    /**
     * Set teacherFunction
     *
     * @param TeacherFunction $teacherFunction
     *
     * @return Dimension
     */
    public function setTeacherFunction(TeacherFunction $teacherFunction = null)
    {
        $this->teacherFunction = $teacherFunction;

        return $this;
    }

    /**
     * Get teacherFunction
     *
     * @return TeacherFunction
     */
    public function getTeacherFunction()
    {
        return $this->teacherFunction;
    }

    /**
     * Set speciality
     *
     * @param Speciality $speciality
     *
     * @return Dimension
     */
    public function setSpeciality(Speciality $speciality = null)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return Speciality
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }
}

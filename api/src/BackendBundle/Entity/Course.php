<?php

namespace BackendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Course
 */
class Course {

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
     * @var string
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $link;

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
     * @var TeacherFunction
     * @Assert\NotBlank()
     */
    private $teacherFunction;

    /**
     * @var Speciality
     * @Assert\NotBlank()
     */
    private $speciality;

    /**
     * @var EducationLevel
     * @Assert\NotBlank()
     */
    private $educationLevel;

    /**
     * @var $image
     */
    private $image;

    /**
     * @var boolean
     */
    private $status = '1';

    /**
     * @var \DateTime
     */
    private $deleteTime = '0000-00-00 00:00:00';
    
    private $state;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Course
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Course
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Course
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Course
     */
    public function setCreateTime($createTime) {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime
     */
    public function getCreateTime() {
        return $this->createTime;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return Course
     */
    public function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime() {
        return $this->updateTime;
    }

    /**
     * Set teacherFunction
     *
     * @param TeacherFunction $teacherFunction
     *
     * @return Course
     */
    public function setTeacherFunction(TeacherFunction $teacherFunction = null) {
        $this->teacherFunction = $teacherFunction;

        return $this;
    }

    /**
     * Get teacherFunction
     *
     * @return TeacherFunction
     */
    public function getTeacherFunction() {
        return $this->teacherFunction;
    }

    /**
     * Set speciality
     *
     * @param Speciality $speciality
     *
     * @return Course
     */
    public function setSpeciality(Speciality $speciality = null) {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return Speciality
     */
    public function getSpeciality() {
        return $this->speciality;
    }

    /**
     * Set educationLevel
     *
     * @param EducationLevel $educationLevel
     *
     * @return Course
     */
    public function setEducationLevel(EducationLevel $educationLevel = null) {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    /**
     * Get educationLevel
     *
     * @return EducationLevel
     */
    public function getEducationLevel() {
        return $this->educationLevel;
    }

    /**
     * @var integer
     */
    private $typeSuggestion;

    /**
     * @var string
     */
    private $areaCenturyIds;

    /**
     * @var \BackendBundle\Entity\SkillCentury
     */
    private $skillCentury;

    /**
     * Set typeSuggestion
     *
     * @param integer $typeSuggestion
     *
     * @return Course
     */
    public function setTypeSuggestion($typeSuggestion) {
        $this->typeSuggestion = $typeSuggestion;

        return $this;
    }

    /**
     * Get typeSuggestion
     *
     * @return integer
     */
    public function getTypeSuggestion() {
        return $this->typeSuggestion;
    }

    /**
     * Set areaCenturyIds
     *
     * @param string $areaCenturyIds
     *
     * @return Course
     */
    public function setAreaCenturyIds($areaCenturyIds) {
        $this->areaCenturyIds = $areaCenturyIds;

        return $this;
    }

    /**
     * Get areaCenturyIds
     *
     * @return string
     */
    public function getAreaCenturyIds() {
        return $this->areaCenturyIds;
    }

    /**
     * Set skillCentury
     *
     * @param \BackendBundle\Entity\SkillCentury $skillCentury
     *
     * @return Course
     */
    public function setSkillCentury(\BackendBundle\Entity\SkillCentury $skillCentury = null) {
        $this->skillCentury = $skillCentury;

        return $this;
    }

    /**
     * Get skillCentury
     *
     * @return \BackendBundle\Entity\SkillCentury
     */
    public function getSkillCentury() {
        return $this->skillCentury;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * @var \BackendBundle\Entity\Dimension
     */
    private $dimension;

    /**
     * Set dimension
     *
     * @param \BackendBundle\Entity\Dimension $dimension
     *
     * @return Course
     */
    public function setDimension(\BackendBundle\Entity\Dimension $dimension = null) {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return \BackendBundle\Entity\Dimension
     */
    public function getDimension() {
        return $this->dimension;
    }

    /**
     * Get getStatus
     *
     * @return boolean
     */
    function getStatus() {
        return $this->status;
    }

    /**
     * Get getDeleteTime
     *
     * @return \DateTime
     */
    function getDeleteTime() {
        return $this->deleteTime;
    }

    /**
     * Get getStatus
     *
     * @param boolean
     */
    function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $deleteTime
     *
     * @return Speciality
     */
    function setDeleteTime($deleteTime) {
        $this->deleteTime = $deleteTime;
    }
    
    function getState() {
        return $this->state;
    }

    function setState($state) {
        $this->state = $state;
    }
}

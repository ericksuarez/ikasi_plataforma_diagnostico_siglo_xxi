<?php

namespace BackendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Teacher
 */
class Teacher {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $curp;

    /**
     * @var string
     */
    private $rfc;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $fullname;

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
     * @var User
     * @Assert\NotBlank()
     */
    private $user;

    /**
     * @var EducationLevel
     * @Assert\NotBlank()
     */
    private $educationLevel;

    /**
     * @var Speciality
     * @Assert\NotBlank()
     */
    private $speciality;

    /**
     * @var TeacherFunction
     * @Assert\NotBlank()
     */
    private $teacherFunction;

    /**
     * @var boolean
     */
    private $status = '1';

    /**
     * @var \DateTime
     */
    private $deleteTime = '0000-00-00 00:00:00';

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set curp
     *
     * @param string $curp
     *
     * @return Teacher
     */
    public function setCurp($curp) {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get curp
     *
     * @return string
     */
    public function getCurp() {
        return $this->curp;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Teacher
     */
    public function setRfc($rfc) {
        $this->rfc = $rfc;

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc() {
        return $this->rfc;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     *
     * @return Teacher
     */
    public function setFullname($fullname) {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname() {
        return $this->fullname;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Teacher
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
     * @return Teacher
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
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return Teacher
     */
    public function setUser(\BackendBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set educationLevel
     *
     * @param EducationLevel $educationLevel
     *
     * @return Teacher
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
     * Set speciality
     *
     * @param Speciality $speciality
     *
     * @return Teacher
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
     * Set teacherFunction
     *
     * @param TeacherFunction $teacherFunction
     *
     * @return Teacher
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
     * @var string
     */
    private $imageXxiFile;

    /**
     * Set imageXxiFile
     *
     * @param string $imageXxiFile
     *
     * @return Teacher
     */
    public function setImageXxiFile($imageXxiFile) {
        $this->imageXxiFile = $imageXxiFile;

        return $this;
    }

    /**
     * Get imageXxiFile
     *
     * @return string
     */
    public function getImageXxiFile() {
        return $this->imageXxiFile;
    }

    /**
     * @var boolean
     */
    private $didFinishXxiQuestionary;

    /**
     * Set didFinishXxiQuestionary
     *
     * @param boolean $didFinishXxiQuestionary
     *
     * @return Teacher
     */
    public function setDidFinishXxiQuestionary($didFinishXxiQuestionary) {
        $this->didFinishXxiQuestionary = $didFinishXxiQuestionary;

        return $this;
    }

    /**
     * Get didFinishXxiQuestionary
     *
     * @return boolean
     */
    public function getDidFinishXxiQuestionary() {
        return $this->didFinishXxiQuestionary;
    }

    /**
     * @var boolean
     */
    private $evaluationIneeFinish = '0';

    /**
     * Set evaluationIneeFinish
     *
     * @param boolean $evaluationIneeFinish
     *
     * @return Teacher
     */
    public function setEvaluationIneeFinish($evaluationIneeFinish) {
        $this->evaluationIneeFinish = $evaluationIneeFinish;

        return $this;
    }

    /**
     * Get evaluationIneeFinish
     *
     * @return boolean
     */
    public function getEvaluationIneeFinish() {
        return $this->evaluationIneeFinish;
    }

    /**
     * @var string
     */
    private $evaluationIneeImage;

    /**
     * Set evaluationIneeImage
     *
     * @param string $evaluationIneeImage
     *
     * @return Teacher
     */
    public function setEvaluationIneeImage($evaluationIneeImage) {
        $this->evaluationIneeImage = $evaluationIneeImage;

        return $this;
    }

    /**
     * Get evaluationIneeImage
     *
     * @return string
     */
    public function getEvaluationIneeImage() {
        return $this->evaluationIneeImage;
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

}

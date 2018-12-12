<?php

namespace BackendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Speciality
 */
class Speciality {

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
     * Set name
     *
     * @param string $name
     *
     * @return Speciality
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
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Speciality
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
     * @return Speciality
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

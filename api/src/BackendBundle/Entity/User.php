<?php

namespace BackendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 */
class User
{
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $passwordHash;

    /**
     * @var string
     */
    private $passwordResetToken;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $authKey;

    /**
     * @var integer
     * @Assert\NotBlank()
     */
    private $status = '1';

    /**
     * @var \DateTime
     */
    private $lastVisitTime;

    /**
     * @var \DateTime
     */
    private $createTime;

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var UserRole
     * @Assert\NotBlank()
     */
    private $userRole;
    
    private $section_name;


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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     *
     * @return User
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set passwordResetToken
     *
     * @param string $passwordResetToken
     *
     * @return User
     */
    public function setPasswordResetToken($passwordResetToken)
    {
        $this->passwordResetToken = $passwordResetToken;

        return $this;
    }

    /**
     * Get passwordResetToken
     *
     * @return string
     */
    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return User
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
     * Set lastVisitTime
     *
     * @param \DateTime $lastVisitTime
     *
     * @return User
     */
    public function setLastVisitTime($lastVisitTime)
    {
        $this->lastVisitTime = $lastVisitTime;

        return $this;
    }

    /**
     * Get lastVisitTime
     *
     * @return \DateTime
     */
    public function getLastVisitTime()
    {
        return $this->lastVisitTime;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return User
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
     * @return User
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
     * Set userRole
     *
     * @param UserRole $userRole
     *
     * @return User
     */
    public function setUserRole(UserRole $userRole = null)
    {
        $this->userRole = $userRole;

        return $this;
    }

    /**
     * Get userRole
     *
     * @return UserRole
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @return string
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * Set authKey
     *
     * @param string $authKey
     *
     * @return User
     */
    public function setAuthKey($authKey)
    {
        $this->authKey = $authKey;
        return $this;
    }
    
    function getSection_name() {
        return $this->section_name;
    }

    function setSection_name($section_name) {
        $this->section_name = $section_name;
    }


}

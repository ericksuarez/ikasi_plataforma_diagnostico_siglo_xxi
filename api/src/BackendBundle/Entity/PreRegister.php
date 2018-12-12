<?php

namespace BackendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * PreRegister
 */
class PreRegister
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
     * @var string
     */
    private $curp;

    /**
     * @var integer
     */
    private $teacherFunction;

    /**
     * @var integer
     */
    private $educationLevel;

    /**
     * @var integer
     */
    private $speciality;

    /**
     * @var string
     */
    private $email;


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
     * @return PreRegister
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
     * Set curp
     *
     * @param string $curp
     *
     * @return PreRegister
     */
    public function setCurp($curp)
    {
        $this->curp = $curp;

        return $this;
    }

    /**
     * Get curp
     *
     * @return string
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set teacherFunction
     *
     * @param integer $teacherFunction
     *
     * @return PreRegister
     */
    public function setTeacherFunction($teacherFunction)
    {
        $this->teacherFunction = $teacherFunction;

        return $this;
    }

    /**
     * Get teacherFunction
     *
     * @return integer
     */
    public function getTeacherFunction()
    {
        return $this->teacherFunction;
    }

    /**
     * Set educationLevel
     *
     * @param integer $educationLevel
     *
     * @return PreRegister
     */
    public function setEducationLevel($educationLevel)
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    /**
     * Get educationLevel
     *
     * @return integer
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }

    /**
     * Set speciality
     *
     * @param integer $speciality
     *
     * @return PreRegister
     */
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get speciality
     *
     * @return integer
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return PreRegister
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
}


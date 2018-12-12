<?php

namespace Proxies\__CG__\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class AnswerIneeTeacher extends \BackendBundle\Entity\AnswerIneeTeacher implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'id', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'createTime', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'updateTime', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'evaluationInee', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'teacher', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'answerInee', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'dimension', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'total'];
        }

        return ['__isInitialized__', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'id', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'createTime', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'updateTime', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'evaluationInee', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'teacher', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'answerInee', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'dimension', '' . "\0" . 'BackendBundle\\Entity\\AnswerIneeTeacher' . "\0" . 'total'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (AnswerIneeTeacher $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreateTime($createTime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreateTime', [$createTime]);

        return parent::setCreateTime($createTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreateTime', []);

        return parent::getCreateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdateTime($updateTime)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdateTime', [$updateTime]);

        return parent::setUpdateTime($updateTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdateTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdateTime', []);

        return parent::getUpdateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setEvaluationInee(\BackendBundle\Entity\EvaluationInee $evaluationInee = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEvaluationInee', [$evaluationInee]);

        return parent::setEvaluationInee($evaluationInee);
    }

    /**
     * {@inheritDoc}
     */
    public function getEvaluationInee()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEvaluationInee', []);

        return parent::getEvaluationInee();
    }

    /**
     * {@inheritDoc}
     */
    public function setTeacher(\BackendBundle\Entity\Teacher $teacher = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTeacher', [$teacher]);

        return parent::setTeacher($teacher);
    }

    /**
     * {@inheritDoc}
     */
    public function getTeacher()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTeacher', []);

        return parent::getTeacher();
    }

    /**
     * {@inheritDoc}
     */
    public function setAnswerInee(\BackendBundle\Entity\AnswerInee $answerInee = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAnswerInee', [$answerInee]);

        return parent::setAnswerInee($answerInee);
    }

    /**
     * {@inheritDoc}
     */
    public function getAnswerInee()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAnswerInee', []);

        return parent::getAnswerInee();
    }

    /**
     * {@inheritDoc}
     */
    public function setDimension(\BackendBundle\Entity\Dimension $dimension = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDimension', [$dimension]);

        return parent::setDimension($dimension);
    }

    /**
     * {@inheritDoc}
     */
    public function getDimension()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDimension', []);

        return parent::getDimension();
    }

    /**
     * {@inheritDoc}
     */
    public function setTotal($total)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTotal', [$total]);

        return parent::setTotal($total);
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotal', []);

        return parent::getTotal();
    }

}

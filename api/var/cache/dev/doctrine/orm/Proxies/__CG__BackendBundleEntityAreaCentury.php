<?php

namespace Proxies\__CG__\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class AreaCentury extends \BackendBundle\Entity\AreaCentury implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'id', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'name', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'minVulnerable', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'maxVulnerable', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'minCompetent', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'maxCompetent', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'minOtimum', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'maxOtimum', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'status', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'createTime', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'updateTime', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'skillCentury'];
        }

        return ['__isInitialized__', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'id', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'name', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'minVulnerable', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'maxVulnerable', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'minCompetent', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'maxCompetent', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'minOtimum', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'maxOtimum', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'status', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'createTime', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'updateTime', '' . "\0" . 'BackendBundle\\Entity\\AreaCentury' . "\0" . 'skillCentury'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (AreaCentury $proxy) {
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
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', [$name]);

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setMinVulnerable($minVulnerable)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinVulnerable', [$minVulnerable]);

        return parent::setMinVulnerable($minVulnerable);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinVulnerable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinVulnerable', []);

        return parent::getMinVulnerable();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxVulnerable($maxVulnerable)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaxVulnerable', [$maxVulnerable]);

        return parent::setMaxVulnerable($maxVulnerable);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxVulnerable()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaxVulnerable', []);

        return parent::getMaxVulnerable();
    }

    /**
     * {@inheritDoc}
     */
    public function setMinCompetent($minCompetent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinCompetent', [$minCompetent]);

        return parent::setMinCompetent($minCompetent);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinCompetent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinCompetent', []);

        return parent::getMinCompetent();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxCompetent($maxCompetent)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaxCompetent', [$maxCompetent]);

        return parent::setMaxCompetent($maxCompetent);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxCompetent()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaxCompetent', []);

        return parent::getMaxCompetent();
    }

    /**
     * {@inheritDoc}
     */
    public function setMinOtimum($minOtimum)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMinOtimum', [$minOtimum]);

        return parent::setMinOtimum($minOtimum);
    }

    /**
     * {@inheritDoc}
     */
    public function getMinOtimum()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMinOtimum', []);

        return parent::getMinOtimum();
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxOtimum($maxOtimum)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMaxOtimum', [$maxOtimum]);

        return parent::setMaxOtimum($maxOtimum);
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxOtimum()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMaxOtimum', []);

        return parent::getMaxOtimum();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
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
    public function setSkillCentury(\BackendBundle\Entity\SkillCentury $skillCentury = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSkillCentury', [$skillCentury]);

        return parent::setSkillCentury($skillCentury);
    }

    /**
     * {@inheritDoc}
     */
    public function getSkillCentury()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSkillCentury', []);

        return parent::getSkillCentury();
    }

}
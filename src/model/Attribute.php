<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2017/12/15
 * Time: 15:32
 */

namespace jsongenerator\src\model;


class Attribute
{
    /**
     * @var string
     */
    protected $attributeName;

    /**
     * @var string
     */
    protected $attributeType;

    protected $attributeOriginal;


    public function __construct($name, $type)
    {
        $this->attributeName = $name;
        $this->attributeType = $type;
    }

    /**
     * @return string
     */
    public function getAttributeName()
    {
        return $this->attributeName;
    }

    /**
     * @param string $attributeName
     */
    public function setAttributeName($attributeName)
    {
        $this->attributeName = $attributeName;
    }

    /**
     * @return string
     */
    public function getAttributeType()
    {
        return $this->attributeType;
    }

    /**
     * @param string $attributeType
     */
    public function setAttributeType($attributeType)
    {
        $this->attributeType = $attributeType;
    }

    /**
     * @return mixed
     */
    public function getAttributeOriginal()
    {
        return $this->attributeOriginal;
    }

    /**
     * @param mixed $attributeOriginal
     */
    public function setAttributeOriginal($attributeOriginal)
    {
        $this->attributeOriginal = $attributeOriginal;
    }


}
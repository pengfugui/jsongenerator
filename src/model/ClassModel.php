<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2017/12/15
 * Time: 15:36
 */

namespace jsongenerator\src\model;


use jsongenerator\src\tool\NameTool;

class ClassModel
{
    /**
     * @var Attribute[]
     */
    protected $attributes;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $namespace;

    public function __construct($className, $namespace)
    {
        $this->className = $className;
        $this->namespace = $namespace;
        $this->attributes = [];
    }

    public function getClassCode()
    {
        ob_start();
        require (dirname(__FILE__) . '/../template/ClassTemplate.php');
        $code = ob_get_contents();
        ob_clean();
        return $code;
    }

    /**
     * @param $attributeName
     * @param $type
     * @return bool
     */
    public function addAttribute($attributeName, $type)
    {
        $attribute = new Attribute(NameTool::toClassPropertyName($attributeName), $type);
        $this->attributes[] = $attribute;
        return true;
    }

    public function genAttributeCode(Attribute $attribute)
    {
        $attributeCode = <<<CODE
        
    /**
     * @var {$attribute->getAttributeType()}
     */
    protected \${$attribute->getAttributeName()};
    
CODE;
        return $attributeCode;
    }

    public function genMethodCode(Attribute $attribute)
    {
        $attributeName = $attribute->getAttributeName();
        $getter = NameTool::toClassGetterMethod($attributeName);
        $setter = NameTool::toClassSetterMethod($attributeName);

        $code = <<<CODE

    /**
     * @return {$attribute->getAttributeType()}
     */
    public function {$getter}()
    {
        return \$this->{$attributeName};
    }
    
    /**
     * @param {$attribute->getAttributeType()}
     */
    public function {$setter}(\${$attributeName})
    {
        \$this->{$attributeName} = \${$attributeName};
    }

CODE;

        return $code;
    }

    /**
     * @return Attribute[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }


}
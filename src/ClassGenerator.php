<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2017/12/15
 * Time: 15:25
 */

namespace jsongenerator\src;


use jsongenerator\src\model\ClassModel;
use jsongenerator\src\tool\NameTool;

class ClassGenerator
{
    /**
     * @var ClassModel[]
     */
    protected $classModels;

    public function __construct()
    {
        $this->classModels = [];
    }

    public function parseByJson($json, $className, $namespace)
    {
        $stdClass = json_decode($json);
        if (JSON_ERROR_NONE !== json_last_error()) {
            return false;
        }
        return $this->parseByStdClass($stdClass, $className, $namespace);
    }

    /**
     * 解析stdClass成ClassModel对象并缓存到数组中
     * 只处理数组，对象和简单类型3种情况
     *
     * @param \StdClass $class
     * @param $className
     * @param $namespace
     * @return bool
     */
    public function parseByStdClass(\StdClass $class, $className, $namespace)
    {
        $classModel = $this->initClass($className, $namespace);

        $vars = get_object_vars($class);
        foreach ($vars as $attributeName => $item) {
            if (is_array($item)) {
                $this->parseArray($classModel, $attributeName, $item);
            } elseif (is_object($item)) {
                $this->parseObject($classModel, $attributeName, $item);
            } else {
                $this->parseDefault($classModel, $attributeName, $item);
            }
        }
        $this->classModels[] = $classModel;
        return true;
    }

    private function parseDefault(ClassModel $classModel, $attributeName, $value) {
        if (self::isSimpleType(gettype($value))) {
            $classModel->addAttribute($attributeName, gettype($value));
        }
        return true;
    }

    private function parseArray(ClassModel $classModel, $attributeName, $value) {
        if (count($value) >0) {
            $value = $value[0];
            if (is_object($value)) {
                // 转换成单数形式的类名
                $className = NameTool::toCamelCase(NameTool::singular($attributeName));
                $type = $className . '[]';
                $classModel->addAttribute($attributeName, $type);
                call_user_func_array([$this, 'parseByStdClass'], [$value, $className, $classModel->getNamespace()]);

            } else {
                $classModel->addAttribute($attributeName, gettype($value) . '[]');
            }
        }
        return true;
    }

    private function parseObject(ClassModel $classModel, $attributeName, $value) {
        $type = NameTool::toCamelCase($attributeName);
        $classModel->addAttribute($attributeName, $type);
        call_user_func_array([$this, 'parseByStdClass'], [$value, $type, $classModel->getNamespace()]);
        return true;
    }

    /**
     * @param $cName
     * @param $cNamespace
     * @return ClassModel
     */
    private function initClass($cName, $cNamespace)
    {
        $class = new ClassModel($cName, $cNamespace);
        return $class;
    }

    public static function isSimpleType($type)
    {
        return in_array($type, [
            'string',
            'integer',
            'int',
            'float',
            'double',
            'bool',
            'boolean'
        ]);
    }

    /**
     * @return ClassModel[]
     */
    public function getClassModels()
    {
        return $this->classModels;
    }

    /**
     * @param ClassModel[] $classModels
     */
    public function setClassModels($classModels)
    {
        $this->classModels = $classModels;
    }


}
# JsonGeneratePhpClass
一个使用json生成php class代码的工具



## composer安装

`composer require pengfugui/jsongenerator`



## 使用方式

```php
$generator = new ClassGenerator();

$json = <<<JSON
{"attribute" : "属性", "int_var":1,"bool_var":true,"ad_models" : [{"test":"a"}]}
JSON;

$ret = $generator->parseByJson($json, $className, $namespace);

foreach ($generator->getClassModels() as $model) {
    $list[] = [
        'class_name' => $model->getClassName(),
        'namespace' => $model->getNamespace(),
        'code' => code2HtmlEntity($model->getClassCode())
    ];
}

```



## 案例

http://119.29.20.190/jsongenerator.html
<?php use jsongenerator\src\model\ClassModel;

echo "<?php"; ?>


/**
 * Created by PhpStorm.
 * User: peter
 * Date: 2017/12/15
 * Time: 17:46
 */
<?php
    /* @var $this ClassModel*/
?>

namespace <?php echo $this->getNamespace()?>;


class <?php echo $this->getClassName()?>
{
<?php
    foreach ($this->getAttributes() as $attribute) {
        echo $this->genAttributeCode($attribute);
    }
?>

<?php
foreach ($this->getAttributes() as $attribute) {
    echo $this->genMethodCode($attribute);
}
?>

}
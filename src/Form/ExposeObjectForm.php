<?php
namespace Mia3\Expose\Form;

use Mia3\Expose\Core\Expose;
use Mia3\Expose\Reflection\ClassSchema;
use Mia3\Expose\Reflection\ClassSchemaFactory;

class ExposeObjectForm extends ExposeForm {

    /**
     * @var string
     */
    protected $className;

    /**
     * @var object
     */
    protected $object;

    /**
     * @var ClassSchema
     */
    protected $classSchema;

    public function setClassName($className) {
        $this->className = $className;
        $this->object = new $className();
        $this->classSchema = Expose::classSchemaFactory()->createClassSchema($className);

        foreach ($this->classSchema->getProperties() as $property) {
            $formField = $this->createField($property->getName());
            $formField->setControl($property->getControl());
        }
    }

    /**
     * @return object
     */
    public function getObject()
    {
        foreach ($this->fields as $field) {
            var_dump($field->getName(), $field->getValue());
        }
        return $this->object;
    }

    /**
     * @param object $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return ClassSchema
     */
    public function getClassSchema()
    {
        return $this->classSchema;
    }

    /**
     * @param ClassSchema $classSchema
     */
    public function setClassSchema($classSchema)
    {
        $this->classSchema = $classSchema;
    }

}
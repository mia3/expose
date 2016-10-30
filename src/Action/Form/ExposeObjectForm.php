<?php
namespace Mia3\Expose\Action\Form;

use Mia3\Expose\Core\Expose;
use Mia3\Expose\Reflection\ClassSchema;
use Mia3\Expose\Reflection\ClassSchemaFactory;
use Mia3\Expose\Validator\SymfonyValidator;
use Symfony\Component\PropertyAccess\PropertyAccess;

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
        if ($this->object === NULL) {
            $this->object = new $className();
        }
        $this->classSchema = Expose::classSchemaFactory()->createClassSchema($className);

        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->classSchema->getProperties() as $property) {
            if (!$accessor->isReadable($this->object, $property->getName())) {
                // todo, what happened here?
                // handle not settable properties
                continue;
            }
            if ($property->isHidden()) {
                $formField = $this->createHiddenField($property->getName());
                $formField->setDefault($accessor->getValue($this->object, $property->getName()));
            } else {
                $formField = $this->createField($property->getName());
                $formField->setControl($property->getControl());
                $formField->setDefault($accessor->getValue($this->object, $property->getName()));
                $formField->setRequired($property->getRequired());
                $formField->setValidator(new SymfonyValidator($property->getAnnotations()));
            }
        }
    }

    /**
     * @return object
     */
    public function getObject()
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->fields as $field) {
            if (!$accessor->isWritable($this->object, $field->getName())) {
                // todo, what happened here?
                // handle not settable properties
                continue;
            }
            $accessor->setValue($this->object, $field->getName(), $field->getValue());
        }
        return $this->object;
    }

    /**
     * @param object $object
     */
    public function setObject($object)
    {
        $this->object = $object;
        $this->setClassName(get_class($object));
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
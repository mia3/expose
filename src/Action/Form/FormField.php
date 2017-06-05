<?php
namespace Mia3\Expose\Action\Form;

use Mia3\Expose\Utility\StringFormatter;
use Mia3\Expose\Validator\FormFieldValidatorInterface;

class FormField
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $control;

    /**
     * @var string
     */
    protected $wrap = 'Default';

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var mixed
     */
    protected $default;

    /**
     * @var boolean
     */
    protected $required;

    /**
     * @var FormFieldValidatorInterface
     */
    protected $validator;

    public function __construct($name, $options = null)
    {
        $this->name = $name;
        $this->id = 'form-field-' . StringFormatter::pathToFormId($name);
        $this->label = StringFormatter::camelCaseToSentence($name);

        // todo: use/set options
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return string
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * @param string $control
     */
    public function setControl($control)
    {
        $this->control = $control;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getValueOrDefault()
    {
        if ($this->value == null) {
            return $this->getDefault();
        }

        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getWrap()
    {
        return $this->wrap;
    }

    /**
     * @param string $wrap
     */
    public function setWrap($wrap)
    {
        $this->wrap = $wrap;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return FormFieldValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param FormFieldValidatorInterface $validator
     */
    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function validate()
    {
        $this->validator->validate($this->getValue());
    }

}

<?php
namespace Mia3\Expose\Action\Form;

use Mia3\Expose\Reflection\ClassSchemaFactory;
use Mia3\Expose\Request\RequestInterface;

class ExposeForm
{

    /**
     * The fields of this form.
     *
     * @var array An array of FormFields
     */
    protected $fields = array();

    /**
     * The hidden fields of this form.
     *
     * @var array An array of FormFields
     */
    protected $hiddenFields = array();

    /**
     * The errors of this form.
     *
     * @var array An array of FormError instances
     */
    protected $errors = array();

    /**
     * @var RequestInterface
     */
    protected $formRequest;

    public function __construct($formRequest)
    {
        $this->formRequest = $formRequest;
    }

    public function createField($name)
    {
        $formField = new FormField($name);
        $this->fields[$name] = $formField;

        if ($this->isSubmitted()) {
            $formField->setValue($this->formRequest->getFormData($formField->getName()));
        }

        return $formField;
    }

    public function createHiddenField($name)
    {
        $formField = new FormField($name);
        $this->hiddenFields[$name] = $formField;

        if ($this->isSubmitted()) {
            $formField->setValue($this->formRequest->getFormData($formField->getName()));
        }

        return $formField;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public function getHiddenFields()
    {
        return $this->hiddenFields;
    }

    /**
     * @param array $hiddenFields
     */
    public function setHiddenFields($hiddenFields)
    {
        $this->hiddenFields = $hiddenFields;
    }

    public function isSubmitted()
    {
        return $this->formRequest->isSubmitted();
    }

    public function isValid()
    {
        if (!$this->isSubmitted()) {
            return false;
        }

        return 0 === count($this->getErrors(true));
    }

    public function getErrors($deep = false, $flatten = true)
    {
        foreach ($this->fields as $field) {
            $field->validate();
        }

        return $this->errors;
    }

    /**
     * @return FormRequestInterface
     */
    public function getFormRequest()
    {
        return $this->formRequest;
    }

    /**
     * @param FormRequestInterface $formRequest
     */
    public function setFormRequest($formRequest)
    {
        $this->formRequest = $formRequest;
    }
}
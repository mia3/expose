<?php
namespace Mia3\Expose\Validator;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class SymfonyValidator implements FormFieldValidatorInterface  {

    /**
     * @var array
     */
    protected $validators = array();

    /**
     * @var RecursiveValidator
     */
    protected $validator;

    public function __construct(RecursiveValidator $validator, $property)
    {
//        $this->validators = $validators;
    }

    public function validate($value)
    {
//        $validator = new Validator
        var_dump($value);
        // TODO: Implement validate() method.
    }

}
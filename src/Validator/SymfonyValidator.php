<?php
namespace Mia3\Expose\Validator;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class SymfonyValidator implements FormFieldValidatorInterface  {
    use ContainerAwareTrait;

    /**
     * @var array
     */
    protected $validators = array();

    public function __construct($validators)
    {
        $this->validators = $validators;
    }

    public function validate($value)
    {
//        $validator = new Validator
        var_dump($value);
        // TODO: Implement validate() method.
    }

}
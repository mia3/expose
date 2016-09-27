<?php
namespace Mia3\Expose\Form;

interface FormRequestInterface {

    public function isSubmitted();

    public function getFormData($name);

}
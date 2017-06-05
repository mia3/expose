<?php
namespace Mia3\Expose\Request;

interface RequestInterface
{

    public function isSubmitted();

    public function getFormData($name);

}
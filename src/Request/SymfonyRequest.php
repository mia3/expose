<?php
namespace Mia3\Expose\Request;

use Symfony\Component\HttpFoundation\Request;

class SymfonyRequest implements RequestInterface
{

    /**
     * @var Request
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function isSubmitted()
    {
        return $this->request->getMethod() === 'POST';
    }

    public function getFormData($name)
    {
        return $this->request->get($name);
    }
}
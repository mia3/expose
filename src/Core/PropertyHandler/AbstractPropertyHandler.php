<?php
namespace Mia3\Expose\Core\PropertyHandler;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 */
abstract class AbstractPropertyHandler implements PropertyHandlerInterface
{
    /**
     * @var object
     */
    protected $originalObject;

    /**
     * @var string
     */
    protected $propertyName;

    /**
     * @var PropertyMapper
     */
    protected $propertyMapper;

    public function __construct($originalObject, $propertyName)
    {
        $this->originalObject = $originalObject;
        $this->propertyName = $propertyName;
    }

    public function addError($error)
    {
        $this->propertyMapper->getMessages()->forProperty($this->propertyName)->addError($error);
    }
}
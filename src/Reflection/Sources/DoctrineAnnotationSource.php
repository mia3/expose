<?php
namespace Mia3\Expose\Reflection\Sources;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Mia3\Expose\Core\Sources\AbstractSchemaSource;
use TYPO3\Flow\Annotations as Flow;

/**
 */
class DoctrineAnnotationSource extends AbstractSchemaSource
{

    public function compileSchema()
    {
        $schema = array('properties' => array());
        $propertyNames = $this->reflectionService->getPropertyNames($this->className);
        foreach ($propertyNames as $key => $propertyName) {
            $propertySchema = array();
            $annotationClassNames = $this->reflectionService->getPropertyAnnotationClassNames($this->className,
                $propertyName);
            if (in_array('Doctrine\ORM\Mapping\Id', $annotationClassNames)) {
                $propertySchema['hidden'] = true;
            }
            if (in_array('Symfony\Component\Validator\Constraints\NotBlank', $annotationClassNames)) {
                $propertySchema['required'] = true;
            }
            $schema['properties'][$propertyName] = $propertySchema;
        }

        return $schema;
    }


}
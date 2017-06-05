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
use Mia3\Expose\Utility\Inflector;

/**
 */
class DefaultSource extends AbstractSchemaSource
{

    public function compileSchema()
    {
        $schema = array(
            'listProperties' => array('__toString'),
            'listBehaviors' => array(
                '\Mia3\Expose\QueryBehaviors\SearchBehavior' => true,
                '\Flowpack\Expose\QueryBehaviors\FilterBehavior' => true,
                '\Flowpack\Expose\QueryBehaviors\PaginationBehavior' => true,
                '\Flowpack\Expose\QueryBehaviors\SortBehavior' => true,
            ),
            'defaultSortBy' => null,
            'defaultOrder' => null,
            'filterProperties' => array(),
            'searchProperties' => array(),
        );
        foreach ($this->reflectionService->getPropertyNames($this->className) as $key => $propertyName) {
            if ($this->propertyShouldBeIgnored($propertyName) === true) {
                continue;
            }
            $schema['properties'][$propertyName] = array(
                'name' => $propertyName,
                'label' => $this->inflector->humanizeCamelCase($propertyName, false),
                'parentClassName' => $this->className,
                'position' => ($key + 1) * 100,
                'infotext' => '',
                'hidden' => false,
                'required' => false,
                'optionsProvider' => array(
                    'Name' => 'Relation',
                ),
            );
        }

        return $schema;
    }

}
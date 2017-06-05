<?php
namespace Mia3\Expose\Reflection;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Render a Form section using the Form framework
 */
class ClassSchemaFactory
{

    protected $sourceClassNames = array();

    /**
     *
     */
    public function __construct()
    {

    }

    public function addSource($sourceClassName)
    {
        $this->sourceClassNames[] = $sourceClassName;
    }

    public function createClassSchema($className)
    {
        if (is_object($className)) {
            $className = get_class($className);
        }
        $schema = array(
            'properties' => array(),
        );

        foreach ($this->sourceClassNames as $sourceClassNames) {
            $source = new $sourceClassNames($className);
            $schema = array_replace_recursive($schema, $source->compileSchema());
        }

        $schema = new ClassSchema($className, $schema, $this);

//        todo
//        $arraySorter = new PositionalArraySorter($schema['properties'], 'position');
//        try {
//            $schema['properties'] = $arraySorter->toArray();
//        } catch (InvalidPositionException $exception) {
//            throw new TypoScript\Exception('Invalid position string', 1345126502, $exception);
//        }

        return $schema;
    }
}
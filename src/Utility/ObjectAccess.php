<?php
namespace Mia3\Expose\Utility;

/*
 * This file is part of the Neos.Utility.ObjectHandling package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

/**
 * Provides methods to call appropriate getter/setter on an object given the
 * property name. It does this following these rules:
 * - if the target object is an instance of ArrayAccess, it gets/sets the property
 * - if public getter/setter method exists, call it.
 * - if public property exists, return/set the value of it.
 * - else, throw exception
 *
 * Some methods support arrays as well, most notably getProperty() and
 * getPropertyPath().
 *
 */
class Accessor
{
    public static function get($subject, $propertyName)
    {


//        if (!is_object($subject) && !is_array($subject)) {
//            throw new \Exception('$subject must be an object or array, ' . gettype($subject) . ' given.', 1237301367);
//        }
//        if (!is_string($propertyName) && !is_integer($propertyName)) {
//            throw new \Exception('Given property name/index is not of type string or integer.', 1231178303);
//        }
//
//        $propertyExists = false;
//        $propertyValue = self::getPropertyInternal($subject, $propertyName, $forceDirectAccess, $propertyExists);
//        if ($propertyExists === true) {
//            return $propertyValue;
//        }
//        throw new \Exception('The property "' . $propertyName . '" on the subject was not accessible.', 1263391473);
    }

    public static function set(&$subject, $propertyName, $propertyValue)
    {
        if (is_array($subject)) {
            $subject[$propertyName] = $propertyValue;

            return true;
        }

        if (!is_object($subject)) {
            throw new \Exception('subject must be an object or array, ' . gettype($subject) . ' given.', 1237301368);
        }
        if (!is_string($propertyName) && !is_integer($propertyName)) {
            throw new \Exception('Given property name/index is not of type string or integer.', 1231178878);
        }

        if ($forceDirectAccess === true) {
            $className = TypeHandling::getTypeForValue($subject);
            if (property_exists($className, $propertyName)) {
                $propertyReflection = new PropertyReflection($className, $propertyName);
                $propertyReflection->setValue($subject, $propertyValue);
            } else {
                $subject->$propertyName = $propertyValue;
            }
        } elseif (is_callable([$subject, $setterMethodName = self::buildSetterMethodName($propertyName)])) {
            $subject->$setterMethodName($propertyValue);
        } elseif ($subject instanceof \ArrayAccess) {
            $subject[$propertyName] = $propertyValue;
        } elseif (array_key_exists($propertyName, get_object_vars($subject))) {
            $subject->$propertyName = $propertyValue;
        } else {
            return false;
        }

        return true;
    }

    public static function isSettable($subject, $propertyName)
    {
    }

    public static function isGettable($subject, $propertyName)
    {
    }
}
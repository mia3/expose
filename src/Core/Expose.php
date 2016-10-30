<?php
namespace Mia3\Expose\Core;

/*                                                                        *
 * this script belongs to the typo3 flow package "mia3.expose".           *
 *                                                                        *
 * it is free software; you can redistribute it and/or modify it under    *
 * the terms of the gnu lesser general public license, either version 3   *
 * of the license, or (at your option) any later version.                 *
 *                                                                        *
 * the typo3 project - inspiring people to share!                         *
 *                                                                        */
use Mia3\Expose\Form\ExposeForm;
use Mia3\Expose\Form\FormRequestInterface;
use Mia3\Expose\Reflection\ClassSchemaFactory;
use Mia3\Expose\Reflection\Sources\AnnotationSource;
use Mia3\Expose\Reflection\Sources\DefaultSource;
use Mia3\Expose\Reflection\Sources\DoctrineAnnotationSource;
use Mia3\Expose\Reflection\Sources\PhpSource;

/**
 */
class Expose {

    /**
     * @var ClassSchemaFactory
     */
    static protected $classSchemaFactory;

    public static function classSchemaFactory() {
        if (!self::$classSchemaFactory instanceof ClassSchemaFactory) {
            self::$classSchemaFactory = new ClassSchemaFactory();
            self::$classSchemaFactory->addSource(DefaultSource::class);
            self::$classSchemaFactory->addSource(PhpSource::class);
            self::$classSchemaFactory->addSource(AnnotationSource::class);
            self::$classSchemaFactory->addSource(DoctrineAnnotationSource::class);
        }
        return self::$classSchemaFactory;
    }

    public static function createForm($className, $formRequest = null) {
        $form = new ExposeForm();
        $form->setFormRequest($formRequest);
        return $form;
    }

}
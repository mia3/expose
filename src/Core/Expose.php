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
use League\Container\Container;
use Mia3\Expose\Action\Form\ExposeObjectForm;
use Mia3\Expose\Action\Index\DoctrineEntityIndex;
use Mia3\Expose\Form\ExposeForm;
use Mia3\Expose\Form\FormRequestInterface;
use Mia3\Expose\Reflection\ClassSchemaFactory;
use Mia3\Expose\Reflection\Sources\AnnotationSource;
use Mia3\Expose\Reflection\Sources\DefaultSource;
use Mia3\Expose\Reflection\Sources\DoctrineAnnotationSource;
use Mia3\Expose\Reflection\Sources\PhpSource;
use Mia3\Expose\Request\SymfonyRequest;
use Mia3\Expose\Validator\SymfonyValidator;
use Symfony\Component\Validator\Validator\RecursiveValidator;

/**
 */
class Expose {

    /**
     * @var Container
     */
    static protected $container;

    /**
     * @var ClassSchemaFactory
     */
    static protected $classSchemaFactory;

    public static function classSchemaFactory() {
        if (!self::$classSchemaFactory instanceof ClassSchemaFactory) {
            self::$classSchemaFactory = self::container()->get('ClassSchemaFactory');
        }
        return self::$classSchemaFactory;
    }

    public static function createForm($request) {
        return self::container()->get('Index', array($request));
    }

    public static function createIndex($request) {
        return self::container()->get('Index', array($request));
    }

    public static function createPropertyValidator($property) {
        return self::container()->get('PropertyValidator', array($property));
    }

    /**
     * @return Container
     */
    public static function container() {
        if (!self::$container instanceof Container) {
            $container = new Container();
            $container->delegate(
                new \League\Container\ReflectionContainer()
            );

            $container->add('ClassSchemaFactory', function() {
                $classSchemaFactory = new \Mia3\Expose\Reflection\ClassSchemaFactory();
                $classSchemaFactory->addSource(\Mia3\Expose\Reflection\Sources\DefaultSource::class);
                $classSchemaFactory->addSource(\Mia3\Expose\Reflection\Sources\PhpSource::class);
                $classSchemaFactory->addSource(\Mia3\Expose\Reflection\Sources\AnnotationSource::class);
                $classSchemaFactory->addSource(\Mia3\Expose\Reflection\Sources\DoctrineAnnotationSource::class);
                return $classSchemaFactory;
            });

            $container->add('RequestWrapper', function($request) {
                return new SymfonyRequest($request);
            });

            $container->add('Index', function($request) use($container) {
                $requestWrapper = $container->get('RequestWrapper', array($request));
                return new DoctrineEntityIndex($requestWrapper);
            });

            $container->add('Form', function($request) use($container) {
                $requestWrapper = $container->get('RequestWrapper', array($request));
                return new ExposeObjectForm($requestWrapper);
            });

            $container->add('PropertyValidator', function($property) use($container) {
                var_dump($container->get('Validator'));
//                $requestWrapper = $container->get('RequestWrapper', array($request));
                $validator = new SymfonyValidator($property);
//                $requestWrapper = $container->get('RequestWrapper', array($request));
//                return new ExposeObjectForm($requestWrapper);
            });

            self::$container = $container;
        }
        return self::$container;
    }
}
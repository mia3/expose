<?php
namespace Mia3\Expose\Core\Sources;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
use Mia3\Expose\Reflection\ReflectionService;
use Mia3\Expose\Utility\Inflector;

/**
 */
abstract class AbstractSchemaSource implements SchemaSourceInterface {
	/**
	 * @var string
	 */
	protected $className;

	/**
	 * @var ReflectionService
	 */
	protected $reflectionService;

	/**
	 * @var Inflector
	 */
	protected $inflector;

	public function __construct($className) {
		$this->className = $className;
		$this->reflectionService = new ReflectionService();
		$this->inflector = new Inflector();
	}

	public function propertyShouldBeIgnored($propertyName) {
		// if ($this->reflectionService->isPropertyAnnotatedWith($this->className, $propertyName, 'TYPO3\Flow\Annotations\Transient')) {
		// 	return TRUE;
		// }

		// if ($this->reflectionService->isPropertyAnnotatedWith($this->className, $propertyName, 'TYPO3\Flow\Annotations\Inject')) {
		// 	return TRUE;
		// }

		return FALSE;
	}
}

?>
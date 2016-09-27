<?php
namespace Mia3\Expose\ViewHelpers\Form;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use Mia3\Expose\Utility\StringFormatter;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

/**
 * You can use this viewhelper to check if a property has validation errors.
 *
 * Examples
 * =======
 *
 * .. code-block:: html
 *
 *   <div class="form-group {e:form.propertyHasResults(property: someProperty, then: 'has-error')}">
 *     ...
 *   </div>
 *
 * .. code-block:: html
 *
 *   <e:form.propertyHasResults property="someProperty">
 *     This property has some errors!
 *   </e:form.propertyHasResults>
 */
class PropertyHasResultsViewHelper extends AbstractConditionViewHelper {
	/**
	 *
	 * @param string $property Name of the property to check for Validation errors
	 * @return string Rendered string
	 * @api
	 */
	public function render($property) {
		return $this->renderElseChild();
		
		$request = $this->controllerContext->getRequest();
		$validationResults = $request->getInternalArgument('__submittedArgumentValidationResults');

		if ($validationResults === NULL || $property === '') {
			return;
		}

		$propertyPath = StringFormatter::formNameToPath($property);
		$validationResults = $validationResults->forProperty($propertyPath);

		$errors = $validationResults->getErrors();
		if (!empty($errors)) {
			return $this->renderThenChild();
		} else {
			return $this->renderElseChild();
		}
	}
}

?>
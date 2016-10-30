<?php
namespace Mia3\Expose\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flowpack.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 */
class BehaviorViewHelper extends AbstractViewHelper {

	
	/**
	 * NOTE: This property has been introduced via code migration to ensure backwards-compatibility.
	 * @see AbstractViewHelper::isOutputEscapingEnabled()
	 * @var boolean
	 */
	protected $escapeOutput = FALSE;

    /**
     * Constructor
     */
    public function initializeArguments() {
        $this->registerArgument('items', 'mixed', 'iteratable or array of objects');
        $this->registerArgument('behaviors', 'array', 'array of behaviors to apply', FALSE, array());
    }

    /**
	 *
	 * @return string Rendered string
	 */
	public function render() {
	    $items = $this->arguments['items'];

        // todo replace logic!
//		$query = $this->getQuery($items);
//
//		foreach ($this->arguments['behaviors'] as $behaviorClassName => $active) {
//			if ($active !== TRUE) {
//				continue;
//			}
//			$behavior = new $behaviorClassName();
//			$behavior->setRequest($this->controllerContext->getRequest());
//			$behavior->setTemplateVariableContainer($this->templateVariableContainer);
//			$behavior->setViewHelperVariableContainer($this->viewHelperVariableContainer);
//			$behavior->run($query);
//		}

//		$as = array_search($objects, $this->templateVariableContainer->getAll());

//		$this->templateVariableContainer->remove($as);
//		$this->templateVariableContainer->add($as, $query->execute());
		$content = $this->renderChildren();
//		$this->templateVariableContainer->remove($as);
//		$this->templateVariableContainer->add($as, $objects);

		return $content;
	}

	public function getQuery($objects) {
		if ($objects instanceof PersistentCollection) {
			$query = $this->persistenceManager->createQueryForType($objects->getTypeClass()->name);
			$ids = array();
			foreach ($objects as $object) {
				$ids[] = $this->persistenceManager->getIdentifierByObject($object);
			}
			$query->matching($query->in('Persistence_Object_Identifier', $ids));
			return $query;
		}

		return $objects->getQuery();
	}
}

?>
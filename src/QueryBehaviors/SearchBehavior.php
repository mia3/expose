<?php
namespace Mia3\Expose\QueryBehaviors;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Mia3\Expose\Core\QueryBehaviors\AbstractQueryBehavior;

/**
 */
class SearchBehavior extends AbstractQueryBehavior
{
    /**
     *
     * @param object $query
     * @return string Rendered string
     * @api
     */
    public function run($query)
    {
        $schema = $this->templateVariableContainer->get('schema');
        $properties = $schema->getSearchProperties();

        if (empty($properties)) {
            return;
        }

        $search = '';
        if ($this->request->hasArgument("search")) {
            $search = $this->request->getArgument("search");

            if (!empty($search)) {
                $constraints = array();
                foreach ($properties as $property) {
                    $constraints[] = $query->like($property->getPath(), '%' . $search . '%', false);
                }
                $query->matching($query->logicalAnd(
                    $query->getConstraint(),
                    $query->logicalOr($constraints)
                ));
            }
        }

        $content = $this->viewHelperVariableContainer->getView()->renderPartial('Search', null, array(
            'search' => $search,
        ));
        $this->addToBlock('top', $content);
    }
}
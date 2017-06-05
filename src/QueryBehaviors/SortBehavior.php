<?php
namespace Mia3\Expose\QueryBehaviors;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".           *
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
class SortBehavior extends AbstractQueryBehavior
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
        $sortBy = $schema->getDefaultSortBy();
        $order = $schema->getDefaultOrder() == 'DESC' ? 'DESC' : 'ASC';

        if ($this->request->hasArgument("sortBy")) {
            $sortBy = $this->request->getArgument("sortBy");

            if ($this->request->hasArgument("order")) {
                $order = $this->request->getArgument("order");
            } else {
                $order = "DESC";
            }
        }

        if ($sortBy !== null) {
            $query->setOrderings(array(
                $sortBy => $order,
            ));
        }

        $this->sorting = array(
            "sortBy" => $sortBy,
            "order" => $order,
            "oppositeOrder" => $order == "ASC" ? "DESC" : "ASC",
        );

        $this->addWrapper('property', $this);
    }

    public function wrap($content, $arguments)
    {
        $arguments['content'] = $content;
        $this->viewHelperVariableContainer->add('Mia3\Expose\ViewHelpers\Query\SortViewHelper', 'sorting',
            $this->sorting);
        $content = $this->viewHelperVariableContainer->getView()->renderPartial('SortField', null, $arguments);
        $this->viewHelperVariableContainer->remove('Mia3\Expose\ViewHelpers\Query\SortViewHelper', 'sorting');

        return $content;
    }
}
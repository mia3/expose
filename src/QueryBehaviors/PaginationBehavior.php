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
class PaginationBehavior extends AbstractQueryBehavior
{
    /**
     * @var ConfigurationManager
     * @Flow\Inject
     */
    protected $configurationManager;

    /**
     *
     * @param object $query
     * @return string Rendered string
     * @api
     */
    public function run($query)
    {
        $configurationPath = 'Mia3.Expose.Pagination';
        $this->query = $query;
        $this->settings = $this->configurationManager->getConfiguration(ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
            $configurationPath);

        $this->total = $this->query->count();
        $limits = $this->handleLimits();
        $pagination = $this->handlePagination();

        $content = $this->viewHelperVariableContainer->getView()->renderPartial('Pagination', null, array(
            'pagination' => $pagination,
            'limits' => $limits,
        ));
        $this->addToBlock('bottom', $content);
    }

    public function handleLimits()
    {

        $limits = array();
        foreach ($this->settings["Limits"] as $limit) {
            $limits[$limit] = false;
        }

        if ($this->request->hasArgument("limit")) {
            $this->limit = $this->request->getArgument("limit");
        } else {
            $this->limit = $this->settings["DefaultLimit"];
        }

        $unset = false;
        foreach ($limits as $key => $value) {
            $limits[$key] = ($this->limit == $key);

            if (!$unset && intval($key) >= intval($this->total)) {
                $unset = true;
                continue;
            }
            if ($unset) {
                unset($limits[$key]);
            }
        }

        if (count($limits) == 1) {
            $limits = array();
        }

        $this->query->setLimit($this->limit);

        return $limits;
    }

    public function handlePagination()
    {
        $currentPage = 1;

        if ($this->request->hasArgument("page")) {
            $currentPage = $this->request->getArgument("page");
        }

        $pages = array();
        for ($i = 0; $i < ($this->total / $this->limit); $i++) {
            $pages[] = $i + 1;
        }

        if ($currentPage > count($pages)) {
            $currentPage = count($pages);
        }

        $offset = ($currentPage - 1) * $this->limit;
        $offset = $offset < 0 ? 0 : $offset;
        $this->query->setOffset($offset);
        $pagination = array("offset" => $offset);

        if (count($pages) > 1) {
            $pagination["currentPage"] = $currentPage;

            if ($currentPage < count($pages)) {
                $pagination["nextPage"] = $currentPage + 1;
            }

            if ($currentPage > 1) {
                $pagination["prevPage"] = $currentPage - 1;
            }

            if (count($pages) > $this->settings["MaxPages"]) {
                $max = $this->settings["MaxPages"];
                $start = $currentPage - (($max + ($max % 2)) / 2);
                $start = $start > 0 ? $start : 0;
                $start = $start > 0 ? $start : 0;
                $start = $start + $max > count($pages) ? count($pages) - $max : $start;
                $pages = array_slice($pages, $start, $max);
            }

            $pagination["pages"] = $pages;
        }

        return $pagination;
    }
}
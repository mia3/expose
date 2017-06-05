<?php
namespace Mia3\Expose\Core\QueryBehaviors;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Mia3.Expose".       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 */
interface QueryBehaviorInterface
{
    /**
     *
     * @param object $query
     * @return void
     * @api
     */
    public function run($query);
}
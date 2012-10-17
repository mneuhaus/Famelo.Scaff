<?php
namespace Famelo\Scaff\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Fluid".                 *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 *
 * = Examples =
 *
 * <code title="">
 * </code>
 * <output>
 * </output>
 *
 * @api
 */
class SubRequestViewHelper extends \TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper {
	/**
	 * @param string $namespace
	 * @return string
	 */
	public function render($namespace = 'subrequest') {
		$request = $this->controllerContext->getRequest();
		$response = $this->controllerContext->getResponse();
		$scaffRuntime = new \Famelo\Scaff\Core\ScaffRuntime($namespace, $request, $response);
		return $scaffRuntime->execute();
	}
}


?>
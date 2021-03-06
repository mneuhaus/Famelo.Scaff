<?php
namespace Famelo\Scaff\ViewHelpers\Link;

/*                                                                        *
 * This script belongs to the FLOW3 package "TYPO3.TYPO3".                *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * A view helper for creating links to modules.
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <typo3:link.module path="system/userexpose">some link</typo3:link.module>
 * </code>
 *
 * Output:
 * <a href="typo3/system/userexpose">some link</a>
 * (depending on current node, format etc.)
 *
 */
class ModuleViewHelper extends \TYPO3\Fluid\ViewHelpers\Link\ActionViewHelper {
	/**
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 * @Flow\Inject
	 */
	protected $configurationManager;

	/**
	 * Render the link.
	 *
	 * @param string $action Target action
	 * @param array $arguments Arguments
	 * @param string $controller Target controller. If NULL current controllerName is used
	 * @param string $package Target package. if NULL current package is used
	 * @param string $subpackage Target subpackage. if NULL current subpackage is used
	 * @param string $section The anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html"
	 * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
	 * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @param string $path
	 * @param string $namspace
	 * @param string $settingsPath
	 * @return string The rendered link
	 * @throws \TYPO3\Fluid\Core\ViewHelper\Exception
	 * @api
	 */
	public function render($action = NULL, $arguments = array(), $controller = 'standard', $package = NULL, $subpackage = NULL, $section = '', $format = '',  array $additionalParams = array(), $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array(), $path = NULL, $namespace = 'subrequest', $settingsPath = 'Famelo.Scaff.modules') {
		$moduleConfiguration = $this->configurationManager->getConfiguration(\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, $settingsPath . '.' . $path);
		
		if (isset($moduleConfiguration['arguments'])) {
			$arguments = array(
				'--' . $namespace => $moduleConfiguration['arguments']
			);
		}

		if (isset($moduleConfiguration['defaultControllerArguments'])) {
			$arguments = $moduleConfiguration['defaultControllerArguments'];
		}

		if (isset($moduleConfiguration['defaultController'])) {
			$controller = $moduleConfiguration['defaultController'];
		}
		$arguments['module'] = $path;

		if ($action === NULL) {
			$action = 'index';
		}

		return parent::render($action, $arguments, $controller, $package, $subpackage, $section, $format, $additionalParams, $addQueryString, $argumentsToBeExcludedFromQueryString);
	}

}
?>
<?php
namespace Famelo\Scaff\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Famelo.Admin".               *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the Famelo.Admin package 
 *
 * @Flow\Scope("singleton")
 */
class StandardController extends \TYPO3\Flow\Mvc\Controller\ActionController {
    /**
     * @var \TYPO3\Flow\Configuration\ConfigurationManager
     * @Flow\Inject
     */
    protected $configurationManager;

	/**
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$scaffRuntime = new \Famelo\Scaff\Core\ScaffRuntime($this->request, $this->response);
		$this->view->assign('content', $scaffRuntime->execute());

		$pluginArguments = $this->request->getPluginArguments();
		if (isset($pluginArguments["scaffRuntime"])) {
			$modules = $this->configurationManager->getConfiguration(\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, 'Famelo.Scaff.modules');
			$controller = strtolower($pluginArguments["scaffRuntime"]["@controller"]);
			$package = strtolower($pluginArguments["scaffRuntime"]["@package"]);
			foreach ($modules as $module => $moduleConfiguration) {
				$modulePackage = isset($moduleConfiguration["arguments"]["@package"]) ? $moduleConfiguration["arguments"]["@package"] : "Famelo.Scaff";
				if ($package !== strtolower($modulePackage)) continue;

				$moduleController = $moduleConfiguration["arguments"]["@controller"];
				if ($controller !== strtolower($moduleController)) continue;

				$this->view->assign("currentModule", $module);
				break;
			}
		}
	}

}

?>
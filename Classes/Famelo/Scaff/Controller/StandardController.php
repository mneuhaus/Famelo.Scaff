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
		if ($this->request->hasArgument('module')) {
			$this->view->assign('currentModule', $this->request->getArgument('module'));
			$this->view->assign('currentModuleConfiguration',
				$this->configurationManager->getConfiguration(
					\TYPO3\Flow\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS,
					'Famelo.Scaff.modules.' . $this->request->getArgument('module')
				)
			);
		}
	}

}

?>
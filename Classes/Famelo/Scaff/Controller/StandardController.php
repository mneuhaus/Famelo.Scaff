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
	 * Index action
	 *
	 * @return void
	 */
	public function indexAction() {
		$scaffRuntime = new \Famelo\Scaff\Core\ScaffRuntime($this->request, $this->response);
		$this->view->assign('content', $scaffRuntime->execute());
	}

}

?>
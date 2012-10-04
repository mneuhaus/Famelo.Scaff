<?php
namespace Famelo\Scaff\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Famelo.Admin".               *
 *                                                                        *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Standard controller for the Famelo.Admin package 
 *
 * @FLOW3\Scope("singleton")
 */
class StandardController extends \TYPO3\FLOW3\Mvc\Controller\ActionController {

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
<?php
namespace Famelo\Scaff\Core;

/* *
 * This script belongs to the TYPO3.Expose package.                       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use TYPO3\FLOW3\Mvc\ActionRequest;

/**
 */
class ScaffRuntime {

	/**
	 * @var array
	 */
	protected $defaultExposeControllerArguments = array();

	/**
	 * Default controller to render if nothing else is specified
	 * or present in the arguments
	 *
	 * @var string
	 */
	protected $defaultExposeControllerClassName = 'Famelo\\Scaff\\Controller\\EmptyController';

	/**
	 * @var \TYPO3\FLOW3\Mvc\Dispatcher
	 * @FLOW3\Inject
	 */
	protected $dispatcher;

	/**
	 * @var string
	 */
	protected $namespace = 'scaffRuntime';

	/**
	 * @var \TYPO3\FLOW3\Mvc\ActionRequest
	 */
	protected $request;

	/**
	 * @var \TYPO3\FLOW3\Http\Response
	 */
	protected $response;

	/**
	 * @param \TYPO3\FLOW3\Mvc\ActionRequest $parentRequest
	 * @param \TYPO3\FLOW3\Http\Response $response
	 */
	public function __construct(\TYPO3\FLOW3\Mvc\ActionRequest $parentRequest, \TYPO3\FLOW3\Http\Response $response) {
		$arguments = $parentRequest->getPluginArguments();
		$this->request = new ActionRequest($parentRequest);
		$this->request->setArgumentNamespace('--' . $this->namespace);
		$this->request->setControllerActionName('index');
		$this->request->setControllerPackageKey('Famelo.Scaff');
		if (isset($arguments[$this->namespace])) {
			$this->request->setArguments($arguments[$this->namespace]);
		}

		$this->request->setFormat('html');
		// TODO: the response below should be an MVC response
		$this->response = new \TYPO3\FLOW3\Http\Response($response);
	}

	/**
	 * This method is a workaround for URI building in case of the first request.
	 * Normally, request arguments are not expected to be modified by the user;
	 * and uri building relies on the fact that inside the main request, all nested
	 * arguments are there. This is especially important when addQueryString=TRUE.
	 * In case of the configured default arguments, we need to set them in the parent requests
	 * all up to the main request, such that they are caught by the URI builder when
	 * addQueryString=TRUE.
	 *
	 * @param \TYPO3\FLOW3\Mvc\ActionRequest $request
	 * @param array $argumentValueToSet
	 * @return void
	 */
	protected function setArgumentInParentRequests(ActionRequest $request, array $argumentValueToSet) {
		if ($request->getMainRequest() === $request) {
			return;
		}
		$parentRequest = $request->getParentRequest();
		$currentNamespace = $request->getArgumentNamespace();
		$parentRequest->setArgument($currentNamespace, $argumentValueToSet);
		$this->setArgumentInParentRequests($parentRequest, array($currentNamespace => $argumentValueToSet));
	}

	/**
	 * Set the arguments for the initial expose controller
	 *
	 * @param array $defaultExposeControllerArguments
	 * @return void
	 */
	public function setDefaultExposeControllerArguments(array $defaultExposeControllerArguments) {
		$this->defaultExposeControllerArguments = $defaultExposeControllerArguments;
	}

	/**
	 * Set the class name for the expose controller to be used when no other
	 * expose controller has been specified
	 *
	 * @param string $defaultExposeControllerClassName
	 * @return void
	 */
	public function setDefaultExposeControllerClassName($defaultExposeControllerClassName) {
		$this->defaultExposeControllerClassName = $defaultExposeControllerClassName;
	}

	/**
	 * @return string
	 */
	public function execute() {
		$this->prepareExecution();
		$this->dispatcher->dispatch($this->request, $this->response);

		return $this->response->getContent();
	}

	/**
	 * @return void
	 */
	protected function prepareExecution() {
		$controllerObjectName = $this->request->getControllerObjectName();
		if (empty($controllerObjectName)) {
			$this->request->setControllerObjectName($this->defaultExposeControllerClassName);
			$this->request->setArguments($this->defaultExposeControllerArguments);
			$this->setArgumentInParentRequests($this->request, $this->defaultExposeControllerArguments);
		}
		if ($this->request->getControllerActionName() === NULL) {
			$this->request->setControllerActionName('index');
		}
	}
}

?>
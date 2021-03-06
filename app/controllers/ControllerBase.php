<?php
namespace Talon\Controllers;

use \Phalcon\Exception,
	\Phalcon\Mvc\Controller,
	\Phalcon\Tag,
	\Phalcon\Dispatcher;

/**
 * Class ControllerBase
 *
 * The one controller to rule them all
 */
class ControllerBase extends Controller
{
	/**
	 * Everything a growing controller needs
	 */
	protected function initialize()
	{
		Tag::prependTitle('Talon | ');
	}

	/**
	 * Method for forwarding requests to different controller actions
	 *
	 * @param $uri
	 * @throws \Phalcon\Exception
	 */
	protected function forward($uri){
		if(!is_string($uri))
			throw new Exception('forward expects uri format string');

		$uriParts = explode('/', $uri);

		if($uriParts[0] === '')
			$uriParts[] = 'index';

		if(count($uriParts) === 1 || $uriParts[1] == '')
			$uriParts[1] = 'index';



		$this->dispatcher->forward(
			array(
				'controller' => $uriParts[0],
				'action' => $uriParts[1]
			)
		);
	}

	/**
	 * Make sure that the request is what we were expecting
	 *
	 * @param array $checks
	 * @return bool
	 */
	protected function validateRequest($checks = array()) {
		$valid = true;

		foreach($checks as $key => $value) {
			if($key === 'method' && $value === 'post') {
				$valid = $this->request->isPost();

				if(!$valid)
					$this->flashSession->error("Only POST requests can be meade to this URL");
			} elseif($key === 'token') {
				$valid = $this->security->checkToken();

				if(!$valid)
					$this->flashSession->error("Incorrect security token");
			}

			if(!$valid)
				break;
		}

		return $valid;
	}

	/**
	 * Execute before the router so we can determine if this is a private controller, and must be authenticated, or a
	 * public controller that is open to all.
	 *
	 * @param \Phalcon\Dispatcher $dispatcher
	 * @return boolean
	 */
	public function beforeExecuteRoute(Dispatcher $dispatcher)
	{
		$controllerName = $dispatcher->getControllerName();

		// Only check permissions on private controllers
		if ($this->acl->isPrivate($controllerName)) {

			// Get the current identity
			$identity = $this->auth->getIdentity();

			// If there is no identity available the user is redirected to index/index
			if (!is_array($identity)) {

				$this->flashSession->notice('You are not logged in!');
				return $this->response->redirect('session/login');
			}

//			// Check if the user have permission to the current option
//			$actionName = $dispatcher->getActionName();
//			if (!$this->acl->isAllowed($identity['profile'], $controllerName, $actionName)) {
//
//				$this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);
//
//				if ($this->acl->isAllowed($identity['profile'], $controllerName, 'index')) {
//					$dispatcher->forward(array(
//						'controller' => $controllerName,
//						'action' => 'index'
//					));
//				} else {
//					$dispatcher->forward(array(
//						'controller' => 'user_control',
//						'action' => 'index'
//					));
//				}
//
//				return false;
//			}
		}
	}
}

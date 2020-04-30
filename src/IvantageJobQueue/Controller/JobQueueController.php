<?php

namespace IvantageJobQueue\Controller;

use IvantageJobQueue\Tasks\AbstractJobQueueTask;

use Zend\Mvc\Controller\AbstractActionController;
use ZendJobQueue;
use Exception;

class JobQueueController extends AbstractActionController {

	/**
	 *
	 * Generalized action which is the endpoint for every JobQueue
	 * task. The Task will attempt to execute its run method which
	 * contains all of the bulk of the task, and set the status accordingly.
	 */
	public function jobQueueAction() {
		$params = ZendJobQueue::getCurrentJobParams();
		if(isset($params['obj'])) {
			$obj = unserialize(base64_decode($params["obj"]));
			if($obj instanceof AbstractJobQueueTask) {
				try {
					$obj->run();
					ZendJobQueue::setCurrentJobStatus(ZendJobQueue::OK);
					exit;
				} catch (Exception $e) {
					$msg = $e->getMessage();
					ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, $msg);
					exit;
				}
			}
		}
		ZendJobQueue::setCurrentJobStatus(ZendJobQueue::FAILED, 'Required parameter "obj" is missing');
	}

}
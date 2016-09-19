<?php

/**
 *
 * An abstraction of a job queue task. Provides the mechanisms
 * necessary to queue and execute a task. Implementing classes
 * only need to implement the _execute method, which defines the
 * functionality of the specific task.
 *
 * @author Evan
 *
 */
namespace IvantageJobQueue\Tasks;

use ZendJobQueue;

abstract class AbstractJobQueueTask {

	const OPT_NAME = 'name';
	const OPT_SCHEDULE = 'schedule';
	const OPT_SCHEDULE_TIME = 'schedule_time';

	private $_options = array();

	/**
	 * The functionality of the task should be defined in this
	 * method by all inheriting classes.
	 */
	protected abstract function _execute();

	/**
	 * Execute the task on the Zend Server Job Queue
	 *
	 * The task object is serialized and sent as an option to
	 * a generic job queue URL endpoint. Once there, it will be
	 * deserialized and run via the `run()` method. Classes extending
	 * AbstractJobQueue task may choose to override this method for
	 * clarity and testability. However, they should merely act as a
	 * wrapper for calling this parent method.
	 *
	 * @param  string $url          The URL endpoint for job queue tasks.
	 * @param  array  $queueOptions Options for the job queue.
	 * @return int 					The integer ID for the generated job queue task.
	 */
	public function execute($url, $queueOptions = array()) {
		$queue = new ZendJobQueue();

		// Add the name of this class as the name of the job
		$queueOptions = array_merge(
			array('name' => get_class($this)),
			$queueOptions
		);

		$id = $queue->createHttpJob(
			$url,
			array(
				'obj' => base64_encode(serialize($this))
			),
			$queueOptions
		);

		// ZendJobQueue::createHttpJob()returns an int id we can use to check
		// the status of the job
		return $id;
	}

	/**
	 * Run the contents of the task.
	 *
	 * This method gets run on the deserialized object in the job queue.
	 * Functionality should be defined in the `_execute` method of the extending class.
	 */
	public final function run() {
		$this->_execute();
	}

}
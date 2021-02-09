# ivantagejobqueue
> A Laminas module for creating abstract Zend Server Job Queue tasks based on
[Kevin Schroeder's implementation](http://www.eschrade.com/page/queue-introduction-zend-server-queue-4b8eef5c/)

## Installation

Install using [composer](http://getcomposer.org):

```
composer require ivantage/ivantagejobqueue
```

## Usage

Job queue tasks are created by defining classes that extend `AbstractJobQueueTask`.
Fill in the `_execute` method with the actual code that should be run by the job.

```
use IvantageJobQueue\Tasks\AbstractJobQueueTask;

class MyTask extends AbstractJobQueueTask {

	public function __construct() {
		// ... constructor code
	}

	public function _execute() {
		// Put code that should be run by the job here
	}
}
```

To run the task, all you need to do is create an instance of your class and call
the `execute` method, passing the URL of the generic job queue endpoint and any
[additional parameters](http://files.zend.com/help/Zend-Server/content/zendserverapi/zend_job_queue-php_api.htm#function-createHttpJob)
you would like to provide.

`ivantagejobqueue` includes a controller which will give you a generic job
queue endpoint at `http://mysite.com/jobqueue`.

```
$task = new MyTask();
$taskId = $task->execute('http://' . $_SERVER['HTTP_HOST'] . '/jobqueue');
```

## Known Limitations

- Because `ivantagejobqueue` works by serializing the task object and
deserializing it in order to run, the classes that you define for your
tasks must be serializable.

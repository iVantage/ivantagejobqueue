<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'IvantageJobQueue\Controller\JobQueue' => 'IvantageJobQueue\Controller\JobQueueController'
		)
	),
	'router' => array(
		'routes' => array(
			'job-queue' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/jobqueue',
					'defaults' => array(
                        'controller' => 'IvantageJobQueue\Controller\JobQueue',
                        'action'     => 'jobQueue',
                    )
				)
			)
		)
	),
	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy'
		)
	)
);
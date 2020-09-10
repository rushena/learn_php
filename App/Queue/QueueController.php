<?php

namespace App\Queue;

use App\Renderer;
use App\Request;
use App\Response;
use App\TasksQueue;

class QueueController
{
	/**
	 * @var array
	 */
	private $params;

	public function __construct(array $params) {
		$this->params = $params;
	}

	public function list()
	{
		$tasksList = TasksQueue::getTaskList();
		Renderer::getSmarty()->assign('tasks', $tasksList);
		Renderer::getSmarty()->display('queue/list.tpl');
	}

	public function run()
	{
		$id = Request::getIntFromGet("id");

		TasksQueue::runById($id);

		Response::redirect('/queue');
	}

}
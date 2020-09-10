<?php

namespace App;

use App\Db\Db;

class TasksQueue
{
	public static function addTask(string $name, string $task, array $params)
	{
		$taskMethod = explode('::', $task);
		$taskClassExist = class_exists($taskMethod[0]);
		$taskMethodExist = method_exists($taskMethod[0], $taskMethod[1]);

		if (!$taskClassExist || !$taskMethodExist) {
			return false;
		}

		return Db::insert('tasks_queue', [
			"name" => $name,
			"task" => $task,
			"params" => json_encode($params),
			"create_at" => Db::expr('NOW()'),
		]);
	}

	public static function getTaskList()
	{
		$query = "SELECT * FROM `tasks_queue` ORDER BY create_at DESC";

		return Db::fetchAll($query);
	}

	public static function getById($id)
	{
		$query = "SELECT * FROM `tasks_queue` WHERE id=$id";

		return Db::fetchRow($query);
	}

	public static function setStatus($taskId, string $status)
	{
		$availableStatus = ['new', 'in_process', 'done', 'error'];

		if(!in_array($status, $availableStatus)) {
			return false;
		}

		Db::update('tasks_queue', [
			"status" => $status
		], 'id = ' . $taskId);

	}

	public static function runById($id)
	{
		$task = static::getById($id);

		return static::run($task);
	}

	public static function run(array $task)
	{
		$id = $task["id"] ?? null;

		if (empty($task) || is_null($id)) {
			return false;
		}

		$taskMethod = explode('::', $task['task']);

		$taskClassExist = class_exists($taskMethod[0]);
		$taskMethodExist = method_exists($taskMethod[0], $taskMethod[1]);

		if (!$taskClassExist || !$taskMethodExist) {
			static::setStatus($id, 'error');
			return false;
		}
		static::setStatus($id, 'in_process');
		call_user_func($task['task'], json_decode($task["params"], true));
		static::setStatus($id, 'done');
	}

	public static function execute()
	{
		$query = "SELECT * from `tasks_queue` WHERE status = 'in_process'";
		$inProcessTask = Db::fetchRow($query);

		if (!empty($inProcessTask)) {
			return false;
		}

		$query = "SELECT * from `tasks_queue` WHERE status = 'new' ORDER BY create_at LIMIT 1";

		$newTaskProcess = Db::fetchOne($query);

		return static::run($newTaskProcess);

	}
}
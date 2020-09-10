<?php

namespace App\Import;

use App\FS;
use App\Renderer;
use App\Response;
use App\TasksQueue;

class ImportController
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
		Renderer::getSmarty()->display('import/index.tpl');
	}

	public function upload()
	{
		$file = $_FILES["import_file"];

		if (is_null($file) || empty($file['name'])) {
			die('Not added file');
		}

		$importFileName = "import" . time() . $file["name"];

		$uploadDir = APP_UPLOAD_DIR . '/import';

		FS::createDir($uploadDir);

		move_uploaded_file($file["tmp_name"], $uploadDir . '/' . $importFileName);

		$taskName = "Импорт товаров " . $importFileName;
		$task = "App\Import::productsFromFileTask";
		$taskParams = [
			"filename" => $importFileName
		];

		TasksQueue::addTask($taskName, $task , $taskParams);

		Response::redirect('/queue');
	}
}
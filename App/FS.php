<?php

namespace App;

class FS {
	public static function deleteDir($path) {
		$files = array_diff(scandir($path), array('.', '..'));

		foreach ($files as $file) {
			if (is_dir("$path/$file")) {
				static::deleteDir("$path/$file");
			} else {
				unlink("$path/$file");
			}
		}

		return rmdir($path);
	}

	public static function createDir($path) {
		if (!file_exists($path)) {
			mkdir($path);
		}

		return true;
	}

	public static function scanDir($dir)
	{
		$list = scandir($dir);

		$list =  array_filter($list, function($item) {
			return !in_array($item, [".", ".."]);
		});

		$filenames = [];

		foreach ($list as $filename) {
			$filepath = $dir . '/' . $filename;

			if (!is_dir($filepath)) {
				$filenames[] = $filepath;
			} else {
				$filenames = array_merge($filenames, self::scanDir($filepath));
			}
		}

		return $filenames;
	}

    public static function deleteFile($path) {
        if (!file_exists($path) && is_file($path)) {
            unlink($path);
            return true;
        }

        return false;

    }
}
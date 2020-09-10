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

    public static function deleteFile($path) {
        if (!file_exists($path) && is_file($path)) {
            unlink($path);
            return true;
        }

        return false;

    }
}
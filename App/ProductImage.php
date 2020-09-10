<?php

namespace App;

use App\Db\Db;

class ProductImage {

    private CONST IMAGE_MIME_DICT = [
        "image/png" => ".png",
        "image/jpeg" => ".jpeg",
        "image/webp" => ".webp",
        "image/gif" => ".gif",
        "image/bmp" => ".bmp",
        "image/x-icon" => ".ico",
        "image/svg+xml" => ".svg",
        "image/tiff" => ".tiff",
    ];

	public static function add($image) {

		if (isset($image['id'])) {
			unset($image['id']);
		}
		return Db::insert('product_images', $image);
	}

	public static function getListByProductId($id) {
		$query = "SELECT * FROM `product_images` WHERE product_id=$id";
		
		return Db::fetchAll($query);
	}

    public static function getById($id) {
        $query = "SELECT * from `product_images` WHERE id=$id";

        return Db::fetchRow($query);
    }

	public static function deleteByProductID($id) {
		return Db::delete('product_images', "product_id=$id");
	}

	public static function deleteByID(int $id) {
	    $file = static::getById($id);
        FS::deleteFile($file["path"]);
		return Db::delete("product_images", "id=$id");
	}

    public static function updateByID(int $id, $image) {

        if (isset($image['id'])) {
            unset($image['id']);
        }
        return Db::update('product_images', $image, "id = $id");
    }

    public static function uploadImages(int $productId, array $files) {

	    for ($i = 0; $i < count($files["name"]); $i++) {

	        $result = static::uploadImage($productId, [
	            "name" => $files['name'][$i],
                "tmp_name" => $files['tmp_name'][$i],
                "size" => $files['size'][$i]
            ]);
        }

	    return true;
    }

    public static function uploadImage($productID, $file) {
        $image_name = basename(trim($file['name']));

        if (empty($image_name)) {
            return false;
        }

        $image_name = static::getUniqueUploadImageName($productID, $image_name);

        $dir = static::getFolderForImage($productID);

        $image_path = $dir . '/' . $image_name;
        $image_size = $file['size'];
        $image_tmp_name = $file['tmp_name'];

        move_uploaded_file($image_tmp_name, $image_path);

        ProductImage::add([
            "name" => $image_name,
            "path" => str_replace(APP_PUBLIC_DIR, '', $image_path),
            "size" => $image_size,
            "product_id" => $productID,
        ]);

        return true;
    }

    protected static function getUniqueUploadImageName(int $productID, string $imageName) {
        $filename = $imageName;
        $counter = 0;

        while (true) {
            $hasImageWithName = ProductImage::findByFilenameInProduct($productID, $filename);

            if (empty($hasImageWithName)) {
                break;
            }

            $info = pathinfo($imageName);
            $filename = $info["filename"];
            $filename .= "_" . $counter . "." . $info["extension"];

            $counter++;
        }

        return $filename;

    }

    public static function uploadImageFromURL (int $productId, $url) {
        if (empty($url)) {
            return false;
        }

        $dir = static::getFolderForImage($productId);

        $imageExt = static::getExtensionByUrl($url);

        if (is_null($imageExt)) {
            return false;
        }

        $product_image_id  = ProductImage::add([
            "name" => 'tmp',
            "path" => '',
            "size" => 0,
            "product_id" => $productId,
        ]);

        $filename = $productId . '_' . $product_image_id . '_upload' . time() . $imageExt;
        $image_url_path = $dir . '/' . $filename;

        file_put_contents($image_url_path, fopen($url, 'r'));

        ProductImage::updateByID($product_image_id, [
            "name" => $filename,
            "path" => str_replace(APP_PUBLIC_DIR, '', $image_url_path)
        ]);

        return true;
    }

    protected static function getExtensionByUrl(string $url) {
        $mimeType = static::getMimeTypeByUrl($url);

        return static::IMAGE_MIME_DICT[$mimeType] ?? null;
    }

    protected static function getMimeTypeByUrl(string $url) {
        $image_url_header = get_headers($url);
        $mimeType = null;

        if ($image_url_header === false) {
            return null;
        }

        foreach ($image_url_header as $item) {
            if (strpos(strtolower($item), 'content-type') === false) {
                continue;
            }

            $type_array = explode(':', $item);

            $mimeType = array_map(function($elem) {
                return strtolower(trim($elem));
            }, $type_array)[1];
        }

        return $mimeType;
    }

    protected static function getFolderForImage(int $product_id) {
        $product_upload_dir = APP_UPLOAD_PRODUCTS_DIR . '/' . $product_id;

        FS::createDir($product_upload_dir);

        return $product_upload_dir;
    }

    public static function findByFilenameInProduct(int $productId, string $filename)
    {
        $query = "SELECT * FROM product_images WHERE product_id = $productId AND name = '$filename'";
        return Db::fetchRow($query);
    }
}
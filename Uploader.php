<?php

class Uploader
{
    public static function uploadImage($file)
    {
        if (empty($file['name'])) {
            return null;
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            return null;
        }

        $newName = time() . '_' . uniqid() . '.' . $extension;
        move_uploaded_file($file['tmp_name'], __DIR__ . '/uploads/' . $newName);

        return $newName;
    }
}
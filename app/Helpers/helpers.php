<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function getFileURL($file)
{
    $file = json_decode($file);
    $v = new \TCG\Voyager\Voyager();
    if (sizeof($file) > 0) {
        return $v->image($file[0]->download_link);
    } else {
        return '';
    }
}

function getImageURL($image)
{
    $v = new \TCG\Voyager\Voyager();
    return $v->image($image);
}

function isSuperAdmin()
{
    if (auth('web')->check() && auth('web')->user()->role_id == 1) {
        return true;
    }
    return false;
}


function getRoleID($role)
{
    $role = \TCG\Voyager\Models\Role::where('name', $role)->first();
    if ($role) {
        return $role->id;
    }
    return -1;
}

function getThumbnail($model, $image, $size = 'm')
{
    if ($model) {
        switch ($size) {
            case 's':
                $size = 'small';
                break;
            case 'm':
                $size = 'medium';
                break;
            case 'l':
                $size = 'large';
                break;
            case 'c':
                $size = 'cropped';
                break;
        }
        return $model->thumbnail($size, $image);
    }
    return $model->{$image};
}


/*
 * Image
 */

function upload($dir, $format, $image = null)
{
    if ($image != null) {
        $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }
        Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
    } else {
        $imageName = 'def.png';
    }

    return $imageName;
}

function update($dir, $old_image, $format, $image = null)
{
    if (Storage::disk('public')->exists($dir . $old_image)) {
        Storage::disk('public')->delete($dir . $old_image);
    }
    $imageName = upload($dir, $format, $image);
    return $imageName;
}

function delete($full_path)
{
    if (Storage::disk('public')->exists($full_path)) {
        Storage::disk('public')->delete($full_path);
    }

    return [
        'success' => 1,
        'message' => 'Removed successfully !'
    ];

}


function slugify($text, $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
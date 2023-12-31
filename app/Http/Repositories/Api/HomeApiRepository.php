<?php

namespace App\Http\Repositories\Api;

use App\Enums\IconStatus;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\IconResource;
use App\Models\Icon;
use Illuminate\Support\Facades\File;
use ZipArchive;

class HomeApiRepository
{
    const ICONS_FOLDER = 'images/icons/';
    const EXPORT_ICONS_TEMP_FOLDER = 'file/exported_icons';

    public static function iconList()
    {
        $icon = Icon::query()->where('status', IconStatus::Active->value)->paginate(20);
        return [
            'data' => IconResource::collection($icon),
            'pagination' => new PaginateResource($icon)
        ];
    }


    public static function createExcel($icons, $user)
    {
        $zip = new ZipArchive();

        $zipName = '/' . strstr($user->email, '@', true) . '-icons.zip';
        $fileName = self::EXPORT_ICONS_TEMP_FOLDER . $zipName;

        if(File::exists(public_path($fileName))){
            File::delete(public_path($fileName));
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) == TRUE) {

            foreach ($icons as $item) {
                $icon = Icon::query()->find($item);

                if ($icon->file_name) {
                    $path = public_path(self::ICONS_FOLDER . $icon->file_name);

                    if (file_exists($path)) {
                        $zip->addFile($path, $icon->file_name);
                    }
                }
            }
            $zip->close();
        }
        return public_path($fileName);
    }
}

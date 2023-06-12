<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;


class ImageService
{
    public static function createFolders($folderName)
    {
        try {
/*             Verificación y o creación de la carpeta para las imagenes */
            if (!file_exists(public_path('storage/images/' . $folderName))) {
                mkdir(public_path('storage/images/' . $folderName), 0755, true);
                return true;
            } elseif (file_exists(public_path('storage/images/' . $folderName))) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function uploadImagen($image, $folderName)
    {
        try {
/*                 Verificar el archivo y la carpeta contenedora */
            if ($image && self::createFolders($folderName)) {
/*                 Nombre del archivo formateado a md5 */
                $imageNewfileName = md5($image->getClientOriginalName());
/*                 Guardar la imagen en el storage utilizando Intervention Image */
                $imageRenderized = ImageManagerStatic::make($image->getRealPath());
                $imageRenderized->save(public_path('storage/images/' . $folderName .  '/' . $imageNewfileName . '.' . $image->getClientOriginalExtension()), 100);
/*                 Ruta referencial */
                return Storage::url('public/images/' . $folderName . '/' . $imageNewfileName . '.' . $image->getClientOriginalExtension());
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}

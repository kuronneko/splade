<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;


class ImageService
{
    public static function creacionVerificacionCarpetas()
    {
        try {
            //verificación y o creación de la carpeta para las imagenes basadas en el nombre de la pagina, utilizando su slug
            if (!file_exists(public_path('/storage/images'))) {
                mkdir(public_path('/storage/images'), 0755, true);
                return true;
            } elseif (file_exists(public_path('/storage/images'))) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function uploadImagen($img)
    {
        try {
            //verificar el archivo y la carpeta contenedora
            if ($img) {
                //nombre del archivo formateado a md5
                $imgNewfileName = md5($img->getClientOriginalName());

                //guardar la imagen en el storage
                $imgRenderized = ImageManagerStatic::make($img->getRealPath())->resize(720, null, function ($constraint) { //resize image based on width
                    $constraint->aspectRatio();
                })->resizeCanvas(720, null);

                $imgRenderized->save(public_path('/storage/images/' . '/' . $imgNewfileName . '.' . $img->getClientOriginalExtension()), 100);
                //ruta referencial
                return Storage::url('public/images/' . '/' . $imgNewfileName . '.' . $img->getClientOriginalExtension());
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}

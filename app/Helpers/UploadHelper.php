<?php

    namespace App\Helpers;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;

    class UploadHelper {

        public static function uploadFiles($files, $directory, $disk = 'public') {
            // Get the specified disk from the Storage facade
            $storage = Storage::disk($disk);
            // If the directory does not exist in the storage disk, create it
            if (!$storage->exists($directory)){
                $storage->makeDirectory($directory);
            }
            // If the $files parameter is not an array, put it in an array
            if (!is_array($files)){
                $files = [$files];
            }
            // Array to hold the paths of the uploaded files
            $uploadedFiles = [];
            // Loop through each file and upload it to the specified directory using the Storage facade
            foreach ($files as $file){
                $path = $storage->putFile($directory, $file);
                $uploadedFiles[] = $path;
            }
        
            // Return the array of uploaded file paths
            return $uploadedFiles;
        }
        

    }
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Exception;
use Illuminate\Support\Facades\Auth;

class FileUploadController extends Controller
{

    public function upload(Request $request,  $disk = 'local', $uploadPath = 'uploads', $fileModelName ='App\Models\File')
    {
        
        $userId = 1;

        $path = [];
        $savedFiles = [];
        $requestFiles = $request->file('files');
        if(!is_array($requestFiles)) {
            $requestFiles = [$requestFiles];
        }
        foreach($requestFiles as $file) {
            if($file->isValid()) {
                $clientFileName = str_replace(' ', '_', $file->getClientOriginalName());
                $date = date("Ymd-his");
                $name = $date."-".$clientFileName;
                $path[] = $file->storeAs($uploadPath, $name, $disk);
            
                $storeLocation = \array_merge($this->getStoreLocation($disk), ['uploadPath' => $uploadPath, 'diskName' => $disk ]);
                $fileModel =\App::make($fileModelName);

                $savedFiles[] = $fileModel->create([
                    'name' => $name,
                    'uploaded_by' => $userId,
                    'store_location' => $storeLocation
                ]);
            }

        }    
        

        return $savedFiles;
    }

    public function getStoreLocation($disk) {

        return config('filesystems.disks.'.$disk);
        // return json_encode(config('filesystems.disks.'.$disk));

    }

    public function uploadToDisk(Request $request, $disk)
    {
        return $this->upload($request, $disk);
    }

    public function genericUploadToDiskWithModel(Request $request, $disk, $modelName)
    {
        // $modelName = "App\Models\\".$modelName;
        return $this->upload($request, $disk, $modelName);
    }


    public function getFileFromDisk($diskName, $fileName)
    {
        $disk = $this->getStoreLocation($diskName);


        $filePath = $disk['root'].DIRECTORY_SEPARATOR.$fileName;
        try {
            $resp = response()->file($filePath);
        } catch (Exception $e) {
            abort(404);
        }

        return $resp;
    }

}
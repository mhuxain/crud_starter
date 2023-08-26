<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\File
 *
 * @mixin \Eloquent
 */
class File extends Model
{
    protected $guarded = [];
    protected $hasThumbNail = true;
    protected $thumbnailHeight = '232px';
    protected $thumbnailWidgth = '368px';
    protected $thumbnailUrlField = 'thumbnail_url';

    protected $appends = ['url'];
    public $connection = 'mysql';

    protected $casts = [
        'store_location' => 'json'
    ];

    public static function getDiskPath($fileName) {
        return storage_path('app').DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR.$fileName;
    }

    public function getUrlAttribute()
    {
        return '/api/files/'.$this->name ;
        // return asset('/api/files/'.$this->name);
    }


    public function download() {
        $filePath = $this->filePath();
        return \Storage::download($filePath);
    }


    public function deleteAndRemoveFromStroage() {

        $filePath = $this->filePath();
        $disk = $this->store_location['diskName'];
        $this->delete();
        return \Storage::disk($disk)->delete($filePath);

    }

    public function filePath() {
    
        $location = $this->store_location['uploadPath'];
        $name = $this->name;
        $filePath = empty($location) ? $location.DIRECTORY_SEPARATOR.$name : $name ;
        return $filePath;

    }
}

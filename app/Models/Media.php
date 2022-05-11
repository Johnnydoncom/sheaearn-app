<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    protected $appends = ['media_url','thumbnail_url'];

    public function getMediaUrlAttribute(){
        return $this->getUrl();
    }

    public function getThumbnailUrlAttribute(){
        return $this->getUrl('thumb');
    }
}

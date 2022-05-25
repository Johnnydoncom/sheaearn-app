<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Ads extends Model implements HasMedia
{
    use HasFactory, Sluggable, InteractsWithMedia;

    protected $fillable = ['title','slug','description','topic_id','user_id'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('featured_image')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(420)
                    ->height(220)
                    ->sharpen(10)
                    ->format('webp')
                    ->fit(Manipulations::FIT_CROP, 420,220)
                    ->nonQueued();

                $this->addMediaConversion('standard')
                    ->width(1600)
                    ->height(840)
                    ->sharpen(10)
                    ->format('webp')
                    ->fit(Manipulations::FIT_CROP, 1600,840)
                    ->nonQueued();
            });
    }


    public function getFeaturedImgUrlAttribute(){
        return $this->getFirstMediaUrl('featured_image');
    }

    public function getFeaturedImgThumbAttribute(){
        return $this->getFirstMediaUrl('featured_image', 'thumb');
    }

    public function getExcerptAttribute(){
        return Str::limit(strip_tags($this->description), 200, '...');
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAdsUrlAttribute(){
        return route('ads.show', $this->slug);
    }

    public function shares(){
        return $this->morphMany(Share::class, 'shareable');
    }
}

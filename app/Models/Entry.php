<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Entry extends Model implements HasMedia
{
    use HasFactory, Sluggable, InteractsWithMedia;

    protected $fillable = ['title','slug','description','topic_id','user_id', 'sticky'];

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

    // Clear entries cache upon modifying an entry
    protected static function boot()
    {
        parent::boot();

        static::saving(function() {
            Cache::forget('entries');
        });
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

    public function author(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    public function getEntryUrlAttribute(){
        return route('blog.show', $this->slug);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'entry_tags', 'entry_id', 'tag_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
    }

    public function bookmarks()
    {
        return $this->morphMany(Like::class, 'bookmarkable');
    }
}

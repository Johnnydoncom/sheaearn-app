<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Sluggable;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'parent_id', 'featured', 'menu'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'parent_id' =>  'integer',
        'featured'  =>  'boolean',
        'menu'      =>  'boolean'
    ];

//    protected $appends = ['featured_img_thumb'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('category')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(200)
                    ->height(200)
                    ->sharpen(10)
                    ->format('webp')
                    ->fit(Manipulations::FIT_CROP, 200,200)
                    ->nonQueued();
            });
    }

    public function scopeMedia($query)
    {
        return $query->has('media');
    }

    public function getFeaturedImgThumbAttribute(){
        return $this->getFirstMediaUrl('category', 'thumb');
    }

    // Newly added
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('products');
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id')->whereStatus(ProductStatus::PUBLISHED);
    }
}

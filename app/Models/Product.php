<?php

namespace App\Models;

use App\Observers\ProductObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasAttributes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, Sluggable, InteractsWithMedia, HasAttributes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'user_id',
        'brand_id',
        'regular_price',
        'sales_price',
        'featured',
        'product_attributes',
        'product_type',
        'features',
        'status'
    ];

    protected $casts = [
        'quantity'  =>  'integer',
        'brand_id'  =>  'integer',
        'status'    =>  'boolean',
        'featured'  =>  'boolean',
        'product_attributes' => 'array'
    ];

//    protected $with = ['stock'];

    public static function boot()
    {
        parent::boot();
        self::observe(new ProductObserver());
    }

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
                    ->width(300)
                    ->height(300)
                    ->sharpen(10)
                    ->format('webp')
                    ->fit(Manipulations::FIT_CROP, 300,300)
                    ->nonQueued();
            });

        $this->addMediaCollection('digital')
            ->singleFile();

        $this
            ->addMediaCollection('gallery')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(368)
                    ->height(232)
                    ->sharpen(10)
                    ->format('webp')
                    ->fit(Manipulations::FIT_CROP, 368,232);
            });
    }

    public function getFeaturedImgUrlAttribute(){
        return $this->getFirstMediaUrl('featured_image');
    }

    public function getFeaturedImgThumbAttribute(){
        return $this->getFirstMediaUrl('featured_image', 'thumb');
    }

    public function getGalleryImagesAttribute(){
        return $this->getMedia('gallery');
    }

    /**
     * Get the auctioneer that owns the item.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    /**
     * Get the brand that owns the item.
     */
    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function getExcerptAttribute(){
        return Str::limit(strip_tags($this->description), 200, '...');
    }

    public function getFormattedRegularPriceAttribute(){
        return app_money_format($this->regular_price);
    }
    public function getFormattedSalesPriceAttribute(){
        return app_money_format($this->sales_price);
    }

    public function getDiscountPercentAttribute(){
        return round((($this->regular_price - $this->sales_price) / $this->regular_price) * 100);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the reviews of the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(){
        return $this->reviews->count() ? ($this->reviews()->sum('rating')/$this->reviews()->count()) : 0;
    }
}

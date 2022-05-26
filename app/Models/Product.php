<?php

namespace App\Models;

use App\Exceptions\InvalidAttributeException;
use App\Exceptions\InvalidVariantException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Observers\ProductObserver;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        'stock_quantity',
        'featured',
        'product_attributes',
        'product_stock_id',
        'product_type',
        'type',
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

    public function stock()
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id');
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

//    public function getDiscountPercentAttribute(){
//        return round((($this->regular_price - $this->sales_price) / $this->regular_price) * 100);
//    }

    public function getDiscountPercentAttribute(){
        if($this->product_type == 'variable'){
            return 0;
        }else {
            return round((($this->regular_price - $this->sales_price) / $this->regular_price) * 100);
        }
    }

    public function getVariationPriceAttribute(){
        if($this->product_type == 'variable' && $this->stock()){
            return app_money_format($this->variations()->first()->stock->regular_price);
        }else {
            return 0;
        }
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

    public function shares(){
        return $this->morphMany(Share::class, 'shareable');
    }

    /**
     * Add Variant to the product
     *
     * @param array $variant
     */
    public function addVariant($variant)
    {
        DB::beginTransaction();

        try {
            if (in_array($this->sortAttributes($variant['variation']), $this->getVariants())) {
                throw new InvalidVariantException("Duplicate variation attributes!", 400);
            }

            foreach ($variant['variation'] as $item) {
                $attribute = $this->attributes()->whereHas('attribute', function ($q) use ($item){
                    $q->where('code', $item['option']);
                })->firstOrFail();
                $value = $attribute->values()->where('value', $item['value'])->firstOrFail();

                $dataArray = [
                    'product_attribute_id' => $attribute->id,
                    'sku' => $variant['sku'],
                    'price' => $variant['price'] ?? 0,
                    'cost' => $variant['cost'],
                    'quantity' => $variant['quantity']
                ];

                if(isset($variant['product_stock_id'])){
                    $dataArray['product_stock_id'] = $variant['product_stock_id'];
                }

                $this->variations()->updateOrCreate(
                    ['product_attribute_value_id' => $value->id],
                    $dataArray
                );
            }

            DB::commit();
        } catch (ModelNotFoundException $err) {
            DB::rollBack();

            throw new InvalidAttributeException($err->getMessage(), 404);

        } catch (\Throwable $err) {
            DB::rollBack();

            throw new InvalidVariantException($err->getMessage(), 400);
        }

        return $this;
    }

    /**
     * Get the variations
     *
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * Get the variations
     *
     */
    public function loadVariations()
    {
        return $this->variations()->get()->load(['attribute.attribute', 'option']);
    }


    protected function getVariants(): array
    {
        $variants = ProductVariation::where('product_id' , $this->id)->get();

        return $this->transformVariant($variants);
    }

    protected function sortAttributes($variant): array
    {
        return collect($variant)
            ->sortBy('option')
            ->map(function ($item) {
                return [
                    'option' => strtolower($item['option']),
                    'value' => strtolower($item['value'])
                ];
            })
            ->values()
            ->toArray();
    }


    protected function transformVariant($variants): array
    {
        return collect($variants)
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'sku' => $item->sku,
                    'attribute' => $item->attribute->attribute->name,
                    'option' => $item->option->value
                ];
            })
            ->keyBy('id')
            ->groupBy('attribute')
            ->map(function ($item) {
                return collect($item)
                    ->map(function ($var) {
                        return [
                            'option' => strtolower($var['attribute']),
                            'value' => strtolower($var['option'])
                        ];
                    })
                    ->sortBy('option')
                    ->values()
                    ->toArray();
            })
            ->all();
    }

    public function hasVariation(): bool
    {
        return !! $this->variations()->count();
    }

    public static function findBySku(string $sku)
    {
        return ProductVariation::where('sku', $sku)->firstOrFail();
    }

    public function scopeWhereSku(Builder $query, string $sku)
    {
        return $query->whereHas('variations', function ($q) use ($sku) {
            $q->where('sku', $sku);
        });
    }

    public function variant()
    {
        return $this->hasMany(ProductVariation::class, 'product_id');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}

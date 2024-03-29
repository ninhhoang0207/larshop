<?php

namespace App\Shop\ProductAttributes;

use App\Shop\AttributeValues\AttributeValue;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = [
        'quantity',
        'price',
        'sale_price',
        'default'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributesValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }

    public function getPriceAttribute()
    {
        return number_format($this->attributes['price'], 0);
    }

    public function getSalePriceAttribute()
    {
        return number_format($this->attributes['sale_price'], 0);
    }
}

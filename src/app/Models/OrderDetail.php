<?php

namespace App\Models;

use App\Casts\DateFormat;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
        'total_price',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'created_at' => DateFormat::class, // use . ':Y-m-d' to change format
            'updated_at' => DateFormat::class, // use . ':Y-m-d' to change format
        ];
    }

    /**
     * Get the product associated with the OrderDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}

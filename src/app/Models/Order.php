<?php

namespace App\Models;

use App\Casts\DateFormat;
use App\Casts\GenerateOrderNo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'orders';

    protected $fillable = [
        'order_no',
        'ordered_at',
        'customer_id',
        'total_items',
        'total_price',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            // 'order_no' => GenerateOrderNo::class, // use . ':Y-m-d' to change format
            'ordered_at' => DateFormat::class . ':d M Y', // use . ':Y-m-d' to change format
            'created_at' => DateFormat::class . ':d M Y H:i', // use . ':Y-m-d' to change format
            'updated_at' => DateFormat::class, // use . ':Y-m-d' to change format
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Order $model) {
            $count = $model->select('id')->where('ordered_at', $model->attributes['ordered_at'])->get()->count() + 1;
            $date = Carbon::parse($model->attributes['ordered_at'])->format('d/m/Y');
            $orderNo = "ODR/{$date}/{$count}";
            $model->attributes['order_no'] = $orderNo;
        });

        //static::updated(function (Order $model) {});

        //static::saved(function (Order $model) {});

        //static::deleted(function (Order $model) {});
    }

    /**
     * Get the customer associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    /**
     * Get all of the order details for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }
}

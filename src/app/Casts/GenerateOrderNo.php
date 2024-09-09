<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class GenerateOrderNo implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $count = $model->select('id')->where('ordered_at', $attributes['ordered_at'])->get()->count() + 1;
        $date = Carbon::parse($attributes['ordered_at'])->format('d/m/Y');
        $orderNo = "ODR/{$date}/{$count}";
        return $orderNo;
    }
}

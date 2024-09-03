<?php

namespace App\Models;

use App\Casts\DateFormat;
use App\Casts\StringToArray;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'categories',
        'description',
        'image',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'categories' => StringToArray::class,
            'created_at' => DateFormat::class, // use . ':Y-m-d' to change format
            'updated_at' => DateFormat::class, // use . ':Y-m-d' to change format
        ];
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => !empty ($value) ? env('APP_URL') . "/storage/{$value}" : '',
        );
    }
}

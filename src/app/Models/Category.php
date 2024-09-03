<?php

namespace App\Models;

use App\Casts\DateFormat;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [];

    protected function casts(): array
    {
        return [
            'created_at' => DateFormat::class, // use . ':Y-m-d' to change format
            'updated_at' => DateFormat::class, // use . ':Y-m-d' to change format
        ];
    }
}

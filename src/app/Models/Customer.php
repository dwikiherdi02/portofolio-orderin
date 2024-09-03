<?php

namespace App\Models;

use App\Casts\DateFormat;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'address',
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

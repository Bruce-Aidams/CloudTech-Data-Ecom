<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiProvider extends Model
{
    protected $fillable = ['name', 'base_url', 'api_key', 'secret_key', 'webhook_url', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}

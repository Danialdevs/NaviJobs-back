<?php

namespace App\Models;

// app/Models/Service.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'duration_minutes'
    ];
}

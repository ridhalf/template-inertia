<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $table = 'parkings';
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Parking::class,'category_id');
    }
}

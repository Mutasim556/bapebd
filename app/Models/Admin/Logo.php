<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $table = 'logos';

    protected $fillable = ['logo_position','logo_for','company_name','logo_type','logo_image','logo_image_dimention','logo_image_size'];
}

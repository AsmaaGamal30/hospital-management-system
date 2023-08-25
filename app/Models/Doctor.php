<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable = ['email', 'email_verified_at', 'password', 'phone', 'price', 'name', 'appointments'];
    protected $translatedAttributes = ['name', 'appointments'];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
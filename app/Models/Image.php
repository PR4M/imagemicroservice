<?php
/**
 * Created by PhpStorm.
 * User: Pramana
 * Date: 5/28/2018
 * Time: 11:26 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['uuid'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($image) {
            dump($image);
            die();
        });
    }
}
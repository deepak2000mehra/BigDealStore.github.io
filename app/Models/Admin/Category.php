<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}

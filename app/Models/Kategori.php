<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategori";
    protected $primaryKey = "id";
    public $incrementing = "true";
    // protected $keyType = "string";
    public $timestamps = "true";
    protected $fillable = [
        "nama",
    ];
}

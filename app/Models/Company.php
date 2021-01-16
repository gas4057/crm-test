<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'info',
    ];

    public $timestamps = true;

    public function client()
    {
        return $this->belongsToMany(Client::class);
    }
}

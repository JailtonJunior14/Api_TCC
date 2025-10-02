<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Foto extends Model
{
    protected $table = 'fotos';
    public $timestamps = true;
    public $fillable = ['foto', 'portfolio_id'];
    protected $appends = ['url'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->foto);
    }
}

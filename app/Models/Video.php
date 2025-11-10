<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    protected $table = 'videos';

    public $timestamps = true;

    public $fillable = ['video', 'portfolio_id'];

    protected $appends = ['url'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'portfolio_id');
    }

    public function getUrlAttribute()
    {
        return Storage::url($this->video);
    }
}

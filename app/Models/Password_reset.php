<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Password_reset extends Model
{
    use HasFactory;
    use Notifiable;

    public $timestamps = true;

    protected $table = 'password_code';

    protected $fillable = ['email', 'code', 'expires_at'];

    protected $dates = [
        'expires_at',
        'created_at',
        'updated_at',
    ];
}

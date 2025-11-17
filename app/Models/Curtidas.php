<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curtidas extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'perfil_id'];

        public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function perfilCurtiu()
    {
        return $this->belongsTo(User::class, 'perfil_id');
    }

    public static function jaCurtiu($usuarioId, $perfilId)
    {
        return self::where('user_id', $usuarioId)
                    ->where('perfil_id', $perfilId)
                    ->exists();
    }

    
}

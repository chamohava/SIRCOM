<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRol extends Model
{
    use HasFactory;

    protected $table = "t_menu_rol";

    protected $fillable = [
        'id',
        'rol_id',
        'menu_id',
    ];
}

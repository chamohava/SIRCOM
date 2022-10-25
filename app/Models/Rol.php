<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Menu;

class Rol extends Model
{
    use HasFactory;

    protected $table = "t_rol";

    protected $fillable = [
        'id',
        'nb_rol',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 't_menu_rol');
    }
}

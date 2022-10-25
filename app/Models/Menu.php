<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Rol;
use App\Models\MenuRol;

class Menu extends Model
{
    use HasFactory;

    protected $table = "t_menu";

    protected $fillable = [
        'id',
        'rol_id',
        'menu_id',
        'nb_menu',
        'subopcion',
        'padre',
        'orden',
        'id_estatu',
        'url',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 't_menu_rol');
    }

    public function optionsMenu()
    {
        return $this->whereHas('roles', function($query){
            $query->where('rol_id', auth()->user()->rol_id)->orderby('menu_id');
        })->where('id_estatu', true)
            ->orderby('menu_id')
            ->orderby('orden')
            ->get()
            ->toArray();
    }

    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['menu_id']) {
                $children = array_merge($children, [array_merge($line1, ['submenu' => $this->getChildren($data, $line1)])]);
            }
        }
        return $children;
    }

    public static function menus()
    {
        $menus = new Menu();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            if ($line['menu_id'] != 0)
                break;
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line)])];
            $menuAll = array_merge($menuAll, $item);
        }
        return $menuAll;
    }
}

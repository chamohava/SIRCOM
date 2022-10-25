<?php

namespace App\Http\Livewire\Usuarios;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Rol;

use Livewire\Component;

class Usuario extends Component
{
    use WithPagination;

    //Input search tabla usuario
    public $q;

    public $sortBy = 'id';
    public $sortAsc = true;

    public $id_usuario = null;
    public $cedula = null;
    public $name = null;
    public $email = null; 
    public $rol_id = null;

    public $isOpen = 0;
    public $confirmingEliminar = false;

    protected $queryString = [
        'q' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true]
    ];

    protected $rules = [
        'cedula' => 'required',
        'name' => 'required',
        'email' => 'required|email|unique:t_usuario',
        'rol_id' => 'required|numeric',
    ];

    protected $messages = [
        'cedula.required' => 'Número de cédula no puede estar vacio.',
        'name.required' => 'Nombre de usuario no puede estar vacio.',
        'email.required' => 'El correo electrónico no puede estar vacio.',
        'rol_id.required' => 'Debe seleccionar un perfil.',
        'email.email' => 'El correo electrónico no tiene formato valido.',
    ];

    public function render()
    {
        $usuarios = User::join('t_rol', 't_rol.id', '=', 't_usuario.rol_id')
                ->select('t_usuario.*', 't_rol.nb_rol')
                ->when( $this->q, function($query) {
                    return $query->where(function ($query) {
                        $query->where('name', 'like', '%'.$this->q . '%')
                        ->orWhere('cedula', 'like', '%'.$this->q . '%')
                        ->orWhere('email', 'like', '%'.$this->q . '%');
                    });
                })
                ->orderBy( $this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                ->simplePaginate(10);

        $roles = DB::table('t_rol')->whereIn('id', [1, 2, 3])->get();

        return view('livewire.usuarios.usuario', [
            'usuarios' => $usuarios,
            'roles' => $roles,
        ]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingq()
    {
        $this->resetPage();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->cedula = '';
        $this->email = '';
        $this->rol_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->id_usuario = $id;
        $this->cedula = $user->cedula;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->rol_id = $user->rol_id;
    
        $this->openModal();
    }

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        try {

            $validar_usu = DB::table('t_usuario')->where('cedula', $this->cedula)->get();

            //if(count($validar_usu) == 0){

                $this->validate();
                $usuario = new User;
                $usuario->updateOrCreate(['id' => $this->id_usuario], [
                    'cedula' => $this->cedula,
                    'password' => Hash::make($this->cedula),
                    'name' => $this->name,
                    'email' => $this->email,
                    'rol_id' => $this->rol_id
                ]);
                        
                session()->flash('message', $this->id_usuario ? 'Usuario actualizado exitosamente.' : 'Usuario registrado exitosamente.');
        
                $this->closeModal();
                $this->resetInputFields();

            //} else {
                //session()->flash('error', 'Usuario ya se encuentra registrado.');

                //$this->closeModal();
                //$this->resetInputFields();
            //}

        } catch (Exception $e) {
            session()->flash('error', $e->getCode() . ": " . $e->getMessage());
        }
    }

    public function confirmEliminar($id)
    {
        $this->confirmingEliminar = $id;
    }

    public function delete($id)
    {
        try {

            DB::table('t_usuario')->where('id', $id)->delete();

            session()->flash('message', 'Usuario eliminado exitosamente.');

            $this->confirmingHabilitar = false;

        } catch (Exception $e) {

            session()->flash('error', $e->getCode() . ": " . $e->getMessage());

            $this->confirmingHabilitar = false;

        }

    }
}

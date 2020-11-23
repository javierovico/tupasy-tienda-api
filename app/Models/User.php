<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property mixed id
 * @property mixed nombre
 * @property mixed apellido
 * @property mixed email
 * @property mixed email_verified_at
 * @property mixed password
 * @property mixed remember_token
 * @property mixed created_at
 * @property mixed updated_at
 * @property array roles
 */
class User extends Authenticatable{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Rol::class,'user_empresa_rol')
            ->using(UserEmpresaRol::class)
            ->withPivot([
                'empresa_id',
            ]);
    }

    public function rolesGenerales(){
        return $this->belongsToMany(Rol::class,'user_rol');
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class,'user_empresa_rol');
    }

    public static function constructorCrear() : self{
        return new self();
    }

    public function constructorCrearid($id) : self {
        $this->id = $id;
        return $this;
    }

    public function constructorCrearNombre($nombre) : self {
        $this->nombre = $nombre;
        return $this;
    }

    public function constructorCrearApellido($apellido) : self {
        $this->apellido = $apellido;
        return $this;
    }

    public function constructorCrearEmail($email) : self {
        $this->email = $email;
        return $this;
    }

    public function constructorCrearEmail_verified_at($email_verified_at) : self {
        $this->email_verified_at = $email_verified_at;
        return $this;
    }

    public function constructorCrearPassword($password) : self {
        $this->password = Hash::make($password);
        return $this;
    }

    public function constructorCrearRemember_token($remember_token) : self {
        $this->remember_token = $remember_token;
        return $this;
    }

    public function constructorCrearCreated_at($created_at) : self {
        $this->created_at = $created_at;
        return $this;
    }

    public function constructorCrearUpdated_at($updated_at) : self {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function constructorGuardar() : self{
        $this->save();
        return $this;
    }

    public function agregarPermiso(Empresa $empresa, Rol $rol){
        $this->roles()->attach($rol,['empresa_id' => $empresa->id]);
    }

    public function agregarPermisoGeneral(Rol $rol){
        $this->rolesGenerales()->attach($rol);
    }

    public function comprobarPermisoEmpresa(Permiso $permiso, $empresa){
        $empresaId = ($empresa instanceof Empresa)?$empresa->id:$empresa;
        return null !== $this->roles()
            ->wherePivot('empresa_id',$empresaId)
            ->whereHas('permisos',function(Builder $q) use ($permiso) {
                $q->where('permisos.id',$permiso->id);
            })
            ->first();
    }


    public function comprobarPermisoGlobal(Permiso $permiso){
        return null !== $this->rolesGenerales()
                ->whereHas('permisos',function(Builder $q) use ($permiso) {
                    $q->where('permisos.id',$permiso->id);
                })
                ->first();
    }
}

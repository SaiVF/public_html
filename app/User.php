<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'sexo',
        'empresa',
        'password',
        'ci',
        'telefono',
        'direccion',
        'provider',
        'provider_id',
        'role',
        'image',
        'logo',
        'ubicacion',
        'departamento',
        'ciudad',
        'terminos',
        'verify',
        'descripcion_empresa',
        'url',
        'trato_autoridad',
        'nombre_autoridad',
        'trato_nexo',
        'nombre_nexo',
        'telefono_nexo',
        'correo_nexo',
        'direccion_nexo',
        'dias_atencion',
        'horario_atencion',
        'rubro_empresa',
        'tipo_oportunidad'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->attributes['role'] === 2;
    }
    
    public function isModerador()
    {
        return $this->attributes['role'] === 4;
    }

    public function isEmpresa()
    {
      return $this->attributes['role'] === 3;
    }
    
    public function hasSolicitud()
    {
        $user = DB::table('solicitud')->where('user_id', $this->attributes['id'])->first();
      return $user ? true : false;
    }
    
    public function theRole()
    {
        return DB::table('roles')->where('id', $this->attributes['role'])->first();
    }
    

    public function theImage()
    {
        return url($this->attributes['image'] ? 'uploads/'.$this->attributes['image'] :'assets/img/user.png');
    }
    public function latLng()
    {
      return explode(',', $this->ubicacion);
    }
    public function lat()
    {
      return trim($this->latlng()[0]);
    }
    public function lng()
    {
      return trim($this->latlng()[1]);
    }
    public function roles()
    {
      return $this->hasOne('App\Role', 'id', 'role');
    }
    public function departamentos()
    {
      return $this->belongsTo('App\Departamento', 'departamento', 'id');
    }
    
    public function departamentoUser()
    {
      return DB::table('departamentos')->where('id', $this->attributes['departamento'])->first();
    }
    public function authorizeRoles($roles)
    {
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || 
                 abort(401);
      }
      return $this->hasRole($roles) || 
             abort(401);
    }
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }
    public function hasRole($role)
    {
      return null !== $this->roles()->where('name', $role)->first();
    }
}

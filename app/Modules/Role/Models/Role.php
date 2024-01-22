<?php

namespace App\Modules\Role\Models;

use App\Models\User;
use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'roles';
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class);
    }


    public static function relations($getOne = false){
        return $getOne 
            ? [
                'users',
                'users.collaborateur',
            ]
            : [
                'users',
            ];
            
    }
}

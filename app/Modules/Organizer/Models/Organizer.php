<?php

namespace App\Modules\Organizer\Models;

use App\Models\User;
use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Event\Models\Event;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Location\Models\Country;
use App\Modules\Tournament\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizer extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'organizers';
    protected $guarded = ['id'];

    public function user(){
        return $this->morphOne(User::class, 'userable');
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function events(){
        return $this->hasMany(Event::class);
    }

    public function tournaments(){
        return $this->hasMany(Tournament::class);
    }
}

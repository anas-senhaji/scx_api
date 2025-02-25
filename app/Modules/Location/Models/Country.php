<?php

namespace App\Modules\Location\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Event\Models\Event;
use App\Modules\Location\Models\City;
use App\Modules\Player\Models\Player;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Organizer\Models\Organizer;
use App\Modules\Tournament\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'countries';
    protected $guarded = ['id'];

    public function cities(){
        return $this->hasMany(City::class);
    }
    public function players(){
        return $this->hasMany(Player::class);
    }
    public function organizers(){
        return $this->hasMany(Organizer::class);
    }
    public function events(){
        return $this->hasMany(Event::class);
    }
    public function countries(){
        return $this->hasMany(Tournament::class);
    }
}

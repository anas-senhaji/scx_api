<?php

namespace App\Modules\Player\Models;

use App\Models\User;
use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Game\Models\Game;
use App\Modules\Team\Models\Team;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Location\Models\Country;
use App\Modules\Tournament\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'players';
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function user(){
        return $this->morphOne(User::class, 'userable');
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function tournaments(){
        return $this->belongsToMany(Tournament::class, 'tournament_player', 'player_id', 'tournament_id');
    }

    public function teams(){
        return $this->belongsToMany(Team::class, 'team_player', 'player_id', 'team_id');
    }

    public function homeGames(){
        return $this->morphMany(Game::class, 'home');
    }

    public function visitingGames(){
        return $this->morphMany(Game::class, 'visiting');
    }

    public static function relations($getOne = false){
        return $getOne 
            ? []
            : [];
            
    }
}

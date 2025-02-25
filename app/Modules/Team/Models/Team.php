<?php

namespace App\Modules\Team\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Player\Models\Player;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Tournament\Models\Tournament;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'teams';
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];

    public function players(){
        return $this->belongsToMany(Player::class, 'team_player', 'team_id', 'player_id');
    }

    public function tournaments(){
        return $this->belongsToMany(Tournament::class, 'tournament_team', 'team_id', 'tournament_id');
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

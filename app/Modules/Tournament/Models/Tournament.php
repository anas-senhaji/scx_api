<?php

namespace App\Modules\Tournament\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Team\Models\Team;
use App\Modules\Event\Models\Event;
use App\Modules\Player\Models\Player;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Location\Models\Country;
use App\Modules\Organizer\Models\Organizer;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Tournament\Models\TournamentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'tournaments';
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];
    protected $casts = [
        'ranking_points' => 'array',
        'prize_money' => 'array'
    ];


    public function tournamentType(){
        return $this->belongsTo(TournamentType::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function discipline(){
        return $this->belongsTo(Discipline::class);
    }

    public function organizer(){
        return $this->belongsTo(Organizer::class);
    }

    public function players(){
        return $this->belongsToMany(Player::class, 'tournament_player', 'tournament_id', 'player_id');
    }

    public function teams(){
        return $this->belongsToMany(Team::class, 'tournament_team', 'tournament_id', 'team_id');
    }

    public static function relations($getOne = false){
        return $getOne 
            ? ['tournamentType', 'discipline', 'event', 'event.discipline', 'event.organizer', 'event.country', 'country', 'organizer']
            : ['tournamentType', 'discipline', 'event', 'event.discipline', 'event.organizer', 'event.country', 'country', 'organizer'];
            
    }
}

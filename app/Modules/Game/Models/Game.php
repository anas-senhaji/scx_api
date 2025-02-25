<?php

namespace App\Modules\Game\Models;

use App\Traits\HasUuid;
use App\Traits\HasHorodatage;
use App\Modules\Team\Models\Team;
use App\Modules\Player\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory, HasUuid, HasHorodatage;

    protected $table = 'games';
    protected $guarded = ['id'];
    protected $hidden = ['pivot'];
    protected $appends = ['winner', 'losing'];

    public function home(){
        return $this->morphTo();
    }

    public function visiting(){
        return $this->morphTo();
    }

    public function getWinnerAttribute(){
        // Check for forfeit situations first
        if ($this->home_score == 'FF') {
            return $this->visiting;
        } elseif ($this->visiting_score == 'FF') {
            return $this->home;
        }

        // Compare scores to determine the winner
        if($this->is_finished){
            if ($this->home_score > $this->visiting_score) {
                return $this->home;
            } elseif ($this->home_score < $this->visiting_score) {
                return $this->visiting;
            }
        }

        // Return null if it's a draw or scores are not set
        return null;
    }

    public function getLosingAttribute(){
        // Check for forfeit situations first
        if ($this->home_score == 'FF') {
            return $this->home;
        } elseif ($this->visiting_score == 'FF') {
            return $this->visiting;
        }

        // Compare scores to determine the winner
        if($this->is_finished){
            if ($this->home_score > $this->visiting_score) {
                return $this->visiting;
            } elseif ($this->home_score < $this->visiting_score) {
                return $this->home;
            }
        }

        // Return null if it's a draw or scores are not set
        return null;
    }


    public static function relations($getOne = false){
        return $getOne 
            ? ['home', 'visiting']
            : ['home', 'visiting'];
            
    }
}

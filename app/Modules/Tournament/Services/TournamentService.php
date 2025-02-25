<?php

namespace App\Modules\Tournament\Services;
use Log;
use UploadHelper;
use App\Traits\CustomResponse;
use App\Modules\Game\Models\Game;
use App\Modules\Team\Models\Team;
use Illuminate\Support\Facades\DB;
use App\Modules\Player\Models\Player;
use Illuminate\Support\Facades\Validator;
use App\Modules\Game\Services\GameService;
use App\Modules\Tournament\Models\Tournament;
use App\Modules\Game\Http\Resources\GameResource;
use App\Modules\Tournament\Http\Resources\TournamentResource;
use App\Modules\Tournament\Http\Resources\TournamentCollection;

class TournamentService
{
    use CustomResponse;

    protected $gameService;

    public function __construct(GameService $gameService){
        $this->gameService = $gameService;
    }
    
    // This function is for (Update & Create)
    public function create($data, $tournament = null) {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            
                // Update or Create a new Tournament model instance with the validated request data
                if($tournament){
                    $tournament->update($data);
                    $created_tournament = $tournament->fresh();
                }else{
                    $created_tournament = Tournament::create($data);
                }

                // Check if request has the picture
                if(isset($data['picture'])){
                    // Upload the photo file using the UploadHelper and get the filename
                    $filename = UploadHelper::uploadFiles($data['picture'], 'tournaments/photos/'.$created_tournament->uuid)[0];
                    // Set the photo filename on the Tournament model and save it
                    $created_tournament->picture = $filename;
                    $created_tournament->save();
                }

            // Commit the database transaction
            DB::commit();
            // Return a JSON response indicating success and the created tournament object
            return $this->jsonResponse(true, 200, 200, new TournamentResource($created_tournament));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }
        
    }

    public function delete($tournament){
        $tournament->delete();
        return $this->jsonResponse(true, 200, 200);
    }

    public function getOne($tournament){
        // Get the relationships for the Tournament model
        $relations = $tournament->relations(true);
        // Retrieve the Tournament model and related models using the specified relations
        $tournament = Tournament::with($relations)->find($tournament->id);
        // Return a JSON response with the retrieved Tournament model or an empty array if it was not found
        return $this->jsonResponse(true, 200, 200, new TournamentResource($tournament) ?: []);
    }

    public function getAll($request, $perPage = 10){
        // Get the relationships for the Tournament model
        $relations = Tournament::relations();
        // Build a query with the Tournament model and its relationships
        $query = Tournament::with($relations);
        // If pagination is requested, return a paginated JSON response
        if(isset($request->paginate)){
            // Paginate the query results
            return $this->jsonResponse(true, 200, 200, new TournamentCollection($query->paginate($perPage)));
        }
        // Fetch all the results
        return $this->jsonResponse(true, 200, 200, new TournamentCollection($query->get()));
    }

    public function assignToTournament($data){
        // Find the tournament by ID
        $tournament = Tournament::find($data['tournament_id']);

        // If the tournament does not exist, return an error response
        if (!$tournament) {
            return $this->jsonResponse(true, 404, 404, [], 'Tournoi introuvable');
        }

        // Retrieve tournament type details
        $tournamentTypeGender = $tournament->tournamentType->gender;
        $tournamentNbrPlayer = $tournament->tournamentType->nbr_player;

        // Handle single player assignment
        if ($tournamentNbrPlayer == 1) {

            $playerIds = []; // Initialize an array to store player IDs
            foreach ($data['players'] as $player) {
                $player = Player::find($player);
                // Return an error if a player is not found
                if(!$player){
                    return $this->jsonResponse(true, 404, 404, [], 'Joueur non trouvé');
                }
                // Check if player's gender matches the tournament type
                if($player->gender != $tournamentTypeGender){
                    return $this->jsonResponse(true, 400, 400, $player, 'Le joueur a un sexe différent');
                }
                $playerIds[] = $player->id; // Add player ID to the array
            }
            // Filter out null values
            $playerIds = array_filter($playerIds);

            // Assign the tournament's players
            $tournament->players()->detach($playerIds);
            $tournament->players()->attach($playerIds);
            $tournament->load('players'); // Eager load the players relationship

        // Handle team assignment
        }elseif($tournamentNbrPlayer == 2){
            
            $teamIds = []; // Initialize an array to store team IDs
            foreach ($data['teams'] as $team) {
                $players = Player::whereIn('id', [$team['player1'], $team['player2']])->get();

                // Various checks for players' gender and team rules
                $playersHaveSameGender = $players[0]->gender === $players[1]->gender;
                $genderMismatchInNonMixte = $players[0]->gender !== $players[1]->gender && $tournamentTypeGender !== 'mixte';
                $genderMismatchWithTournament = ($players[0]->gender !== $tournamentTypeGender || $players[1]->gender !== $tournamentTypeGender) && $tournamentTypeGender !== 'mixte';

                if ($playersHaveSameGender && $tournamentTypeGender === 'mixte') {
                    return $this->jsonResponse(true, 400, 400, $players, 'Les joueurs ne doivent pas être du même sexe');
                } elseif ($genderMismatchInNonMixte) {
                    return $this->jsonResponse(true, 400, 400, $players, 'Les joueurs ont un sexe différent');
                } elseif ($genderMismatchWithTournament) {
                    return $this->jsonResponse(true, 400, 400, $players, "L'un des joueurs a un sexe différent");
                }
                
                // Check if team name already exists
                $teamChecker = Team::where('name', $team['name'])->first();
                if($teamChecker){
                    return $this->jsonResponse(true, 400, 400, [], "Nom de l'équipe est indisponible");
                }
                // Create a new team and attach players to it
                $createdTeam = Team::create([
                    'name' => $team['name']
                ]);
                $createdTeam->players()->attach([$team['player1'], $team['player2']]);
                $teamIds[] = $createdTeam->id;
            }

            // Assign the tournament's teams
            $tournament->teams()->detach($createdTeam);
            $tournament->teams()->attach($createdTeam);
            $tournament->load('teams.players');

        }

        // Return the updated tournament details
        return $this->jsonResponse(true, 200, 200, new TournamentResource($tournament));
    }

    public function tournamentDraw($tournament){
        // Retrieve tournament details
        $tournamentNbrPlayer = $tournament->tournamentType->nbr_player;
        // Determine whether to use Players or Teams
        $participants = $tournamentNbrPlayer == 1 ? $tournament->players : $tournament->teams;
        $participants = $participants->take(100);
        // Retrieve number of participants
        $numberOfParticipants = count($participants);
        // Find the next power of two for the number of participants
        $nextPowerOfTwo = $this->findNextPowerOfTwo($numberOfParticipants);
        // Calculate the number of byes
        $byesNeeded = $nextPowerOfTwo - $numberOfParticipants;
        // Shuffle participants
        $shuffledParticipants = $participants->shuffle();
        //Initialize flowchart and add needed byes to flowchart
        $flowChart = $this->addNeededByes($byesNeeded, $nextPowerOfTwo);
        // Create draw and matches
        $flowChart = $this->createDraw($flowChart->shuffle(), $shuffledParticipants, $tournament);
        
        return $this->jsonResponse(true, 200, 200, $flowChart);
        
    }

    private function createDraw($shuffledFlowChart, $shuffledParticipants, $tournament) {
        $gameNumber = 1;
        // Assuming $this->createGame() automatically increments $gameNumber
        $games = $shuffledFlowChart->map(function ($item) use ($shuffledParticipants, $tournament, &$gameNumber) {
            return $this->createGame($item, $shuffledParticipants, $tournament, $gameNumber);
        });

        $draw = ['last-'.$games->count() * 2 => $games];
        $draw = $this->createFutureGames($draw, 'last-'.$games->count() * 2, $tournament, $gameNumber);
        return collect($draw);
    }
    
    private function createFutureGames($draw, $key, $tournament, &$gameNumber) {
        $newRound = collect();
        $futureGames = collect($draw);
        $games = $draw[$key];
        while($games->count() > 1){
            for ($i = 0; $i < $games->count(); $i += 2) {
                // Create a game for each pair of games from the previous round
                if (isset($games[$i + 1])) { // Ensure there is a pair
                    $game = $this->createFutureGame($games, $games[$i], $games[$i + 1], $tournament, $gameNumber);
                    $newRound->push($game);
                } else {
                    // Handle odd number of games if needed
                    $newRound->push($games[$i]);
                }
            }
            $futureGames = $futureGames->merge(['last-'.$newRound->count() * 2 => $newRound]);
            $games = $newRound;
            $newRound = collect();
            Log::info($games->count().', ');
        }
        
        
        return $futureGames;
    }
    
    private function createFutureGame($games, $homeGame, $visitingGame, $tournament, &$gameNumber) {
        // Create a new game with references to $homeGame and $visitingGame for determining winners
        // This is a placeholder function, adjust according to your application's logic and database schema
    
        $game = new Game;
        $game->tournament_id = $tournament->id;
        $game->home_score = 0;
        $game->visiting_score = 0;
        $game->home_previous_game_id = $homeGame->id; // Assume these fields exist and are for linking
        $game->visiting_previous_game_id = $visitingGame->id;
        if(!empty($homeGame->winner)){
            if($games->search($homeGame) % 2 == 0){
                $game->home()->associate($homeGame->winner);
            }else{
                $game->visiting()->associate($homeGame->winner);
            }
        }
        if(!empty($visitingGame->winner)){
            if($games->search($visitingGame) % 2 == 0){
                $game->home()->associate($visitingGame->winner);
            }else{
                $game->visiting()->associate($visitingGame->winner);
            }
        }
        $game->game_number = $gameNumber++;
        // Other necessary setup
        $game->save();
    
        return new GameResource($game); // Assuming you return a resource or the game instance itself
    }
    

    private function createGame($item, $shuffledParticipants, $tournament, &$gameNumber){
         // Create match
         $game = new Game;
         $game->tournament_id = $tournament->id;
         $game->home_score = 'FF';
         $game->visiting_score = 'FF';
         $game->game_number = $gameNumber++;

         if ($item['home'] === null) {
             $game->home_score = 0;
             $game->home()->associate($shuffledParticipants->shift());
         }
         if ($item['visiting'] === null) {
             $game->visiting_score = 0;
             $game->visiting()->associate($shuffledParticipants->shift());
         }
         $game->is_finished = ($item['home'] == 'BYE' || $item['visiting'] == 'BYE') ? true : false;
         $game->save();
         return new GameResource($game);
    }

    private function addNeededByes($byesNeeded, $nextPowerOfTwo){
        $flowChart = collect();
        // Add needed byes to flowchart
        for($i = 0; $i < $nextPowerOfTwo / 2; $i++){
            $count = $flowChart->filter(function ($item) {
                return $item['visiting'] === 'BYE';
            })->count();
            if($count == $byesNeeded){
                $flowChart->push(['home' => null, 'visiting' => null]);
            }else{
                $flowChart->push(['home' => null, 'visiting' => 'BYE']);
            }
        }
        return $flowChart;
    }

    private function findNextPowerOfTwo($number){
        $power = 0;
        while (pow(2, $power) < $number) {
            $power++;
        }
        return pow(2, $power);
    }

    
}
<?php

namespace App\Modules\Authentification\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\Player\Models\Player;
use App\Modules\Organizer\Models\Organizer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Log;

class AuthentificationController extends Controller
{
    use CustomResponse;

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'firstname' => 'required_if:type,Player|string',
            'lastname' => 'required_if:type,Player|string',
            'name' => 'required_if:type,Organizer|string',
            'birth_date' => 'date',
            'gender' => 'required_if:type,Player|string',
            'country_id' => 'required',
            'nickname' => 'string',
            'type' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        // Check if the request has a validator property and if it has failed
        if (isset($validator) && $validator->fails())
            return $this->jsonResponse(false, 400, 400, $validator->messages(), 'Erreur Bad Request');

        try {
            // Begin a database transaction
            DB::beginTransaction();

            $data = $validator->validated();
        
            $profil = ($data['type'] == 'Player') ? new Player() : new Organizer();
            $profil->fill($data);
            $profil->save();

            // Check if request has the picture
            if($request->hasFile('picture')){
                // Upload the photo file using the UploadHelper and get the filename
                $filename = UploadHelper::uploadFiles($request->file('picture'), 'profil/photos/'.$profil->uuid)[0];
                // Set the photo filename on the Profil model and save it
                $profil->picture = $filename;
                $profil->save();
            }
            
            $user = User::create([
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $user->userable()->associate($profil);
            $user->save();
            
            // Commit the database transaction
            DB::commit();
            
            return $this->jsonResponse(true, 200, 200, $profil->with('user')->find($profil->id), 'Inscris avec succès');

        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonResponse(false, 500, 500, $e->getMessage());
        }

    }

    public function login(Request $request){
        // Validate the user's credentials
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return $this->jsonResponse(false, 401, 401, [], 'les informations d\'identification invalides');
            // return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
        // Generate a JWT token
        $token = JWTAuth::fromUser(Auth::user());
        
        // Return the token to the user
        return $this->jsonResponse(true, 200, 200, [
            'autorisation' => [
                'token' => $token,
            ]
        ], 'Connecté avec succès');
        // return response()->json(['token' => $token]);
    }
    public function me(Request $request)
    {
        $relations = [
            'userable'
        ];
        $user = User::with($relations)->find(Auth::id());
        return $this->jsonResponse(true, 200, 200, $user);
    }
    public function logout(Request $request){
        // Invalidate the user's JWT token
        JWTAuth::invalidate($request->bearerToken());
        
        // Return a response indicating that the user has been logged out
        return $this->jsonResponse(true, 200, 200, [], 'Déconnecté avec succès');
    }
}

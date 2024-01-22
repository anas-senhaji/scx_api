<?php

namespace App\Modules\Authentification\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthentificationController extends Controller
{
    use CustomResponse;

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
            'role',
            'collaborateur',
            'collaborateur.groupe',
            'collaborateur.departement',
            'collaborateur.contrat',
            'collaborateur.primes',
            'collaborateur.salaires',
            'collaborateur.salaireActuel',
            'collaborateur.superviseur',
            'collaborateur.subordonnes',
            'collaborateur.subordonnes',
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

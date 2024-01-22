<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\Auth;

class WorkflowValidationMiddleware
{
    use CustomResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $type)
    {
        // Get the authenticated user
        $currentUser = Auth::user();
        // If the user has 'Administrateur' role, allow them to continue
        if($currentUser->role->nom == 'Administrateur'){
            return $next($request);
        }
        // Get the current model from the request, and its workflow and validation level
        $currentModel = $request->route(strtolower($type));
        $workflow = $currentModel->workflow;
        $niveauValide = $currentModel->niveau_valide;
        // Get the collaborator and their supervisor from the current model
        $collaborateur = $currentModel->collaborateur;
        $collaborateurSuperviseur = $collaborateur->superviseur;
        // Calculate the next validation level
        $niveauSuivant = (int)$niveauValide + 1;

        // Find the next step in the workflow based on the next validation level
        $nextStep = collect($workflow)->first(function ($step) use ($niveauSuivant) {
            return $step['niveau'] === $niveauSuivant;
        });

        // If there's no next step in the workflow, allow the user to continue
        if(!$nextStep){
            return $next($request);
        }

        // Check if the user is authorized to perform the next step
        $authorized = false;

        if($nextStep['est_superviseur']){
            // If the next step requires a supervisor, check if the user is the collaborator's supervisor
            $authorized = $currentUser->collaborateur->id === $collaborateurSuperviseur->id;
        }elseif ($nextStep['role_id']){
            // If the next step requires a specific role, check if the user has that role
            $authorized = $currentUser->role->id === $nextStep['role_id'];
        }else{
            // If the next step requires a specific user, check if the user is that user
            $authorized = $currentUser->id === $nextStep['user_id'];
        }

        // If the user is not authorized, return an error response
        if(!$authorized){
            return $this->jsonResponse(false, 401, 401, 'Non autorisé');
        }

        // If the user is authorized, allow them to continue
        return $next($request);
    }

}

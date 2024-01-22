<?php

namespace App\Modules\Contrat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class ContratController extends Controller
{

    public function get(){
        // Charger le modèle de contrat
        $template = new TemplateProcessor(public_path('storage/templates/contrat/contrat.docx'));
        $variables = $template->getVariables();
        dd($variables);

        // Afficher les variables de modèle
        foreach ($variables as $variable) {
            echo $variable . "\n";
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Modules\Prime\Models\Prime;
use App\Modules\Collaborateur\Models\Collaborateur;

class CollaborateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collaborateurs = [
            [
                'role' => 3,
                'primes' => array('transport' => 500, 'panier' => 450),
                'data' => [
                    'nom' => 'SENHAJI',
                    'prenom' => 'Anas',
                    'adresse_personnelle' => 'Roches noires',
                    'email' => 'anas@senhaji.com',
                    'telephone' => '0600000000', 
                    'identification_nationale' => 'HH7070',
                    'numero_securite_sociale' => '1311080713',
                    'rib' => '123456789123',
                    'date_naissance' => '1993-08-13',
                    'situation' => 'Marié',
                    'nombre_enfants' => '1',
                    'nationalite' => 'Marocaine',
                    'niveau_etudes' => 'Bac + 5',
                    'diplomes' => array('technicien spécialisé en développement informatique', 'ingénieur informatique'),
                    'experiences_antierieurs' => array('Globres', 'Devcorp'),
                    'langues' => array(
                        (object) ['titre' => 'Français', 'niveau' => 4],
                        (object) ['titre' => 'Anglais', 'niveau' => 3],
                    ),
                    'competences' => array('HTML', 'CSS3', 'JavaScript', 'Angular', 'Laravel', 'Postgres', 'MongoDb'),
                    'avantages' => array('CNSS', 'CIRM'),
                    'salaire_de_base' => '5000',
                    'nombre_jours_conge' => '3',
                    'statut' => true,
                    'fonction' => 'Chef de projet',
                    'matricule' => '01312',
                    'commentaire' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie',
                    'groupe_id' => '1',
                    'departement_id' => '1',
                ]
            ],
            [
                'role' => 3,
                'primes' => array('transport' => 500, 'panier' => 450),
                'data' => [
                    'nom' => 'ESSAOUDI',
                    'prenom' => 'said',
                    'adresse_personnelle' => 'Sidi moumen',
                    'email' => 'said@essaoudi.com',
                    'telephone' => '0600000000', 
                    'identification_nationale' => 'HH7070',
                    'numero_securite_sociale' => '1311080713',
                    'rib' => '123456789123',
                    'date_naissance' => '1993-08-13',
                    'situation' => 'Célibataire',
                    'nombre_enfants' => '0',
                    'nationalite' => 'Marocaine',
                    'niveau_etudes' => 'Bac + 5',
                    'diplomes' => array('technicien spécialisé en développement informatique', 'ingénieur informatique'),
                    'experiences_antierieurs' => array('Globres', 'Devcorp'),
                    'langues' => array(
                        (object) ['titre' => 'Français', 'niveau' => 3],
                        (object) ['titre' => 'Anglais', 'niveau' => 2],
                    ),
                    'competences' => array('HTML', 'CSS3', 'JavaScript', 'Angular', 'Bootstrap'),
                    'avantages' => array('CNSS', 'CIRM'),
                    'salaire_de_base' => '5000',
                    'nombre_jours_conge' => '3',
                    'statut' => true,
                    'fonction' => 'Développeur frontend',
                    'matricule' => '01312',
                    'commentaire' => 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie',
                    'groupe_id' => '1',
                    'departement_id' => '1',
                    'superviseur_id' => '1',
                ]
            ]
        ];
        foreach ($collaborateurs as $collaborateur) {
           $c = Collaborateur::create($collaborateur['data']);
            foreach ($collaborateur['primes'] as $key => $value) {
                $prime = new Prime();
                $prime->fill(['nom' => $key, 'montant' => $value]);
                $prime->collaborateur()->associate($c);
                $prime->save();
            }
           $user = User::create([
            'email' => $c->email,
            'password' => '123456',
            'collaborateur_id' => $c->id,
            'role_id' => $collaborateur['role']
           ]);
        }
    }
}

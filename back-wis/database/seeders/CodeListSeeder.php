<?php

namespace Database\Seeders;

use App\Models\CodeList;
use Illuminate\Database\Seeder;

class CodeListSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Rôles Utilisateur
            ['type' => 'RoleUtilisateur', 'value' => 'candidat', 'description' => 'Candidat à la recherche d\'emploi'],
            ['type' => 'RoleUtilisateur', 'value' => 'employeur', 'description' => 'Employeur publiant des offres'],
            ['type' => 'RoleUtilisateur', 'value' => 'admin', 'description' => 'Administrateur de la plateforme'],

            // Types de Poste
            ['type' => 'TypePoste', 'value' => 'cdi', 'description' => 'Contrat à Durée Indéterminée'],
            ['type' => 'TypePoste', 'value' => 'cdd', 'description' => 'Contrat à Durée Déterminée'],
            ['type' => 'TypePoste', 'value' => 'stage', 'description' => 'Stage'],
            ['type' => 'TypePoste', 'value' => 'freelance', 'description' => 'Mission Freelance'],

            // Statuts de Candidature
            ['type' => 'Statut', 'value' => 'en_attente', 'description' => 'En attente de traitement'],
            ['type' => 'Statut', 'value' => 'acceptee', 'description' => 'Candidature acceptée'],
            ['type' => 'Statut', 'value' => 'refusee', 'description' => 'Candidature refusée'],

            // Niveaux d'Expérience
            ['type' => 'NiveauExperience', 'value' => 'junior', 'description' => '0-2 ans d\'expérience'],
            ['type' => 'NiveauExperience', 'value' => 'intermediaire', 'description' => '2-5 ans d\'expérience'],
            ['type' => 'NiveauExperience', 'value' => 'senior', 'description' => '5+ ans d\'expérience'],

            // Statuts de Paiement
            ['type' => 'StatutPaiement', 'value' => 'en_attente', 'description' => 'Paiement en attente'],
            ['type' => 'StatutPaiement', 'value' => 'reussi', 'description' => 'Paiement réussi'],
            ['type' => 'StatutPaiement', 'value' => 'echoue', 'description' => 'Paiement échoué'],

            // Types d'Offre
            ['type' => 'OffreType', 'value' => 'basic', 'description' => 'Offre Basique'],
            ['type' => 'OffreType', 'value' => 'premium', 'description' => 'Offre Premium'],
            ['type' => 'OffreType', 'value' => 'entreprise', 'description' => 'Offre Entreprise'],

            // Langues
            ['type' => 'Langue', 'value' => 'francais', 'description' => 'Français'],
            ['type' => 'Langue', 'value' => 'anglais', 'description' => 'Anglais'],
            ['type' => 'Langue', 'value' => 'espagnol', 'description' => 'Espagnol'],
        ];

        foreach ($data as $item) {
            CodeList::create($item);
        }
    }
}

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
            ['type' => 'UserRole', 'value' => 'user', 'description' => 'Candidat à la recherche d\'emploi'],
            ['type' => 'UserRole', 'value' => 'recruiter', 'description' => 'Employeur publiant des offres'],
            ['type' => 'UserRole', 'value' => 'admin', 'description' => 'Administrateur de la plateforme'],

            // Types de Poste
            ['type' => 'JobType', 'value' => 'cdi', 'description' => 'Contrat à Durée Indéterminée'],
            ['type' => 'JobType', 'value' => 'cdd', 'description' => 'Contrat à Durée Déterminée'],
            ['type' => 'JobType', 'value' => 'stage', 'description' => 'Stage'],
            ['type' => 'JobType', 'value' => 'freelance', 'description' => 'Mission Freelance'],
            ['type' => 'JobType', 'value' => 'alternance', 'description' => 'Alternance'],
            ['type' => 'JobType', 'value' => 'apprentissage', 'description' => 'Apprentissage'],
            ['type' => 'JobType', 'value' => 'vocation', 'description' => 'Vocation Professionnelle'],

            // Statuts de Candidature
            ['type' => 'Status', 'value' => 'pending', 'description' => 'En attente de traitement'],
            ['type' => 'Status', 'value' => 'accepted', 'description' => 'Candidature acceptée'],
            ['type' => 'Status', 'value' => 'rejected', 'description' => 'Candidature refusée'],

            // Niveaux d'Expérience
            ['type' => 'ExperienceLevel', 'value' => 'debutant', 'description' => '0-1 ans d\'expérience'],
            ['type' => 'ExperienceLevel', 'value' => 'junior', 'description' => '1-2 ans d\'expérience'],
            ['type' => 'ExperienceLevel', 'value' => 'confirme', 'description' => '2-3 ans d\'expérience'],
            ['type' => 'ExperienceLevel', 'value' => 'senior', 'description' => '3-5 ans d\'expérience'],
            ['type' => 'ExperienceLevel', 'value' => 'expert', 'description' => '5+ ans d\'expérience'],

            // Statuts de Paiement
            ['type' => 'PaymentStatus', 'value' => 'pending', 'description' => 'Paiement en attente'],
            ['type' => 'PaymentStatus', 'value' => 'accepted', 'description' => 'Paiement réussi'],
            ['type' => 'PaymentStatus', 'value' => 'rejected', 'description' => 'Paiement refusé'],
            ['type' => 'PaymentStatus', 'value' => 'refunded', 'description' => 'Paiement remboursé'],

            // Types d'Offre
            ['type' => 'OfferType', 'value' => 'basic', 'description' => 'Offre Basique'],
            ['type' => 'OfferType', 'value' => 'premium', 'description' => 'Offre Premium'],
            ['type' => 'OfferType', 'value' => 'unlimited', 'description' => 'Offre Entreprise'],

            // Locations - Régions du Sénégal
            ['type' => 'Location', 'value' => 'Autre', 'description' => 'Autre Localisation'],
            ['type' => 'Location', 'value' => 'Dakar', 'description' => 'Region de Dakar'],
            ['type' => 'Location', 'value' => 'Thiès', 'description' => 'Region de Thiès'],
            ['type' => 'Location', 'value' => 'Saint-Louis', 'description' => 'Region de Saint-Louis'],
            ['type' => 'Location', 'value' => 'Diourbel', 'description' => 'Region de Diourbel'],
            ['type' => 'Location', 'value' => 'Louga', 'description' => 'Region de Louga'],
            ['type' => 'Location', 'value' => 'Fatick', 'description' => 'Region de Fatick'],
            ['type' => 'Location', 'value' => 'Kaolack', 'description' => 'Region de Kaolack'],
            ['type' => 'Location', 'value' => 'Kolda', 'description' => 'Region de Kolda'],
            ['type' => 'Location', 'value' => 'Ziguinchor', 'description' => 'Region de Ziguinchor'],
            ['type' => 'Location', 'value' => 'Matam', 'description' => 'Region de Matam'],
            ['type' => 'Location', 'value' => 'Kaffrine', 'description' => 'Region de Kaffrine'],
            ['type' => 'Location', 'value' => 'Kédougou', 'description' => 'Region de Kédougou'],
            ['type' => 'Location', 'value' => 'Sédhiou', 'description' => 'Region de Sédhiou'],
            ['type' => 'Location', 'value' => 'Tambacounda', 'description' => 'Region de Tambacounda'],
            // Secteurs d'Activité
            ['type' => 'Sector', 'value' => 'Télécommunications', 'description' => 'Secteur des Télécommunications'],
            ['type' => 'Sector', 'value' => 'Banque/Finance', 'description' => 'Secteur de la Banque et Finance'],
            ['type' => 'Sector', 'value' => 'Agriculture', 'description' => 'Secteur de l\'Agriculture'],
            ['type' => 'Sector', 'value' => 'Fintech', 'description' => 'Secteur de la Fintech'],
            ['type' => 'Sector', 'value' => 'Education', 'description' => 'Secteur de l\'Éducation'],
            ['type' => 'Sector', 'value' => 'Santé', 'description' => 'Secteur de la Santé'],
            ['type' => 'Sector', 'value' => 'Transport', 'description' => 'Secteur du Transport'],
            ['type' => 'Sector', 'value' => 'Construction', 'description' => 'Secteur de la Construction'],
            ['type' => 'Sector', 'value' => 'Commerce', 'description' => 'Secteur du Commerce'],
            ['type' => 'Sector', 'value' => 'Énergie', 'description' => "Secteur de l'Énergie"],
            ['type' => 'Sector', 'value' => 'Tourisme', 'description' => "Secteur du Tourisme"],
            ['type' => 'Sector', 'value' => 'Informatique', 'description' => "Secteur de l'Informatique"],
            ['type' => 'Sector', 'value' => 'Industries', 'description' => "Secteur des Industries"],
            ['type' => 'Sector', 'value' => 'Services', 'description' => "Secteur des Services"],
        ];

        foreach ($data as $item) {
            CodeList::create($item);
        }
    }
}

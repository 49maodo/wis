<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'resume' => ['nullable', 'string', 'max:2000'],

            // Réseaux sociaux
            'social_links' => ['nullable', 'array'],
            'social_links.*.platform' => ['required_with:social_links', 'string', 'max:50'],
            'social_links.*.url' => ['required_with:social_links', 'url', 'max:255'],

            // Compétences
            'skills' => ['nullable', 'array'],
            'skills.*.name' => ['required_with:skills', 'string', 'max:100'],
            'skills.*.level' => ['nullable', 'string', 'in:débutant,intermédiaire,avancé,expert'],
            'skills.*.category' => ['nullable', 'string', 'max:50'],

            // Expériences
            'experiences' => ['nullable', 'array'],
            'experiences.*.title' => ['required_with:experiences', 'string', 'max:150'],
            'experiences.*.company' => ['required_with:experiences', 'string', 'max:150'],
            'experiences.*.location' => ['nullable', 'string', 'max:100'],
            'experiences.*.start_date' => ['required_with:experiences', 'date'],
            'experiences.*.end_date' => ['nullable', 'date', 'after:experiences.*.start_date'],
            'experiences.*.current' => ['nullable', 'boolean'],
            'experiences.*.description' => ['nullable', 'string', 'max:1000'],
            'experiences.*.type' => ['nullable', 'string', 'in:temps_plein,temps_partiel,stage,freelance,contrat'],

            // Éducation
            'education' => ['nullable', 'array'],
            'education.*.degree' => ['required_with:education', 'string', 'max:150'],
            'education.*.institution' => ['required_with:education', 'string', 'max:150'],
            'education.*.field_of_study' => ['nullable', 'string', 'max:100'],
            'education.*.start_date' => ['required_with:education', 'date'],
            'education.*.end_date' => ['nullable', 'date', 'after:education.*.start_date'],
            'education.*.current' => ['nullable', 'boolean'],
            'education.*.grade' => ['nullable', 'string', 'max:50'],
            'education.*.description' => ['nullable', 'string', 'max:500'],

            // Langues
            'languages' => ['nullable', 'array'],
            'languages.*.language' => ['required_with:languages', 'string', 'max:50'],
            'languages.*.level' => ['required_with:languages', 'string', 'in:débutant,élémentaire,intermédiaire,courant,bilingue,natif'],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'social_links.*.url.url' => 'L\'URL du réseau social doit être valide.',
            'experiences.*.end_date.after' => 'La date de fin doit être après la date de début.',
            'education.*.end_date.after' => 'La date de fin doit être après la date de début.',
            'languages.*.level.in' => 'Le niveau de langue doit être : débutant, élémentaire, intermédiaire, courant, bilingue ou natif.',
            'skills.*.level.in' => 'Le niveau de compétence doit être : débutant, intermédiaire, avancé ou expert.',
        ];
    }
}

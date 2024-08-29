<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //

            /*
            
            'Prenom' => 'sometimes|required|string|max:255',
            'Nom' => 'sometimes|required|string|max:255',
            'Email' => 'sometimes|required|email|unique:clients,Email,' . $this->client->id,
            'Tel' => 'sometimes|required|string|max:20',

            */
        ];
    }
}

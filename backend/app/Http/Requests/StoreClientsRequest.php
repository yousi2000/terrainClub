<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
           

            'Prenom' => 'required|string|max:255',
            'Nom' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,Email',
            'Tel' => 'required|string|max:20',
            
           
        ];
    }
}

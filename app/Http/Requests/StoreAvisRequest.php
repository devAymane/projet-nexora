<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAvisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('client') ?? false;
    }

    public function rules(): array
    {
        return [
            'reservation_id' => [
                'required',
                'integer',
                'exists:reservations,id',
            ],

            'note' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],

            'commentaire' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
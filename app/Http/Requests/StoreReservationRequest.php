<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('client') ?? false;
    }

    public function rules(): array
    {
        return [
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],

            'date' => [
                'required',
                'date',
                'after:now',
            ],

            'message' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}
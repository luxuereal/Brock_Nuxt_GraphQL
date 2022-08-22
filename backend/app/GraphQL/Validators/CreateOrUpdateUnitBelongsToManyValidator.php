<?php

namespace App\GraphQL\Validators;

use Nuwave\Lighthouse\Validation\Validator;
use Illuminate\Validation\Rule;

class CreateOrUpdateUnitBelongsToManyValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {   
        return [
            'sync.*' =>  [
                Rule::exists('units', 'id')
            ],
            'syncWithoutDetaching.*' => [
                Rule::exists('units', 'id')
            ],
            'disconnect.*' => [
                Rule::exists('units', 'id')
            ]
        ];
    }
}

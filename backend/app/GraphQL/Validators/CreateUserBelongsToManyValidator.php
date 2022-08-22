<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

class CreateUserBelongsToManyValidator extends Validator
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
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('is_admin', 0);
                })
            ],
            'syncWithoutDetaching.*' => [
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('is_admin', 0);
                })
            ],
            'disconnect.*' => [
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('is_admin', 0);
                })
            ]
        ];
    }
}

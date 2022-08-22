<?php

namespace App\GraphQL\Validators;

use App\Models\Register;
use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

class UpdateRegisterInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        // against sql injection
        $updatingUnit = Register::find($this->arg('id'));

        return [
            'code' => [
                'filled',
                'max:255',
                Rule::unique('registers', 'code')->ignore($updatingUnit),
            ],
            'name' => ['filled', 'max:255'],
            'bank' => ['filled' ,"regex:/^\d{1,6}(\.\d{1,2})?$/"],
            'nonResetable' => ['filled' ,"regex:/^\d{1,6}(\.\d{1,2})?$/"],
            'commission' => ['filled' ,"regex:/^\d{1,6}(\.\d{1,2})?$/"]
        ];
    }
}

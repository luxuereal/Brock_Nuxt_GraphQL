<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

class ConnectBelongsToParentGlAccountValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $accountId = intval($this->arg('id'));

        return [
            'connect' => [
                'required',
                Rule::exists('gl_accounts', 'id')->where(function ($query) use ($accountId) {
                    return $query->where([
                        ['parent_id', null],
                        ['id', "!=", $accountId]
                    ]);
                })
            ]
        ];
    }
}

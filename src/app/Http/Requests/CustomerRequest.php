<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function storeRules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    public function getRules(string $type = 'store'): array
    {
        $rules = [];
        switch ($type) {
            case 'store':
                $rules = $this->storeRules();
                break;
        }

        return $rules;
    }

    public function isValid(string $type = 'store'): array
    {
        $errors = [];
        $validator = Validator::make($this->all(), $this->getRules($type));

        if ($validator->fails()) {
            $errors = $validator->messages()->get('*');
            $mappedErr = Arr::map($errors, function (array $value) {
                return Arr::first($value);
            });
            $errors = $mappedErr;
        }
        return $errors;
    }
}

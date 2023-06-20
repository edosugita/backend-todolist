<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator
{
    protected $data;
    protected $validator;

    public function __construct(array $data) {
        $this->data = $data;
    }

    public function validateLevel()
    {
        $this->validator = Validator::make($this->data, $this->levelRules());


        return $this->validator->passes();
    }

    protected function levelRules()
    {
        return [
            'name' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'required' => 'Data :attribute harus diisi',
        ];
    }

    public function errors()
    {
        $errors = [];

        foreach ($this->validator->messages()->toArray() as $field => $messages) {
            $errors[$field] = $messages;
        }

        return $errors;
    }
}
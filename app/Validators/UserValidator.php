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

    public function validateRegister()
    {
        $this->validator = Validator::make($this->data, $this->levelRegister());


        return $this->validator->passes();
    }

    public function validateUpdate()
    {
        $this->validator = Validator::make($this->data, $this->levelUpdate());


        return $this->validator->passes();
    }

    public function validateUpdatePassword()
    {
        $this->validator = Validator::make($this->data, $this->levelUpdatePassword());


        return $this->validator->passes();
    }

    public function validateLevel()
    {
        $this->validator = Validator::make($this->data, $this->levelRules());


        return $this->validator->passes();
    }

    protected function levelUpdate()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc|email:dns',
            'status' => 'required',
        ];
    }

    protected function levelUpdatePassword()
    {
        return [
            'old_password' => 'required|min:8|max:16',
            'password' => 'required|min:8|max:16|confirmed',
            'password_confirmation' => 'required|min:8|max:16',
        ];
    }

    protected function levelRegister()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc|email:dns',
            'password' => 'required|min:8|max:16|confirmed',
            'password_confirmation' => 'required|min:8|max:16',
            'status' => 'required',
        ];
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
            'required' => 'The :attribute field is required.',
            'min:8' => 'The :attribute must be at least 8 characters.',
            'max:16' => 'The :attribute may not be greater than 16 characters.',
            'email' => 'The :attribute address format is invalid.',
            'email:rfc' => 'The :attribute address format is invalid.',
            'email:dns' => 'The domain in the :attribute address is invalid or cannot receive emails.',

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
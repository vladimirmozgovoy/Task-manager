<?php
namespace App\Utils;
use Rakit\Validation\Validator;

class ValidationUtil
{
    public static function validate($data, $rules, $customLocalization = [])
    {
        $validator = new Validator(self::getRulesLocalization());
        if($customLocalization) {
            $validator->setMessages($customLocalization);
        }

        $validation = $validator->make($data, $rules);
        $validation->validate();
        if ($validation->fails()) {
            throw \App\Utils\Exceptions\ValidationException::withErrors($validation->errors()->firstOfAll());
        }

        return $validation->getValidatedData();
    }

    protected static function getRulesLocalization()
    {
        return [
            'required' => ':attribute обязателен для заполнения',
            'email' => ':attribute должно быть адресом электронной почты',
            'same' => ':attribute и поле подтверждения должны совпадать',
            'date' => ':attribute должно быть корректной датой',
            'integer' => ':attribute должно быть целым числом',
            'min' => ':attribute должен быть не короче :min символов'
        ];
    }
}

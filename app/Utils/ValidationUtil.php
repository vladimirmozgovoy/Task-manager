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
        // $validation->setAliases(self::getAttributeAliases());
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

    // protected static function getAttributeAliases()
    // {
    //     return [
    //         'phone' => 'Номер телефона',
    //         'password' => 'Пароль',
    //         "NAME" => 'Имя',
    //         "LAST_NAME" => 'Фамилия',
    //         "EMAIL" => 'Email',
    //         "PASSWORD" => 'Пароль',
    //         "CONFIRM_PASSWORD" => 'Подтверждение пароля',
    //         "PERSONAL_PHONE" => 'Телефон',
    //         "PERSONAL_GENDER" => 'Пол',
    //         "PERSONAL_BIRTHDAY" => 'Дата рождения',
    //         "UF_STANCE" => 'Стойка',
    //         "UF_LEVEL" => 'Уровень катания',
    //         "UF_NAME" => 'Имя',
    //         "UF_LAST_NAME" => 'Фамилия',
    //         "UF_PERSONAL_BIRTHDAY" => 'Дата рождения',
    //         "UF_GENDER" => 'Пол',
    //         "UF_HEIGHT" => 'Рост',
    //         "UF_WEIGHT" => 'Вес',
    //         "UF_FOOT_SIZE" => 'Размер стопы',
    //         "sum" => 'Сумма',
    //     ];
    // }
}

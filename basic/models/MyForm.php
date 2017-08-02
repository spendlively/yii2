<?php

namespace app\models;


class MyForm extends \yii\base\Model
{

    public $name;
    public $email;
    public $file;

    public function rules()
    {

        return [
            [['name', 'email'], 'required', 'message' => 'Не заполнено поле'],
            ['email', 'email', 'message' => 'Некорректный email адрес'],
            [['file'], 'file', 'extensions' => 'jpg, png'],
        ];
    }
}

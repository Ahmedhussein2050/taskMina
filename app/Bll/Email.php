<?php


namespace App\Bll;


class Email
{

    public function emailSave($message, $email, $user_id, $model_type)
    {
        $data = [
            'to' => $email,
            'message' => $message,
            'model_type' => $model_type,
            'user_id' => $user_id,
        ];
        \App\Modules\Admin\Models\Email::create($data);
        return $data;
    }
}

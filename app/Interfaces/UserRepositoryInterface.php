<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{

    public function Image($image, $user_id);

    public function UpdateAddress($id, $arr);
    public function UpdateFirst($model, $arr);
}
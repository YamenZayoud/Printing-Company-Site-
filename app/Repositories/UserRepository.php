<?php

namespace App\Repositories;

use App\Enums\MaterialEnum;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Material;
use App\Models\UserImage;

class UserRepository implements UserRepositoryInterface
{

    public function Image($image, $user_id)
    {
        // TODO: Implement Create() method.
        $userImage = UserImage::where('user_id', $user_id)->first();
        $userImage->image = $image;
        $userImage->save();
    }

    public function UpdateAddress($user_id, $arr)
    {
        // TODO: Implement Update() method.
        UserImage::where('user_id', $user_id)->first()->update($arr);
    }

    public function UpdateFirst($model, $arr)
    {
        // TODO: Implement Update() method.
        $model::first()->update($arr);
    }

    public function ChangeQuantity($material, $arr)
    {

        if ($arr['type'] == MaterialEnum::input) {

            $material->current_quantity = $material->current_quantity + $arr['quantity'];
        } else {
            if ($material->current_quantity - $arr['quantity'] > 0) {
                $material->current_quantity = $material->current_quantity - $arr['quantity'];
            }
        }
        $material->save();
    }
}

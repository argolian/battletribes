<?php

namespace App\Rules;

use App\Models\BlockedType;
use Illuminate\Contracts\Validation\Rule;

class UniqueBlockerItemValueEmail implements Rule
{

    private $typeId;

    public function __construct($typeId)
    {
        $this->typeId = $typeId;
    }


    public function passes($attribute, $value)
    {
        if ($this->typeId) {
            $type = BlockedType::find($this->typeId);

            if ($type->slug == 'email' || $type->slug == 'user') {
                $check = $this->checkEmail($value);

                if ($check) {
                    return $value;
                }

                return false;
            }
        }

        return true;
    }

    public function checkEmail($email)
    {
        $find1 = strpos($email, '@');
        $find2 = strpos($email, '.');

        return $find1 !== false && $find2 !== false && $find2 > $find1;
    }


    public function message()
    {
        return trans('laravelblocker.validation.email');
    }
}

<?php

namespace App\Actions\User;

use App\Models\User;

class GetProfileAction
{

    public function execute(): User
    {
        return auth()->user();
    }
}

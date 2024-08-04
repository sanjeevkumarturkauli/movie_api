<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;


class UsersService
{
    /**
     * Create a new class instance.
     */
    protected $UserModel;

    public function __construct(User $UserModel)
    {
        $this->UserModel = $UserModel;
    }

    public function save($request)
    {
        $User = $this->UserModel::create([
            "uuid"=> $request->uuid,
            "isFrom"=> $request->isFrom,
        ]);

        return $User;
    }

    public function getUser($request){
        return $this->UserModel::where("uuid",$request->uuid)->first();
    }
}

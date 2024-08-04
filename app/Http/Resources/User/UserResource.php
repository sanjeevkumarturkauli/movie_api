<?php

namespace App\Http\Resources\User;

use App\Models\plan;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Getting Plans For Current User
        $plans = plan::where("user_id",$this->resource->id)->first();

        // return response
        return [
            'token' => JWTAuth::fromUser($this->resource),
            'token_type' => 'bearer',
            'expire_in' => config('jwt.ttl') * 60, // Token expiry in seconds
            'isForm' => $this->resource->isFrom,
            'plans' => [
                'isActive'=> $plans->isActive ?? false,
                'deafult'=> $plans->deafult ?? false,
                'endDate'=> $plans->deafult ?? null,
                'planId'=> $plans->id ?? null,
            ],
        ];
    }
}

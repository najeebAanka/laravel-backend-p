<?php

namespace App\Resources;

use App\Model\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => !is_null($this->name) ? $this->name : '',
            'username' => $this->username,
            'email' => $this->email,
            'personal_picture' => asset('storage/users') . '/' . $this->personal_picture,
            'birthdate' => $this->birthdate ? $this->birthdate : Carbon::now()->toDateString(),
            'gender' => $this->gender ? $this->gender : 1,
            'gender_str' => $this->gender == 1 ? 'Male' : 'Female',
            'phone' => $this->phone ? $this->phone : '',
            'type' => 'user',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

}
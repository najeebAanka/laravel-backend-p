<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Partner extends JsonResource
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
            'authority_name' => $this->authority_name,
            'authority_id' => $this->authority_id,
            'authority_title' => $this->authority->title,
            'country_id' => $this->country_id,
            'country_name' => $this->country->{app()->getLocale().'_name'},
            'city_id' => $this->city_id,
            'city_name' => $this->city->{app()->getLocale().'_name'},
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'trade_license' => getFileURL($this->trade_license),
            'type' => 'partner',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

    }

}
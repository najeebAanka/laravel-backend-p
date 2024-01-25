<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerBref extends JsonResource
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
            'authority_title' => $this->authority->title,
            'country_name' => $this->country->{app()->getLocale().'_name'},
            'city_name' => $this->city->{app()->getLocale().'_name'},
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];

    }

}
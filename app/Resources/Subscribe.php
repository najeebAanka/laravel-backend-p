<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class Subscribe extends JsonResource
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
            'card' => CardBref::make($this->card),
            'country_id' => $this->country_id,
            'country_name' => $this->country->{app()->getLocale() . '_name'},
            'city_id' => $this->city_id,
            'city_name' => $this->city->{app()->getLocale() . '_name'},
            'f_name' => $this->f_name,
            'l_name' => $this->l_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'un_subscribe_reason' => $this->un_subscribe_reason,
            'created_at' => $this->created_at,
            'renewed_at' => $this->renewed_at
        ];
    }

}
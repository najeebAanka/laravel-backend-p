<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class OfferBref extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {


        $v = new Voyager();

        $expire_after = 'expired';
        if (Carbon::now()->toDateTimeString() < $this->expire_date) {
            $expire_after = Carbon::now()->diff($this->expire_date)->days . ' Days';
        }

        return [
            'id' => $this->id,
            'image' => $v->image($this->image),
            'title' => $this->title,
            'discount' => $this->discount,
            'start_date' => $this->start_date,
            'expire_date' => $this->expire_date,
            'expire_after' => $expire_after,
            'terms_and_conditions' => $this->terms_and_conditions,
            'partner' => PartnerBref::make($this->partner),
            'card' => CardBref::make($this->card),
            'created_at' => $this->created_at,
        ];
    }

}
<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class Card extends JsonResource
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


        $subscribed = false;
        if (auth()->check() && \App\Models\Subscribe::where([
                'card_id' => $this->id,
                'user_id' => auth()->user()->id,
            ])->first()) {
            $subscribed = true;
        }

        return [
            'id' => $this->id,
            'image' => $v->image($this->image),
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'expire_date' => $this->expire_date,
            'discount' => $this->discount,
            'is_mobile' => $this->is_mobile,
            'subscribed' => $subscribed,
            'advantages' => CardAdvantage::collection($this->advantages)
        ];
    }

}
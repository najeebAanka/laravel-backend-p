<?php

namespace App\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class CardBref extends JsonResource
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

        return [
            'id' => $this->id,
            'image' => $v->image($this->image),
            'title' => $this->title,
            'price' => $this->price,
            'discount' => $this->discount
        ];
    }

}
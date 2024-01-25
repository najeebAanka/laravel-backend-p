<?php

namespace App\Resources;

use App\Model\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Voyager;

class CardAdvantage extends JsonResource
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
            'icon' => $v->image($this->icon),
            'title' => $this->title,
            'description' => $this->description,
            'show_home' => $this->show_home,
            'status' => $this->status
        ];
    }

}
<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Offer;
use App\Models\Subscribe;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class UserController extends Controller
{
    public function mysubscribes(Request $request)
    {
        $subscriptions = Subscribe::where('user_id', auth()->user()->id)->get();
        return parent::sendSuccess(trans('messages.Data Got!'), \App\Resources\Subscribe::collection($subscriptions));
    }

    public function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'country_id' => 'required|numeric|exists:countries,id',
            'city_id' => 'required|numeric|exists:countries_states,id',
            'address' => 'required|string',
            'pay_type' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $subscribion = \App\Models\Subscribe::where([
            'card_id' => $request->card_id,
            'user_id' => auth()->user()->id,
        ])->first();

        if ($subscribion) {
            if ($subscribion->status == 'unsubscribed') {
                return parent::sendError([['message' => trans('messages.you already subscribed before ... please go to renewal!')]], 403);
            }
            return parent::sendError([['message' => trans('messages.you subscribed before!')]], 403);
        }

        $subscribe = new Subscribe();
        $subscribe->f_name = $request->f_name;
        $subscribe->l_name = $request->l_name;
        $subscribe->phone = $request->phone;
        $subscribe->email = $request->email;
        $subscribe->country_id = $request->country_id;
        $subscribe->city_id = $request->city_id;
        $subscribe->address = $request->address;
        $subscribe->pay_type = $request->pay_type;
        $subscribe->user_id = auth()->user()->id;
        $subscribe->save();

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\Subscribe::make($subscribe));

    }


    public function unsubscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'card_id' => 'required|numeric|exists:offers,id',
            'un_subscribe_reason' => 'required|string|min:2'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $subscribion = \App\Models\Subscribe::where([
            'card_id' => $request->card_id,
            'user_id' => auth()->user()->id,
        ])->first();

        if (!$subscribion) {
            return parent::sendError([['message' => trans('messages.you did not subscribe before!')]], 403);
        }

        $subscribion->status = 'unsubscribed';
        $subscribion->un_subscribe_reason = $request->un_subscribe_reason;
        $subscribion->update();

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\Subscribe::make($subscribion));

    }

    public function renewal(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'card_id' => 'required|numeric|exists:offers,id'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        $subscribion = \App\Models\Subscribe::where([
            'card_id' => $request->card_id,
            'user_id' => auth()->user()->id,
        ])->first();

        if (!$subscribion) {
            return parent::sendError([['message' => trans('messages.you did not subscribe before!')]], 403);
        }

        $subscribion->status = 'renewed';
        $subscribion->renewed_at = Carbon::now()->toDateTimeString();
        $subscribion->update();

        return parent::sendSuccess(trans('messages.Data Saved!'), \App\Resources\Subscribe::make($subscribion));

    }
}
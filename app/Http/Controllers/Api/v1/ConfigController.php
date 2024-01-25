<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Authority;
use App\Models\Brand;
use App\Models\Card;
use App\Models\CardAdvantage;
use App\Models\Message;
use App\Models\SpecialFeature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Http\Controllers\ContentTypes\Image as ContentImage;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class ConfigController extends Controller
{
    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }


        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);


        return parent::sendSuccess(trans('messages.Message Sent!'), null);

    }

    public function info(Request $request)
    {
        $cards = \App\Resources\Card::collection(Card::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $authorities = \App\Resources\Authority::collection(Authority::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $special_features = \App\Resources\SpecialFeature::collection(SpecialFeature::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $brands = \App\Resources\Brand::collection(Brand::get()->translate(app()->getLocale(), 'fallbackLocale'));
        $home_services = \App\Resources\CardAdvantage::collection(CardAdvantage::active()->home()->
        get()->translate(app()->getLocale(), 'fallbackLocale'));

        return parent::sendSuccess(trans('messages.Data Got!'), [
            'cards' => $cards,
            'home_services' => $home_services,
            'authorities' => $authorities,
            'brands' => $brands,
            'special_features' => $special_features,
        ]);
    }


}
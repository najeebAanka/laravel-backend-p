<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Http\Controllers\ContentTypes\File;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;

class PartnerController extends Controller
{


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'authority_name' => 'required|string',
            'authority_id' => 'required|numeric|exists:authorities,id',
            'country_id' => 'required|numeric|exists:countries,id',
            'city_id' => 'required|numeric|exists:countries_states,id',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'address' => 'required|string',
            'trade_license' => 'required'
        ]);

        if ($validator->fails()) {
            return parent::sendError(parent::error_processor($validator), 403);
        }

        $trade_license = '';
        if ($request->hasFile('trade_license')) {
            $slug = 'users';
            $data_type = DataType::where('slug', $slug)->first();
            $row = DataRow::where('data_type_id', $data_type->id)->
            where('field', 'trade_license')->
            first();
            $trade_license = (new File($request, $slug, $row, $row->details))->handle();
        }

        $email = $request->email;
        $password = generateRandomString(10);

        $user = User::create([
            'username' => slugify($request->authority_name),
            'password' => bcrypt($password),
            'authority_name' => $request->authority_name,
            'authority_id' => $request->authority_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'email' => $email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 1,
            'role_id' => getRoleID('partner'),
            'trade_license' => $trade_license
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        return parent::sendSuccess(trans('messages.Account will be reviewed!'), [
            'token' => $token,
            'user' => \App\Resources\Partner::make($user)
        ]);

    }


    public function offers(Request $request)
    {
        $paginator = Offer::query();


        if ($request->has('search_text') && strlen($request->get('search_text'))) {
            $paginator = $paginator
                ->where('title', 'like', '%' . $request->get('search_text') . '%')
                ->orWhere('description', 'like', '%' . $request->get('search_text') . '%');
        }


        if ($request->has('use_times') && is_numeric($request->get('use_times')) && $request->get('use_times') > 0) {
            $paginator = $paginator
                ->where('use_times', $request->get('use_times'));
        }

        if (
            $request->has('min_discount') && is_numeric($request->get('min_discount')) && $request->get('min_discount') > 0 &&
            $request->has('max_discount') && is_numeric($request->get('max_discount')) && $request->get('max_discount') > 0

        ) {
            $paginator = $paginator
                ->where('discount', '>=', $request->get('min_discount'))
                ->where('discount', '<=', $request->get('max_discount'));
        }

        if (
            $request->has('expire_date') && $request->get('expire_date') > 0

        ) {
            $paginator = $paginator
                ->where('expire_date', '<=', $request->get('expire_date'));
        }

        if (
            $request->has('start_date') && $request->get('start_date') > 0

        ) {
            $paginator = $paginator
                ->where('start_date', '>=', $request->get('start_date'));
        }

        if ($request->has('partner_id') && is_numeric($request->get('partner_id')) && $request->get('partner_id') > 0) {
            $paginator = $paginator
                ->where('partner_id', $request->get('partner_id'));
        }

        if ($request->has('card_id') && is_numeric($request->get('card_id')) && $request->get('card_id') > 0) {
            $paginator = $paginator
                ->where('card_id', $request->get('card_id'));
        }


        $offset = $request->offset ? $request->offset : 1;
        $limit = $request->limit ? $request->limit : 10;
        $paginator = $paginator->active()->paginate($limit, ['*'], 'page', $offset);
        $data = [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'products' => \App\Resources\Offer::collection($paginator->items())
        ];

        return parent::sendSuccess(trans('messages.Data Got!'), $data);
    }

}
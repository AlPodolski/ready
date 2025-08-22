<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index($city,Request $request)
    {
        $cityInfo = $this->cityRepository->getCity($city);

        $claim = new Claim();

        $claim->fill($request->post());
        $claim->city_id = $cityInfo->id;

        if ($claim->save()) return back()->with('success', 'Запрос отправлен');

        return back()->with('error', 'Ошибка');
    }
}

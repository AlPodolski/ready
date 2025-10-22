<?php

namespace App\Http\Controllers;

use App\Events\PayEvent;
use App\Models\History;
use App\Models\Order;
use App\Models\User;
use App\Services\Obmenka;

class PayController extends Controller
{
    public function index( $id, Obmenka $obmenka)
    {
        $order = Order::findOrFail($id);

        if ($order and $order->status == Order::WAIT and $user = User::find($order->user_id)){

            $orderInfo = $obmenka->getOrderInfo($order->id.'-teamo');

            if (isset($orderInfo->amount) and $orderInfo->status == 'FINISHED' or $orderInfo->status == 'PAYED_RECALC') {

                $sum = $orderInfo->accrual_amount;

                $order->status = Order::FINISH;

                $order->save();

                $user->cash = $user->cash + $sum;

                $user->save();

                //$payType = History::REPLENISHMENT_TYPE;

                //event(new PayEvent($order->sum, $user->id, $payType, $user->cash ));

            }

        }
    }
}

<?php

namespace App\Http\Controllers\Midtrans;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\Transaction\TransactionSuccess;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        // Midtrans Config
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Midtrans Notification
        $notification = new Notification();
        $order = explode('-', $notification->order_id);
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $order[2];

        $transaction = Transaction::with([
            'transaction_details',
            'travel_package',
            'user'
        ])->findOrFail($order_id);

        // Handle Midtrans Status Payment
        if ($status === 'capture') {
            if ($type === 'credit_card') {
                if ($fraud === 'challenge') {
                    $transaction->transaction_status = 'CHALLENGE';
                } else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        } else if ($status === 'settlement') {
            $transaction->transaction_status = 'SUCCESS';
        } else if ($status === 'pending') {
            $transaction->transaction_status = 'PENDING';
        } else if ($status === 'deny') {
            $transaction->transaction_status = 'FAILED';
        } else if ($status === 'expire') {
            $transaction->transaction_status = 'EXPIRED';
        } else if ($status === 'CANCEL') {
            $transaction->transaction_status = 'FAILED';
        }
        $transaction->save();

        // If there is transaction send email
        if ($transaction) {
            if ($status === 'capture' && $fraud === 'accept') {
                Mail::to($transaction->user->email)
                    ->send(new TransactionSuccess(
                        $transaction,
                        $transaction->travel_package->title,
                        $transaction->travel_package->departure_date
                    ));
            } else if ($status === 'settlement') {
                Mail::to($transaction->user->email)
                    ->send(new TransactionSuccess(
                        $transaction,
                        $transaction->travel_package->title,
                        $transaction->travel_package->departure_date
                    ));
            } else if ($status === 'success') {
                Mail::to($transaction->user->email)
                    ->send(new TransactionSuccess(
                        $transaction,
                        $transaction->travel_package->title,
                        $transaction->travel_package->departure_date
                    ));
            } else if ($status === 'capture' && $fraud === 'challenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => "Midtrans payment challenge"
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => "Midtrans payment not settlement"
                    ]
                ]);
            }
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => "Midtrans notifications success"
                ]
            ]);
        }
    }

    public function finishRedirect(Request $request)
    {
        return view('pages.checkout-success');
    }

    public function unfinishRedirect(Request $request)
    {
        return view('pages.checkout-unfinish');
    }

    public function errorRedirect(Request $request)
    {
        return view('pages.checkout-error');
    }
}

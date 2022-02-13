<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Mail\Transaction\TransactionSuccess;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TravelPackage;
use Carbon\Carbon;
use Exception;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Psy\Readline\Transient;

class CheckoutController extends Controller
{
    public function index(Transaction $transaction)
    {
        // $transactions = Trans
        $transactions =  $transaction->with([
            'transaction_details',
            'travel_package',
            'user'
        ])->latest()->get();

        return view('pages.checkout', [
            'transaction' => $transactions[0]
        ]);
    }

    public function store(TravelPackage $travel_package)
    {
        // Create Transaction
        $transaction = Transaction::create([
            'travel_packages_id' => $travel_package->id,
            'users_id' => Auth::user()->id,
            'additional_visa' => 0,
            'transaction_total' => $travel_package->price,
            'transaction_status' => 'IN_CART',
        ]);

        // Create TransactionDetails
        TransactionDetail::create([
            'transactions_id' => $transaction->id,
            'username' => Auth::user()->username,
            'nationality' => 'ID',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYears(5)
        ]);

        // Return to view based on Transactions ID 
        return redirect()->route('checkout', $transaction->id);
    }

    public function addMember(Request $request, Transaction $transaction)
    {
        // Create TransactionDetails
        $request->validate([
            'username' => 'required|string',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required'
        ]);
        $validatedData = $request->all();
        $validatedData['transactions_id'] = $transaction->id;
        TransactionDetail::create($validatedData);

        // Add each person visa's and sums it up if visa available
        if ($request->is_visa) {
            $transaction->additional_visa += 190;
            $transaction->transaction_total += $transaction->additional_visa;
        }
        $transaction->transaction_total += $transaction->travel_package->price;
        $transaction->save();

        return redirect()->route('checkout', $transaction->id);
    }

    public function removeMember(Request $request, TransactionDetail $transaction_detail)
    {
        $transaction = Transaction::with([
            'transaction_details',
            'travel_package'
        ])->findOrFail($transaction_detail->transactions_id);

        if ($transaction_detail->is_visa) {
            $transaction->transaction_total -= 190;
            $transaction->additional_visa -= 190;
        }
        $transaction->transaction_total -= $transaction->travel_package->price;
        $transaction->save();
        $transaction_detail->delete();

        return redirect()->route('checkout', $transaction_detail->transactions_id);
    }

    public function success(Request $request, Transaction $transaction)
    {
        $transactions = Transaction::with([
            'transaction_details',
            'travel_package.travel_galleries',
            'user'
        ])->findOrFail($transaction->id);
        $transaction->transaction_status = 'PENDING';
        $transaction->save();

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Required
        $params = [
            'transaction_details' => [
                'order_id' => 'NO-MADS-' . $transaction->id,
                'gross_amount' => $transaction->transaction_total,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email
            ],
            'enabled_payments' => [
                'gopay'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($params)->redirect_url;
            // Mail::to($transaction->user->email)
            //     ->send(new TransactionSuccess(
            //         $transactions,
            //         $transactions->travel_package->title,
            //         $transactions->travel_package->departure_date
            //     ));
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }


        // return view('pages.checkout-success');
    }
}

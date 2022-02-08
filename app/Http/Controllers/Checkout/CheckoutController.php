<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TravelPackage;
use Carbon\Carbon;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $transaction->transaction_status = 'PENDING';
        $transaction->save();

        return view('pages.checkout-success');
    }
}

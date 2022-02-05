<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $travel_packages = TravelPackage::count();
        $transactions = Transaction::with(['travel_package', 'user'])
            ->latest()
            ->get();
        $transactions_total = Transaction::whereTransactionStatus('SUCCESS')
            ->avg('transaction_total');
        $transactions_pending = Transaction::whereTransactionStatus('PENDING')
            ->count();
        $transactions_success = Transaction::whereTransactionStatus('SUCCESS')
            ->count();

        return view('pages.admin.dashboard', [
            'travel_packages' => $travel_packages,
            'transactions_total' => number_format($transactions_total),
            'transactions_pending' => $transactions_pending,
            'transactions_success' => $transactions_success,
            'transactions' => $transactions,
        ]);
    }
}

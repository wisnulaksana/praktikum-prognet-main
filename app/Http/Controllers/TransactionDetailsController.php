<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetails;
use App\Models\Transactions;
use App\Models\Carts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class TransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($transactions, Request $request)
    {

        $id = decrypt($transactions);
        $transaksi = Transactions::with('TransactionDetails')->where('id', '=', $id)->get()->first();
        $transaksidetails = TransactionDetails::with('Transaction')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.id', '=', $id)
            ->select(
                DB::raw('SUM(transaction_details.selling_price * transaction_details.qty) as price'),
                'transaction_details.product_id',
                'transaction_details.qty as quantity',
            )
            ->groupBy('transaction_details.product_id', 'transaction_details.qty')
            ->get();
        $price = 0;
        $total = 0;
        $carts = Carts::where('user_id', "=", Auth::user()->id)->where('status', '=', 'notyet')->get();
        foreach ($carts as $cart) {
            foreach ($cart->products->discounts as $diskon) {

                if (date('Y-m-d') >= $diskon->start  &&  date('Y-m-d') < $diskon->end) {
                    $price = $cart->products->price - ($diskon->percentage / 100 * $cart->products->price);
                }
            }
            if ($price == 0) {
                $total = $total + ($cart->products->price * $cart->qty);
            } else {
                $total = $total + ($price * $cart->qty);
            }

            // dd($cart->qty);
        }
        $notificationId = request('p'); //id notif dari form

        $userUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $notificationId)
            ->first();
        // dd($notificationId);
        if ($userUnreadNotification) {
            $userUnreadNotification->update(['read_at' => now()]);
        }
        return view('detail-transaksi', compact('transaksi', 'transaksidetails', 'carts', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransactionDetails  $transactionDetails
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionDetails $transactionDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransactionDetails  $transactionDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(TransactionDetails $transactionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransactionDetails  $transactionDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransactionDetails $transactionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransactionDetails  $transactionDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransactionDetails $transactionDetails)
    {
        //
    }
}

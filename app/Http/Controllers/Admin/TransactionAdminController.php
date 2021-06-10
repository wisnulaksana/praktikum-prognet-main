<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetails;
use App\Models\Transactions;
use App\Models\User;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transactions::all();
        return view('admin/transactions/index', compact('transactions'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transactions $transaction)
    {
        $notificationId = request('id');

        $adminUnreadNotification = auth()->user()
            ->unreadNotifications
            ->where('id', $notificationId)
            ->first();
        // dd($notificationId);
        if ($adminUnreadNotification) {
            $adminUnreadNotification->update(['read_at' => now()]);
        }
        return view('admin/transactions/show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transactions $transaction)
    {

        if ($request->submit == 'Verif') {
            if(!$transaction->proof_of_payment){
        return redirect()->back()->with('warning', 'Bukti Pembayaran Belum Diupload');
            }else{
            $transaction->status = 'verified';
        }
        } elseif ($request->submit == 'Reject') {
            $transaction->status =  'failed';
            Storage::delete($transaction->proof_of_payment);
            $transaction->proof_of_payment = null;
        } elseif ($request->submit == 'Delivery') {
            $transaction->status =  'delivered';
        }
        // dd($request->submit);
        $transaction->update();
        $user = User::find($transaction->user_id);
        // dd($user);
        $user->notify(new UserNotification("<a class='submit-form' data-submits='' href ='/detail-transaksi/" . encrypt($transaction->id) . "'>Status Transaksi Telah Dirubah Ke " . $request->submit . " oleh admin</a>"));
        return redirect(Route('transaksi-admin'))->with('success', 'Transaksi Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

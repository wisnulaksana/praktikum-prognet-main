<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $user = User::where('id', Auth::user()->id)->first();
        return view('profile', compact('user', 'carts', 'total'));
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
    public function show($id)
    {
        //
    }
    public function sendEmailVerif(User $user)
    {
        $user->sendEmailVerificationNotification();
        return redirect()->back()->with('success', 'Email Verifikasi Terkirim');
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
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;

        if ($user->email != $request->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        if ($request->file('profile_image')) {
            Storage::delete($user->profile_image);
            $gambar = $request->file('profile_image');
            $nama_image = md5(now() . "_") . $request->file('profile_image')->getClientOriginalName();
            $urlgambar = $gambar->storeAs("img/profile_image", $nama_image);
            $user->profile_image = $urlgambar;
        }
        // dd($users);
        $user->update();
        return redirect()->back()->with('success', 'Profile Telah Diupdate');
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

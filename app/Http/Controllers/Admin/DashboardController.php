<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Products;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transactions::whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();
        $status = ['unverified' => 0, 'expired' => 0, 'canceled' => 0, 'verified' => 0, 'delivered' => 0, 'success' => 0, 'harga' => 0, 'total' => $transaksi->count()];
        $status['unverified'] = $this->findCountStatus('unverified', date('m'), date('Y'), 1);
        $status['expired'] = $this->findCountStatus('expired', date('m'), date('Y'), 1);
        $status['canceled'] = $this->findCountStatus('canceled', date('m'), date('Y'), 1);
        $status['verified'] = $this->findCountStatus('verified', date('m'), date('Y'), 1);
        $status['delivered'] = $this->findCountStatus('delivered', date('m'), date('Y'), 1);
        $status['success'] = $this->findCountStatus('success', date('m'), date('Y'), 1);

        foreach ($transaksi as $item) {
            if ($item->status == 'verified' || $item->status == 'delivered' || $item->status == 'success') {
                $status['harga'] = $status['harga'] + $item->total;
            }
        }

        $transaksi_tahun = Transactions::whereYear('created_at', '=', date('Y'))->get();
        $status_tahun = ['unverified' => 0, 'expired' => 0, 'canceled' => 0, 'verified' => 0, 'delivered' => 0, 'success' => 0, 'harga' => 0];
        $status_tahun['unverified'] = $this->findCountStatus('unverified', date('m'), date('Y'), 2);
        $status_tahun['expired'] = $this->findCountStatus('expired', date('m'), date('Y'), 2);
        $status_tahun['canceled'] = $this->findCountStatus('canceled', date('m'), date('Y'), 2);
        $status_tahun['verified'] = $this->findCountStatus('verified', date('m'), date('Y'), 2);
        $status_tahun['delivered'] = $this->findCountStatus('delivered', date('m'), date('Y'), 2);
        $status_tahum['success'] = $this->findCountStatus('success', date('m'), date('Y'), 2);

        foreach ($transaksi_tahun as $item) {
            if ($item->status == 'verified' || $item->status == 'delivered' || $item->status == 'success') {
                $status_tahun['harga'] = $status_tahun['harga'] + $item->total;
            }
        }

        for ($i = 1; $i <= 12; $i++) {
            $bulan[$i] = $transaksi = Transactions::whereMonth('created_at', '=', $i)->whereYear('created_at', '=', date('Y'))->count();
        }

        $products = Products::get()->count();
        $users = User::get()->count();
        $todaySuccessTrans = Transactions::whereDate('created_at',date('Y-m-d'))->get()->count();
        // dd($todaySuccessTrans);
        return view('admin/dashboard', compact('transaksi','status','transaksi_tahun','status_tahun','bulan','products','users','todaySuccessTrans'));
    }


    public function counttotal()
    {
        $myarray['count'] = Auth::guard('admin')->user()->unreadNotifications->count();
        $myarray['list'] = Auth::guard('admin')->user()->unreadNotifications;

        return json_encode($myarray);
    }

    public function MarkAllRead()
    {
        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->unreadNotifications()->update(['read_at' => now()]);
        return redirect()->back();
    }
    public function filterBulan(Request $request)
    {

        $transaksi = Transactions::whereMonth('created_at', '=', $request->bulan)->whereYear('created_at', '=', $request->tahun)->get();
        //    dd($transaksi);
        $status = ['unverified' => 0, 'expired' => 0, 'canceled' => 0, 'verified' => 0, 'delivered' => 0, 'success' => 0, 'harga' => 0, 'total' => $transaksi->count()];
        $status['unverified'] = $this->findCountStatus('unverified', $request->bulan, $request->tahun, 1);
        $status['expired'] = $this->findCountStatus('expired', $request->bulan, $request->tahun, 1);
        $status['canceled'] = $this->findCountStatus('canceled', $request->bulan, $request->tahun, 1);
        $status['verified'] = $this->findCountStatus('verified', $request->bulan, $request->tahun, 1);
        $status['delivered'] = $this->findCountStatus('delivered', $request->bulan, $request->tahun, 1);
        $status['success'] = $this->findCountStatus('success', $request->bulan, $request->tahun, 1);
        // dd( $status['unverified']);
        foreach ($transaksi as $item) {
            if ($item->status == 'verified' || $item->status == 'delivered' || $item->status == 'success') {
                $status['harga'] = $status['harga'] + $item->total;
            }
        }

        return response()->json(['success' => 'berhasil', 'data' => $status]);
    }

    public function filterTahun(Request $request)
    {
        $transaksi_bulan = Transactions::whereMonth('created_at', '=', $request->bulan)->whereYear('created_at', '=', $request->tahun)->get();
        $status_bulan = ['unverified' => 0, 'expired' => 0, 'canceled' => 0, 'verified' => 0, 'delivered' => 0, 'success' => 0, 'harga' => 0, 'total' => $transaksi_bulan->count()];
        $status_bulan['unverified'] = $this->findCountStatus('unverified', $request->bulan, $request->tahun, 1);
        $status_bulan['expired'] = $this->findCountStatus('expired', $request->bulan, $request->tahun, 1);
        $status_bulan['canceled'] = $this->findCountStatus('canceled', $request->bulan, $request->tahun, 1);
        $status_bulan['verified'] = $this->findCountStatus('verified', $request->bulan, $request->tahun, 1);
        $status_bulan['delivered'] = $this->findCountStatus('delivered', $request->bulan, $request->tahun, 1);
        $status_bulan['success'] = $this->findCountStatus('success', $request->bulan, $request->tahun, 1);

        foreach ($transaksi_bulan as $item) {
            if ($item->status == 'verified' || $item->status == 'delivered' || $item->status == 'success') {
                $status_bulan['harga'] = $status_bulan['harga'] + $item->total;
            }
        }

        $transaksi = Transactions::whereYear('created_at', '=', $request->tahun)->get();
        $status = ['unverified' => 0, 'expired' => 0, 'canceled' => 0, 'verified' => 0, 'delivered' => 0, 'success' => 0, 'harga' => 0, 'total' => $transaksi->count()];
        $status['unverified'] = $this->findCountStatus('unverified', $request->bulan, $request->tahun, 2);
        $status['expired'] = $this->findCountStatus('expired', $request->bulan, $request->tahun, 2);
        $status['canceled'] = $this->findCountStatus('canceled', $request->bulan, $request->tahun, 2);
        $status['verified'] = $this->findCountStatus('verified', $request->bulan, $request->tahun, 2);
        $status['delivered'] = $this->findCountStatus('delivered', $request->bulan, $request->tahun, 2);
        $status['success'] = $this->findCountStatus('success', $request->bulan, $request->tahun, 2);

        foreach ($transaksi as $item) {
            if ($item->status == 'verified' || $item->status == 'delivered' || $item->status == 'success') {
                $status['harga'] = $status['harga'] + $item->total;
            }
        }

        for ($i = 1; $i <= 12; $i++) {
            $tahun[$i] = Transactions::whereMonth('created_at', '=', $i)->whereYear('created_at', '=', $request->tahun)->count();
        }

        return response()->json(['success' => 'berhasil', 'data' => $status, 'data_bulan' => $status_bulan, 'tahun' => $tahun]);
    }

    public function findCountStatus($status, $bulan, $tahun, $cek)
    {
        if ($cek == 1) {
            $count = Transactions::whereMonth('created_at', '=', $bulan)->whereYear('created_at', '=', $tahun)->where('status', '=', $status)->count();
        } else {
            $count = Transactions::whereYear('created_at', '=', $tahun)->where('status', '=', $status)->count();
        }
        return $count;
    }


    public function grafik(Request $request)
    {
        // dd($request->status);
        if ($request->status == 'all') {
            for ($i = 1; $i <= 12; $i++) {
                $grafik[$i] = Transactions::whereMonth('created_at', '=', $i)->whereYear('created_at', '=', $request->tahun)->count();
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $grafik[$i] = Transactions::whereMonth('created_at', '=', $i)->whereYear('created_at', '=', $request->tahun)->where('status', '=', $request->status)->count();
            }
        }
        return response()->json(['success' => 'berhasil', 'grafik' => $grafik]);
    }
    public function userProfile()
    {
        $adminUser = Admin::where('id', Auth::guard('admin')->user()->id)->first();
        return view('admin/admin_profile/index', compact('adminUser'));
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
    public function update(Request $request, Admin $admin)
    {
        $admins = $request->all();
        if ($request->input('password')) {
            if (Hash::check($request->password, Auth::guard('admin')->user()->password)) {
                $admins['password'] = bcrypt($request->new_password);
            } else {
                return redirect()->back()->with('error', 'Password Lama Salah');
            }
        }
        if ($request->file('profile_image')) {
            Storage::delete($admin->profile_image);
            $gambar = $request->file('profile_image');
            $nama_image = md5(now() . "_") . $request->file('profile_image')->getClientOriginalName();
            $urlgambar = $gambar->storeAs("img/profile_image", $nama_image);
            $admins['profile_image'] = $urlgambar;
        }
        $result = array_filter($admins);
        // dd($result);
        $admin->update($result);
        return redirect()->back()->with('info', 'Profile Berhasil Di Update');
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

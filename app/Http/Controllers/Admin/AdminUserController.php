<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminUser = Admin::all();
        return view('admin/add_admin/index',compact('adminUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/add_admin/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admins = $request->all();
        $admins['password'] = bcrypt($request->password);
        if ($request->file('profile_image')) {
            $gambar = $request->file('profile_image');
            $nama_image = md5(now() . "_") . $request->file('profile_image')->getClientOriginalName();
            $urlgambar = $gambar->storeAs("img/profile_image", $nama_image);
            $admins['profile_image'] = $urlgambar;
        }
        Admin::create($admins);
        return redirect('admin/add')->with('success','User Telah Ditambahkan');

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
    public function edit(Admin $admin)
    {
        return view('admin/add_admin/edit',compact('admin'));
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

        if ($request->file('profile_image')) {
            Storage::delete($admin->profile_image);
            $gambar = $request->file('profile_image');
            $nama_image = md5(now() . "_") . $request->file('profile_image')->getClientOriginalName();
            $urlgambar = $gambar->storeAs("img/profile_image", $nama_image);
            $admins['profile_image'] = $urlgambar;
        }
        $admin->update($admins);
        return redirect('admin/add')->with('info','Data Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        Storage::delete($admin->profile_image);
        $admin->delete();
        return redirect()->back()->with('error','Data Telah Dihapus');
    }
}

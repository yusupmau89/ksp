<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Models\Pengguna;
use App\Models\RefAlamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    //added
    private $urlProvinsi = 'https://dev.farizdotid.com/api/daerahindonesia/provinsi';
    //end added
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Pengguna::orderBy('nama', 'asc')->get();
        return view('login.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('login.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $validated = $request->validated();
        $npwp = preg_replace('/[^0-9]/', '', $validated['npwp']);
        $validated['customer'] = true;

        $customer = new Pengguna;
        $customer->nama = $validated['nama_customer'];
        $customer->customer = $validated['customer'];
        if (!empty($npwp))
            $customer->npwp = $validated['npwp'];
        $customer->created_by = Auth::user()->id;
        $customer->slug = Str::slug($validated['nama_customer'].date('-His'));
        $customer->save();

        $customer->alamats()->create([
            'ref_alamat_id' => 1,
            'nama_jalan' => $validated['alamat_pengiriman'],
        ]);

        if (empty($validated['alamat_penagihan']))
        {
            $customer->alamats()->create([
                'ref_alamat_id' => 2,
                'nama_jalan' => $validated['alamat_pengiriman'],
            ]);
        }
        else
        {
            $customer->alamats()->create([
                'ref_alamat_id' => 2,
                'nama_jalan' => $validated['alamat_penagihan'],
            ]);
        }
        if (!empty($validated['email']))
            $customer->emails()->create(['email' => $validated['email']]);
        if (!empty($validated['no_telepon']))
            $customer->telepons()->create(['no_telepon' => $validated['no_telepon']]);

        return redirect('/customer')->with('success', 'Customer berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Pengguna $customer)
    {
        return view('login.customer.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengguna $customer)
    {
        return view('login.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, Pengguna $customer)
    {
        $validated = $request->validated();
        $npwp = preg_replace('/[^0-9]/', '', $validated['npwp']);

        $customer->nama = $validated['nama_customer'];
        if (!empty($npwp))
            $customer->npwp = $validated['npwp'];
        else $customer->npwp = null;
        $customer->alamats()->where('ref_alamat_id', 1)->first()->nama_jalan = $validated['alamat_pengiriman'];
        if (empty($validated['alamat_penagihan']))
            $customer->alamats()->where('ref_alamat_id', 2)->first()->nama_jalan = $validated['alamat_pengiriman'];
        else $customer->alamats()->where('ref_alamat_id', 2)->first()->nama_jalan = $validated['alamat_penagihan'];
        if(!empty($validated['email']) && $customer->emails()->count()==0)
            $customer->emails()->create(['email'=>$validated['email']]);
        elseif (!empty($validated['email']))
            $customer->emails()->first()->update(['email'=>$validated['email']]);
        else $customer->emails()->delete();
        if (!empty($validated['no_telepon']) && $customer->telepons()->count()==0)
            $customer->telepons()->create(['no_telepon'=>$validated['no_telepon']]);
        elseif (!empty($validated['no_telepon']))
            $customer->telepons()->first()->update(['no_telepon'=>$validated['no_telepon']]);
        else $customer->telepons()->delete();
        $customer->slug = Str::slug($validated['nama_customer'].date('-His'));

        $customer->save();
        return redirect('/customer')->with('success', 'Customer berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengguna $customer)
    {
        $customer->alamats()->delete();
        $customer->telepons()->delete();
        $customer->emails()->delete();
        $customer->delete();
        return redirect('/customer')->with('success', 'Customer berhasil dihapus');
    }
}

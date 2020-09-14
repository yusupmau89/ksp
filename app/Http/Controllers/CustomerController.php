<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('nama_customer', 'asc')->get();
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

        $customer = new Customer;
        $customer->nama_customer = $validated['nama_customer'];
        if (!empty($npwp))
            $customer->npwp = $validated['npwp'];
        $customer->alamat_pengiriman = $validated['alamat_pengiriman'];
        if (empty($validated['alamat_penagihan']))
            $customer->alamat_penagihan = $validated['alamat_pengiriman'];
        else $customer->alamat_penagihan = $validated['alamat_penagihan'];
        if (!empty($validated['email']))
            $customer->email = $validated['email'];
        if (!empty($validated['no_telepon']))
            $customer->no_telepon = $validated['no_telepon'];
        $customer->created_by = Auth::user()->id;
        $customer->slug = Str::slug($validated['nama_customer']);

        $customer->save();
        return redirect('/customer')->with('success', 'Customer berhasil ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('login.customer.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
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
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $validated = $request->validated();
        $npwp = preg_replace('/[^0-9]/', '', $validated['npwp']);

        $customer->nama_customer = $validated['nama_customer'];
        if (!empty($npwp))
            $customer->npwp = $validated['npwp'];
        else $customer->npwp = null;
        $customer->alamat_pengiriman = $validated['alamat_pengiriman'];
        if (empty($validated['alamat_penagihan']))
            $customer->alamat_penagihan = $validated['alamat_pengiriman'];
        else $customer->alamat_penagihan = $validated['alamat_penagihan'];
        if (!empty($validated['email']))
            $customer->email = $validated['email'];
        else $customer->email = null;
        if (!empty($validated['no_telepon']))
            $customer->no_telepon = $validated['no_telepon'];
        else $customer->no_telepon = null;
        $customer->slug = Str::slug($validated['nama_customer']);

        $customer->save();
        return redirect('/customer')->with('success', 'Customer berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect('/customer')->with('success', 'Customer berhasil dihapus');
    }
}

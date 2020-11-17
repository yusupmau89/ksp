<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_customer' => 'required',
            'npwp' => 'sometimes|unique:pengguna,npwp',
            'alamat_pengiriman' => 'required',
            'alamat_penagihan' => 'sometimes',
            'email' => 'nullable|email|unique:emails,email',
            'no_telepon' => 'sometimes|unique:telepon,no_telepon',
        ];
    }

    public function messages()
    {
        return [
            'nama_customer.required' => 'Nama Customer tidak boleh kosong',
            'npwp.unique' =>  'Nomor NPWP sudah ada',
            'alamat_pengiriman.required' => 'Alamat Pengiriman tidak boleh kosong',
            'email.unique' => 'Email sudah ada',
            'no_telepon.unique' => 'Nomor Telepon sudah ada',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'nama_customer' => strtoupper($this->nama_customer),
            'npwp' => implode('',$this->npwp),
            'alamat_pengiriman' => ucwords(strtolower($this->alamat_pengiriman)),
            'alamat_penagihan' => ucwords(strtolower($this->alamat_penagihan)),
        ]);
    }
}

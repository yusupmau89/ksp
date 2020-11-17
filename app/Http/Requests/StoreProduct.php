<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProduct extends FormRequest
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
            'kode_produk' => 'required|unique:products,kode_produk',
            'nama_produk' => 'required|unique:products,nama_produk',
            'jenis_produk' => 'required',
            'kategori' => 'required',
            'satuan_unit' => 'required',
            'harga' => 'required|numeric|min:0|not_in:0',
            'drawing' => 'sometimes|mimes:png,jpg,jpeg,pdf',
        ];
    }

    public function messages()
    {
        return [
            'kode_produk.required' => 'Kode Produk tidak boleh kosong',
            'kode_produk.unique' => 'Kode Produk sudah ada, silakan ganti',
            'nama_produk.required' => 'Nama Produk tidak boleh kosong',
            'nama_produk.unique' => 'Nama Produk sudah ada, silakan ganti',
            'jenis_produk.required' => 'Jenis Produk tidak boleh kosong',
            'kategori.required' => 'Kategori Produk tidak boleh kosong',
            'satuan_unit.required' => 'Satuan unit tidak boleh kosong',
            'drawing.mimes' => 'File Drawing harusa bertipe png, jpeg, jpg, atau pdf',
            'harga.not_in' => 'Harga harus lebih dari 0',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'kode_produk' => strtoupper($this->kode_produk),
            'nama_produk' => strtoupper($this->nama_produk),
            'satuan_unit' => ucfirst(strtolower($this->satuan_unit)),
        ]);
    }
}

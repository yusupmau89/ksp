<?php

namespace App\Http\Requests;

use App\Http\Controllers\PurchaseOrderController;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreListPo extends FormRequest
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
            'no_po' => 'required|unique:purchase_orders,nomor_po',
            'customer' => 'required',
            'tanggal_po' => 'required|date_format:d/m/Y',
            'tanggal_kirim' => 'required|date_format:d/m/Y|after:tanggal_po',
            'top' => 'required',
            'ppn' => 'required|in:Ya,Tidak',
            'product' => 'required',
            'product.*.produk' => 'required',
            'product.*.jumlah' => 'required|numeric|min:0|not_in:0',
            'product.*.harga' => 'required|numeric|min:0|not_in:0',
            'product.*.diskon' => 'numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'no_po.required' => 'Nomor PO tidak boleh kosong',
            'no_po.unique' => 'Nomor PO sudah ada',
            'customer.required' => 'Customer tidak boleh kosong',
            'tanggal_po.required' => 'Tanggal PO tidak boleh kosong',
            'tanggal_kirim.required' => 'Tanggal Pengiriman tidak boleh kosong',
            'tanggal_po.date' => 'Tanggal PO harus bertipe tanggal',
            'tanggal_kirim.date' => 'Tanggal Pengiriman harus bertipe tanggal',
            'tanggal_kirim.after' => 'Tanggal Pengiriman minimal 1 minggu setelah tanggal PO',
            'top.required' => 'Term of Payment tidak boleh kosong',
            'product.required' => 'Produk tidak boleh kosong',
            'product.*.jumlah.required' => 'Jumlah produk tidak boleh kosong',
            'product.*.harga.required' => 'Harga produk tidak boleh kosong',
            'product.*.jumlah.not_in' => 'Jumlah produk harus lebih dari 0',
            'product.*.harga.not_in' => 'Harga produk harus lebih dari 0',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'no_po' => strtoupper($this->no_po),
            'top' => strtoupper($this->top),
        ]);
    }
}

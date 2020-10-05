<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateSuratJalan extends FormRequest
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
            'no_po' => 'required',
            'no_surat_jalan' => 'required|unique:surat_jalans,no_surat_jalan,'.$this->sj->id,
            'tanggal_surat_jalan' => 'required|date_format:d/m/Y|after_or_equal:'.$this->purchase->tanggal_po,
            'signed_by' => 'required',
            'list' => 'required',
            'list.*.produk' => 'required',
            'list.*.purchase_list' => 'required',
            'list.*.jumlah' => 'required|numeric|min:0',
            'list.*.retur' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'no_po.required' => 'Nomor PO tidak boleh kosong',
            'no_surat_jalan.required' => 'Nomor Surat Jalan tidak boleh kosong',
            'no_surat_jalan.unique' => 'Nomor Surat Jalan sudah dipakai',
            'tanggal_surat_jalan.required' => 'Tanggal Surat Jalan tidak boleh kosong',
            'tanggal_surat_jalan.date' => 'Tanggal Surat Jalan harus bertipe tanggal',
            'tanggal_surat_jalan.after_or_equal' => 'Tanggal Surat Jalan tidak boleh kurang dari tanggal PO',
            'list.required' => 'Produk yang dikirim tidak boleh kosong',
            'list.*.produk.required' => 'Nama Produk tidak boleh kosong',
            'list.*.purchase_list.required' => 'Nama List tidak boleh kosong',
            'list.*.jumlah.required' => 'Jumlah produk yang dikirim tidak boleh kosong',
            'list.*.jumlah.numeric' => 'Jumlah produk yang dikirim harus bertipe angka',
            'list.*.jumlah.min' => 'Jumlah produk yang dikirim minimal 0',
            'list.*.retur.required' => 'Jumlah retur yang dikembalikan tidak boleh kosong',
            'list.*.retur.numeric' => 'Jumlah retur yang dikembalikan harus bertipe angka',
            'list.*.retur.min' => 'Jumlah retur yang dikembalikan minimal 0',
            'signed_by.required' => 'Penanda tangan tidak boleh kosong',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'no_po' => strtoupper($this->no_po),
            'no_surat_jalan' => strtoupper($this->no_surat_jalan),
        ]);
    }
}

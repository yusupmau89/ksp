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
            'no_surat_jalan' => 'required|unique:surat_jalans,no_surat_jalan,'.$this->sj->id,
            'tanggal_surat_jalan' => 'required|date_format:d/m/Y|after_or_equal:'.$this->purchase->tanggal_po,
            'kendaraan' => 'nullable',
            'plat_no' => 'nullable|alpha_num',
            'pengirim' => 'nullable|regex:/^[a-zA-Z."\'\s]+$/',
            'signed_by' => 'required|regex:/^[a-zA-Z."\'\s]+$/',
            'list' => 'required',
            'list.*.purchase_list' => 'required',
            'list.*.jumlah' => 'required|numeric|min:0',
            'list.*.retur' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute sudah dipakai',
            'regex' => ':attribute diisi dengan nama',
            'date_format' => 'Format Tanggal :attribute harus dd/mm/yyyy',
            'after_or_equal' => ':attribute minimal sama dengan tanggal PO',
            'alpha_num' => ':attribute diisi dengan angka dan huruf serta tidak boleh ada spasi',
            'numeric' => ':attribute diisi dengan angka',
            'min' => ':attribute minimal diisi :value',
        ];
    }

    public function attributes()
    {
        return [
            'no_surat_jalan' => 'Nomor Surat Jalan',
            'tanggal_surat_jalan' => 'Tanggal Surat Jalan',
            'kendaraan' => 'Kendaraan',
            'plat_no' => 'Plat Nomor',
            'pengirim' => 'Pengendara',
            'signed_by' => 'Penanda Tangan',
            'list' => 'Produk',
            'list.*.purchase_list' => 'Nama List',
            'list.*.jumlah' => 'Jumlah Produk',
            'list.*.retur' => 'Retur',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'no_surat_jalan' => strtoupper($this->no_surat_jalan),
            'kendaraan' => empty($this->kendaraan)?null:ucwords(strtolower($this->kendaraan)),
            'plat_no' => empty($this->kendaraan)?null:strtoupper($this->plat_no),
            'pengirim' => empty($this->kendaraan)?null:ucwords(strtolower($this->pengirim)),
        ]);
    }
}

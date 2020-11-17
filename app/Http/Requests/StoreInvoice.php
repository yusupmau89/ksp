<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInvoice extends FormRequest
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
            'no_invoice' => 'required',
            'tanggal_invoice' => 'required|date_format:d/m/Y|after_or_equal:'.$this->purchase->tanggal_po,
            'jumlah' => 'required|min:0',
            'signed_by' => 'required',
            'list' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'no_invoice.required' => 'Nomor Invoice tidak boleh kosong',
            'tanggal_invoice.required' => 'Tanggal Invoice tidak boleh kosong',
            'tanggal_invoce.date_format' => 'Format tanggal dd/mm/yyyy (tanggal/bulan/tahun)',
            'tanggal_invoice.after_or_equal' => 'Tanggal Invoice minimal harus sama dengan tanggal PO',
            'jumlah.required' => 'Jumlah tidak boleh kosong',
            'jumlah.min' => 'Jumlah minimal 0',
            'signed_by.required' => 'Penanda tangan tidak boleh kosong',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'no_invoice' => strtoupper($this->no_invoice),
        ]);
    }
}

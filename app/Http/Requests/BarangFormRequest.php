<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama'           => 'required|min:6',
            'harga_beli'     => 'required|numeric',
            'harga_jual'     => 'required|numeric',
            'stok'           => 'required|numeric',
        ];
    }
}

<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class PosSettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'paytr_id' => ['required'],
            'paytr_salt' => ['required'],
            'paytr_key' => ['required'],
            'cash_on_delivery_enabled' => ['required', 'boolean'],
        ];
    }
}

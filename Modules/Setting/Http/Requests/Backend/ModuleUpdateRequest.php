<?php

namespace Modules\Setting\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ModuleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'live_support' => ['sometimes'],
            'google_analystics' => ['sometimes'],
            'google_play' => ['sometimes'],
            'app_store' => ['sometimes'],
            'google_maps' => ['sometimes'],
            'google_place_id' => ['sometimes'],
            'google_api_key' => ['sometimes'],
            'google_client_id' => ['nullable', 'string'],
            'google_client_secret' => ['nullable', 'string'],
            'google_redirect_uri' => ['nullable', 'string'],
            'facebook_client_id' => ['nullable', 'string'],
            'facebook_client_secret' => ['nullable', 'string'],
            'facebook_redirect_uri' => ['nullable', 'string'],
            'referance_earning' => ['sometimes'],
            'min_widthdraw' => ['sometimes'],
            'free_cargo' => ['sometimes'],
        ];
    }
}

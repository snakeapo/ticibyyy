<?php

namespace Modules\Product\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['sometimes'],
            'feature' => ['sometimes'],
            'installment' => ['sometimes'],
            'category' => ['required', 'exists:categories,id'],
            'sub_category' => ['required', 'exists:subcategories,id'],
            'brand' => ['required'],
            'price' => ['required'],
            'sale_price' => ['sometimes'],
            'stock' => ['required'],
            'our_choice' => ['sometimes'],
            'best_selling' => ['sometimes'],
            'meta_title' => ['sometimes'],
            'meta_keyw' => ['sometimes'],
            'meta_desc' => ['sometimes'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Ürün başlığı zorunludur.',

            'category.required' => 'Kategori seçimi zorunludur.',
            'category.exists' => 'Seçilen kategori geçersizdir.',

            'sub_category.required' => 'Alt kategori seçimi zorunludur.',
            'sub_category.exists' => 'Seçilen alt kategori geçersizdir.',

            'brand.required' => 'Marka bilgisi zorunludur.',

            'price.required' => 'Ürün fiyatı zorunludur.',

            'stock.required' => 'Stok bilgisi zorunludur.',

            'image.required' => 'Ürün görseli zorunludur.',
            'image.image' => 'Yüklenen dosya bir görsel olmalıdır.',
            'image.mimes' => 'Görsel formatı sadece jpg, jpeg, png, webp veya svg olabilir.',
            'image.max' => 'Görsel boyutu en fazla 4MB olabilir.',
        ];
    }
}

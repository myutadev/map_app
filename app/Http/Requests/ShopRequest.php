<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ShopRule;

class ShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:2000',
            'address' => 'required|string|max:500',
            'latitude' => [new ShopRule], // 'require'|'numeric'を残すとShopRuleのバリデーションの前にデフォルトのバリデーションでエラーを返してしまうので入れない
            // longitudeのバリデーションを入れると重複して表示されるので,latitudeのみにShopRuleを適応
        ];
    }
}

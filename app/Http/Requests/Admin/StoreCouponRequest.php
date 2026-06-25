<?php

namespace App\Http\Requests\Admin;

use App\Enums\CouponType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('create-coupons');
    }

    public function rules(): array
    {
        $couponId = $this->route('coupon')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::unique('coupons', 'code')->ignore($couponId),
            ],

            'type' => [
                'required',
                Rule::enum(CouponType::class),
            ],

            'value' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) {
                    if (
                        $this->type === CouponType::PERCENTAGE->value &&
                        $value > 100
                    ) {
                        $fail('نسبة الخصم لا يمكن أن تتجاوز 100%.');
                    }
                },
            ],

            'min_order_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'max_discount_amount' => [
                Rule::requiredIf(
                    $this->type === CouponType::PERCENTAGE->value
                ),
                'nullable',
                'numeric',
                'min:0',
            ],

            'is_active' => [
                'boolean',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'max_uses' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'max_uses_per_user' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'كود الكوبون مطلوب',
            'code.unique' => 'هذا الكود موجود بالفعل',
            'code.regex' => 'الكود يجب أن يحتوي على حروف وأرقام فقط ويمكن استخدام - أو _',

            'type.required' => 'نوع الخصم مطلوب',
            'type.enum' => 'نوع الكوبون غير صحيح',

            'value.required' => 'قيمة الخصم مطلوبة',

            'expires_at.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية',

            'max_discount_amount.required' => 'الحد الأقصى للخصم مطلوب عند اختيار خصم بالنسبة المئوية',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code' => $this->code
                ? strtoupper(trim($this->code))
                : null,

            'is_active' => $this->boolean('is_active'),
        ]);
    }
}

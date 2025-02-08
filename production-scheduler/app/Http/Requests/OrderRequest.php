<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;
use Illuminate\Validation\Validator;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'need_by_date'   => ['required', 'date', 'after:now'],
            'product_type'   => ['required', 'string'], 
            'product_ids'    => ['required', 'array'],
            'quantities'     => ['required', 'array'],
            'quantities.*'   => ['required', 'integer', 'min:1'], 
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $this->validateSameProductType($this->product_ids, function ($message) use ($validator) {
                $validator->errors()->add('product_ids', $message);
            });
        });
    }

    private function validateSameProductType($value, $fail)
    {
        if (!is_array($value) || empty($value)) {
            $fail("The product list must not be empty.");
            return;
        }

        $firstProductType = null;

        foreach ($value as $productId) {
            $product = Product::find($productId);
            if (!$product) {
                $fail("One or more selected products are invalid.");
                return;
            }

            if (is_null($firstProductType)) {
                $firstProductType = $product->type;
            } elseif ($product->type !== $firstProductType) {
                $fail("All products must be of the same type.");
                return;
            }
        }
    }
}
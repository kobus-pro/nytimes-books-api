<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Validation\Rules\Isbn;

class BestSellersListRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => ['nullable', 'string'],
            'isbns' => ['nullable', 'array'],
            'isbns.*' => ['string', new Isbn()],
            'title' => ['nullable', 'string'],
            'offset' => [
                'nullable',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if (is_numeric($value) && 0 !== $value % 20) {
                        $fail('The ' . $attribute . ' must be a multiple of 20.');
                    }
                },
            ],
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if (null !== $key) {
            return $validated;
        }

        if (isset($validated['isbns']) && is_array($validated['isbns'])) {
            $validated['isbn'] = implode(';', $validated['isbns']);

            unset($validated['isbns']);
        }

        return $validated;
    }
}

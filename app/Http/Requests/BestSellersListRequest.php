<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Intervention\Validation\Rules\Isbn;

class BestSellersListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => ['nullable', 'string'],
            'isbns' => ['nullable', 'array'],
            'isbns.*' => ['string', new Isbn()],
            'title' => ['nullable', 'string'],
            'offset' => ['nullable', 'integer', 'min:0', 'multiple_of:20']
        ];
    }

    /**
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Carbon\Carbon;

class CreateTodoRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'due_date' => [function ($attribute, $value, $fail) {
                $formats = ['d-m-Y', 'Y-m-d', 'm/d/Y'];
                $isValid = false;

                foreach ($formats as $format) {
                    try {
                        \Carbon\Carbon::createFromFormat($format, $value);
                        $isValid = true;
                        break;
                    } catch (\Carbon\Exceptions\InvalidFormatException $e) {

                    }
                }

                if (!$isValid) {
                    $fail("The $attribute must be a valid date in one of the formats: " . implode(', ', $formats));
                }
            }],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], 422));
    }
}

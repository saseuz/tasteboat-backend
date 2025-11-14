<?php

namespace App\Http\Requests;

use App\Enums\Enums\RecipeDifficulty;
use App\Enums\Enums\RecipeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RecipeApiRequest extends FormRequest
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
            'cuisine_id' => 'required|exists:cuisines,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'prep_time' => 'required|integer|min:1',
            'cook_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'difficulty' => ['required', new Enum(RecipeDifficulty::class)],
            'status' => ['required', new Enum(RecipeStatus::class)],
            'image' => 'nullable|image|max:2048',

            'categories' => 'required|json|min:1',
            'categories.*' => 'exists:categories,id',
            
            'ingredients' => 'required|json|min:1',
            'ingredients.*.name' => 'required|string|max:255',
            'ingredients.*.quantity' => 'required|number|max:100',
            'ingredients.*.unit' => 'required|string|max:100',
            'ingredients.*.note' => 'nullable|string|max:255',
        ];
    }
}

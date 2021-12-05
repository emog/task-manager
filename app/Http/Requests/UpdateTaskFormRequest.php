<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskFormRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'          => [
                'required',
                Rule::exists('tasks', 'id')->where('user_id', auth()->id())
            ],
            'name'        => 'required|max:255',
            'description' => 'nullable|max:255',
        ];
    }
}

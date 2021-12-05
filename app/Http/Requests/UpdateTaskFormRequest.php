<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'id'          => 'required|exists:tasks,id',
            'name'        => 'required|max:255',
            'description' => 'nullable|max:255',
        ];
    }
}

<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }

    public function createRules(): array
    {
        return [
            'employeeno' => 'required|string|max:191',
            'icno' => 'required|string',
            'address' => 'required|string|max:191',
            'contactno' => 'required|string',
            'name' => 'required|string|max:191',
            'email' => 'required|email',
            'workbase_id' => 'required|integer|exists:workbases,id',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }

    public function updateRules(): array
    {
        return [
            'employeeno' => 'required|string|max:191',
            'icno' => 'required|string',
            'address' => 'required|string|max:191',
            'contactno' => 'required|string',
            'name' => 'required|string|max:191',
            'email' => 'required|email',
            'workbase_id' => 'required|integer|exists:workbases,id',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }
}

<?php

namespace App\Http\Requests\Employees;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
            'employee_id' => 'required|integer|exists:employees,id',
            'workbase_id' => 'required|integer|exists:workbases,id',
            'PO_number' => 'required|string',
            'PO_start' => 'required|date',
            'PO_end' => 'required|date',
            'PO_normal_rate' => 'required|string',
            'PO_OT_rate' => 'required|string',
            
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }

    public function updateRules(): array
    {
        return [
            'employee_id' => 'required|integer|exists:employees,id',
            'workbase_id' => 'required|integer|exists:workbases,id',
            'PO_number' => 'required|string',
            'PO_start' => 'required|date',
            'PO_end' => 'required|date',
            'PO_normal_rate' => 'required|string',
            'PO_OT_rate' => 'required|string',
            // 'tags' => 'required|array',
            // 'photo' => 'sometimes|files',
        ];
    }

}

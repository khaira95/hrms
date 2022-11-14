<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PurchaseOrder;
use App\Models\WorkBase;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function index()
    {
        $employees = Employee::count();
        $workbases = WorkBase::count();
        $purchaseorders = PurchaseOrder::count();

        // $employees = $this->employee->latest()->with('workbase')->paginate(10);
        return $this->sendResponse([
            'employees'=>$employees,
            'workbases'=>$workbases,
            'purchaseorders'=>$purchaseorders
        ], 'Dashboard list');
        
    }

    public function purchaseOrderDetails(Request $request)
    {
        $purchaseorders = PurchaseOrder::whereMonth('PO_end', $request->date)->latest()->with('workbase','employee')->paginate(10);
        return $this->sendResponse($purchaseorders, 'Purchase Order Details list');
        
    }

}

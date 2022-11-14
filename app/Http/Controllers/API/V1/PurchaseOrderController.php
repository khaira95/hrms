<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employees\PurchaseOrderRequest;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class PurchaseOrderController extends BaseController
{
    protected $purchaseorder = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PurchaseOrder $purchaseorder)
    {
        $this->middleware('auth:api');
        $this->purchaseorder = $purchaseorder;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseorders = $this->purchaseorder->latest()->with('workbase','employee')->paginate(10);

        return $this->sendResponse($purchaseorders, 'PO list');
    }

    public function searchEmployee(Request $request)
    {
        $purchaseorders = $this->purchaseorder
        ->where('employee_id', $request->employee_id)
        ->with('workbase','employee')->paginate(10);

        return $this->sendResponse($purchaseorders, 'Search Completed');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrderRequest $request)
    {
        $purchaseorder = $this->purchaseorder->create([
            'employee_id' => $request->get('employee_id'),
            'workbase_id' => $request->get('workbase_id'),
            'PO_number' => $request->get('PO_number'),
            'PO_start' => $request->get('PO_start'),
            'PO_end' => $request->get('PO_end'),
            'PO_normal_rate' => $request->get('PO_normal_rate'),
            'PO_OT_rate' => $request->get('PO_OT_rate'),
        ]);

        return $this->sendResponse($purchaseorder, 'Purchase order list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseorder = $this->purchaseorder->findOrFail($id);

        return $this->sendResponse($purchaseorder, 'Purchase Order Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrderRequest $request, $id)
    {
        $purchaseorder = $this->purchaseorder->findOrFail($id);

        $purchaseorder->update($request->all());

        return $this->sendResponse($purchaseorder, 'Purchase Order Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->authorize('isAdmin');

        $purchaseorder = $this->purchaseorder->findOrFail($id);

        $purchaseorder->delete();

        return $this->sendResponse($purchaseorder, 'Purchase Order has been Deleted');
    }
}

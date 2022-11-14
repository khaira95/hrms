<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Employees\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    protected $employee = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Employee $employee)
    {
        $this->middleware('auth:api');
        $this->employee = $employee;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = $this->employee->latest()->with('workbase')->paginate(10);

        return $this->sendResponse($employees, 'Employee list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
    //     $employees = $this->employee
    //     ->pluck('name', 'id')
    //     ->sortByDesc();
        $employees = Employee::orderBy('name')->get();

        return $this->sendResponse($employees, 'Employee list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employee = $this->employee->create([
            'employeeno' => $request->get('employeeno'),
            'name' => $request->get('name'),
            'icno' => $request->get('icno'),
            'contactno' => $request->get('contactno'),
            'email' => $request->get('email'),
            'address' => $request->get('address'),
            'designation' => $request->get('designation'),
            'workbase_id' => $request->get('workbase_id'),
            'fieldstudy' => $request->get('fieldstudy'),
            'educationlevel' => $request->get('educationlevel'),
            'cvno' => $request->get('cvno'),
        ]);

        return $this->sendResponse($employee, 'Successfully Create Staff');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = $this->employee->findOrFail($id);

        return $this->sendResponse($employee, 'Employee Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employee = $this->employee->findOrFail($id);

        $employee->update($request->all());

        return $this->sendResponse($employee, 'Employee Information has been updated');
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

        $employee = $this->employee->findOrFail($id);

        $employee->delete();

        return $this->sendResponse($employee, 'Employee has been Deleted');
    }
}

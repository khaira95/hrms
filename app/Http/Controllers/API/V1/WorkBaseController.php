<?php

namespace App\Http\Controllers\API\V1;

use App\Models\WorkBase;
use Illuminate\Http\Request;

class WorkBaseController extends BaseController
{
    protected $workbase = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WorkBase $workbase)
    {
        $this->middleware('auth:api');
        $this->workbase = $workbase;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workbases = $this->workbase->latest()->paginate(10);

        return $this->sendResponse($workbases, 'WorkBase list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $workbases = $this->workbase->pluck('name', 'id');

        return $this->sendResponse($workbases, 'Work Base list');
    }


    /**
     * Store a newly created resource in storage.
     *
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $workbases = $this->workbase->create([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'remarks' => $request->get('remarks'),
        ]);

        return $this->sendResponse($workbases, 'WorkBase Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $workbases = $this->workbase->findOrFail($id);

        $workbases->update($request->all());

        return $this->sendResponse($workbases, 'WorkBase Information has been updated');
    }

    public function destroy($id)
    {
        // $this->authorize('isAdmin');

        $workbase = $this->workbase->findOrFail($id);

        $workbase->delete();

        return $this->sendResponse($workbase, 'Work Base has been Deleted');
    }
}

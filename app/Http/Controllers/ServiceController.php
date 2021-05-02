<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = DB::table('services')->where('status', 't');

        if ($request->get('type') != '') {
            $services->where('type', $request->get('type'));
        }

        return response()->json(['data' => $services->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service = Service::where('service_name', $request->get('service_name'))
            ->where('unit_type', $request->get('unit_type'))
            ->where('type', $request->get('type'))
            ->where('status', 't')
            ->first();

        if ($service) {
            return response()->json(['error' => 'service name is exists'], 202);
        }

        $request['user_id'] = Auth::id();

        Service::create($request->all());

        return response()->json(['message' => 'service create successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::where('id', $id)->where('status', 't')->first();

        if ($service) {
            return response()->json(['data' => $service], 200);
        }

        return response()->json(['error' => 'service id not found.'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $service = Service::where('service_name', $request->get('service_name'))
            ->where('unit_type', $request->get('unit_type'))
            ->where('type', $request->get('type'))
            ->where('status', 't')
            ->where('id', '!=', $id)
            ->first();

        if ($service) {
            return response()->json(['error' => 'service is exist.'],203);
        }

        Service::where('id',$id)->update($request->all());

        return response()->json(['message' => 'service update successfully.'],201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::where('id', $id)->where('status', 't')->first();

        if ($service) {
            $service->status = 'f';
            $service->user_id = Auth::id();
            $service->save();

            return response()->json(['message' => 'service id was deleted.'], 202);
        }

        return response()->json(['error' => 'service id not found.'], 404);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $agents = DB::table('agents');

        return response()->json(['data' => $agents->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $agent_name = DB::table('agents')
            ->where('agent_name', $request->get('agent_name'))
            ->where('status', 'Enable')
            ->first();

        if (isset($agent_name)) {
            return response()->json(['error' => 'agent name is exist.'], 203);
        }

        $agent_phone = DB::table('agents')
            ->where('tel', $request->get('tel'))
            ->where('status', 'Enable')
            ->first();

        if (isset($agent_phone)) {
            return response()->json(['error' => 'agent phone is exist.'], 203);
        }


        $request['user_id'] = Auth::id();

        Agent::create($request->all());

        return response()->json(['message' => 'Agent create successfully.'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agent = Agent::where('id', $id)->Where('status', 'Enable')->first();

        if ($agent) {
            return response()->json(['data' => $agent], 200);
        }

        return response()->json(['error' => 'agent id not found.'], 404);
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
        $agent_name = Agent::where('agent_name', $request->get('agent_name'))
            ->where('status', 'Enable')
            ->where('id', '!=', $id)
            ->first();

        if (isset($agent_name)) {
            return response()->json(['error' => 'Agent name is exist.']);
        }

        $agent_phone = Agent::where('tel', $request->get('tel'))
            ->where('status', 'Enable')
            ->where('id', '!=', $id)
            ->first();

        if (isset($agent_phone)) {
            return response()->json(['error' => 'phone is exist.']);
        }

        $request['user_id'] = Auth::id();

        Agent::where('id', $id)->update($request->all());


        return response()->json(['message' => 'Agent update successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = Agent::where('id', $id)->where('status', 'Enable')->first();

        if ($agent) {
            $agent->status = 'Disable';
            $agent->user_id = Auth::id();
            $agent->save();

            return response()->json(['message' => 'agent id was deleted.'], 201);
        }

        return response()->json(['error' => 'agent id not found.'], 404);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use Carbon\Carbon;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $groups = Group::where('group_disable',0)->get();
        foreach($groups as $group){
            $group->view_group=[
                'href'=>'api/v1/group/'.$group->group_id,
                'method'=>'GET'
            ];
        };

        $response = [
            'msg'=>'List of all Groups',
            'data'=>$groups
        ];

        return response()->json($response,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'group_id'=>'required|unique:mst_group,group_id',
            'group_name'=>'required',
        ]);
        
        $groupId = $request -> input('group_id');
        $groupName = $request->input('group_name');
        $groupDescription = $request->input('group_description');
        $groupDisable = 0;
        
        $group = new Group ([
            'group_id' => $groupId,
            'group_name' => $groupName,
            'group_description' => $groupDescription,
            'group_disable' => $groupDisable,
        ]);

       
        if($group->save()){
            $group->view_groups=[
                'href'=>'api/v1/group/'.$group->group_id,
                'method'=>'GET'
            ];
            $message=[
                'msg'=>'Group created',
                'data'=>$group
            ];
            return response()->json($message,201);
        }

        $response = [
            'msg' => 'Error during creation'
        ];

        return response()->json($response,404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $group = Group::where('group_id',$id)->firstOrFail();
        $group->view_groups=[
            'href'=>'api/v1/group',
            'method'=>'GET'
        ];

        $response = [
            'msg'=>'group Information',
            'data'=>$group
        ];

        return response()->json($response,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        
        $groupDescription = $request->input('group_description');

        $group = Group::findOrFail($id);

        $group->group_description = $groupDescription;

        if(!$group->update()){
            return response()-json([
                'msg'=>'Error during update'
            ],404);
        }

        $group->view_groups=[
            'href'=>'api/v1/group/'.$group->group_id,
            'method'=>'GET'
        ];

        $response=[
            'msg'=>'Group Updated',
            'data'=>$group
        ];

        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $group = Group::findOrFail($id);
        $group->group_disable = 1;

        if(!$group->update()){
            return response()-json([
                'msg'=>'Error during delete'
            ],404);
        }

        $group->view_groups=[
            'href'=>'api/v1/group/'.$group->group_id,
            'method'=>'GET'
        ];

        $response=[
            'msg'=>'Group deleted',
            'data'=>$group
        ];

        return response()->json($response,200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Region;
use Carbon\Carbon;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $regions = Region::with('regionDetail')->where('region_disable',0)->orderBy('region_id','asc')->get();
        foreach($regions as $region){
            $region->view_region=[
                'href'=>'api/v1/region/'.$region->region_id,
                'method'=>'GET'
            ];
        };

        $response = [
            'msg'=>'List of all regions',
            'data'=>$regions
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
            'region_name'=>'required|unique:mst_region,region_name',
        ]);
        

        $regionName = $request->input('region_name');
        $regionDescription = $request->input('region_description');
        $regionDisable = 0;
        
        $region = new Region ([
            'region_name' => $regionName,
            'region_description' => $regionDescription,
            'region_disable' => $regionDisable,
        ]);

       
        if($region->save()){
            $region->view_regions=[
                'href'=>'api/v1/region/'.$region->region_id,
                'method'=>'GET'
            ];
            $message=[
                'msg'=>'Region created',
                'data'=>$region
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
        $region = Region::with('regionDetail')->where('region_id',$id)->firstOrFail();
        $region->view_regions=[
            'href'=>'api/v1/region',
            'method'=>'GET'
        ];

        $response = [
            'msg'=>'region Information',
            'data'=>$region
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
        
        $regionName = $request->input('region_name');
        $regionDescription = $request->input('region_description');

        $region = Region::findOrFail($id);

        $region->region_name = $regionName;
        $region->region_description = $regionDescription;

        if(!$region->update()){
            return response()-json([
                'msg'=>'Error during update'
            ],404);
        }

        $region->view_regions=[
            'href'=>'api/v1/region/'.$region->region_id,
            'method'=>'GET'
        ];

        $response=[
            'msg'=>'Region Updated',
            'data'=>$region
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
        $region = Region::findOrFail($id);
        $region->region_disable = 1;

        if(!$region->update()){
            return response()-json([
                'msg'=>'Error during delete'
            ],404);
        }

        $region->view_regions=[
            'href'=>'api/v1/region/'.$region->region_id,
            'method'=>'GET'
        ];

        $response=[
            'msg'=>'region deleted',
            'data'=>$region
        ];

        return response()->json($response,200);
    }
}

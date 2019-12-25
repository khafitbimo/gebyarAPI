<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Channel;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $channels = Channel::where('channel_disable',0)->get();
        foreach($channels as $channel){
            $channel->view_channel=[
                'href'=>'api/v1/channel/'.$channel->channel_id,
                'method'=>'GET'
            ];
        };

        $response = [
            'msg'=>'List of all Channels',
            'data'=>$channels
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
            'channel_id'=>'required|unique:mst_channel,channel_id',
            'channel_name'=>'required',
            'channel_createby'=>'required'
        ]);
        
        $channelId = $request -> input('channel_id');
        $channelName = $request->input('channel_name');
        $channelDescription = $request->input('channel_description');
        $channelDate = $request->input('channel_date');
        $channelCreateBy = $request->input('channel_createby');
        $channelCreateDt = Carbon::now();
        $channelModifiedBy = $request->input('channel_modifiedby');
        $channelModifiedDt = $request->input('channel_modifieddt');
        $channelDisable = 0;
        $channelDisableDt = $request->input('channel_disabledt');
        
        $channel = new Channel ([
            'channel_id' => $channelId,
            'channel_name' => $channelName,
            'channel_description' => $channelDescription,
            'channel_date' => $channelDate,
            'channel_createby' => $channelCreateBy,
            'channel_createdt' => $channelCreateDt,
            'channel_modifiedby' => $channelModifiedBy,
            'channel_modifieddt' => $channelModifiedDt,
            'channel_disable' => $channelDisable,
            'channel_disabledt' => $channelDisableDt
        ]);

       
        if($channel->save()){
            $channel->view_channels=[
                'href'=>'api/v1/channel/'.$channel->channel_id,
                'method'=>'GET'
            ];
            $message=[
                'msg'=>'Channel created',
                'data'=>$channel
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
        $channel = Channel::where('channel_id',$id)->firstOrFail();
        $channel->view_channels=[
            'href'=>'api/v1/channel',
            'method'=>'GET'
        ];

        $response = [
            'msg'=>'Channel Information',
            'data'=>$channel
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
        // $this->validate($request,[
        //     'channel_id'=>'required|unique:mst_channel,channel_id',
        //     'channel_name'=>'required',
        //     'channel_createby'=>'required'
        // ]);
        
        
        $channelDescription = $request->input('channel_description');
        $channelDate = $request->input('channel_date');
        $channelModifiedBy = $request->input('channel_modifiedby');
        $channelModifiedDt = Carbon::now();

        $channel = Channel::findOrFail($id);

        $channel->channel_description = $channelDescription;
        $channel->channel_date = $channelDate;
        $channel->channel_modifiedby = $channelModifiedBy;
        $channel->channel_modifieddt = $channelModifiedDt;

        if(!$channel->update()){
            return response()-json([
                'msg'=>'Error during update'
            ],404);
        }

        $channel->view_channels=[
            'href'=>'api/v1/channel/'.$channel->channel_id,
            'method'=>'GET'
        ];

        $response=[
            'msg'=>'Channel Updated',
            'data'=>$channel
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
        $channel = Channel::findOrFail($id);
        $channel->channel_disable = 1;
        $channel->channel_disabledt = Carbon::now();

        if(!$channel->update()){
            return response()-json([
                'msg'=>'Error during delete'
            ],404);
        }

        $channel->view_channels=[
            'href'=>'api/v1/channel/'.$channel->channel_id,
            'method'=>'GET'
        ];

        $response=[
            'msg'=>'Channel deleted',
            'data'=>$channel
        ];

        return response()->json($response,200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakeGreetingRequest;
use App\Http\Resources\GreetingResource;
use App\Models\Greeting;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class GreetingsController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GreetingResource::collection(
            Greeting::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MakeGreetingRequest $request)
    {
        $request->validated($request->all());

        $greeting = Greeting::create(
            [
                'name' => $request->name,
                'relation' => $request->relation,
                'icon' => $request->icon,
                'message' => $request->message,
            ]
        );

        return new GreetingResource($greeting);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Greeting $greeting)
    {
        return new GreetingResource($greeting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO
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
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Greeting $greeting)
    {
        $greeting->delete();
        return response('', 204);
    }
}

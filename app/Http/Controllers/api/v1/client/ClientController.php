<?php

namespace App\Http\Controllers\api\v1\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use Validator;

class ClientController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required|string|min:3|max:255,unique:clients',
            'email' => 'required|email|max:255|unique:clients',
            'mobile' => 'required|max:255|min:8|unique:clients',
        ]);

        if ($validator->fails())
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()),422);
        try{
            $client = new Client();
            $client->name = $request->name;
            $client->email = $request->email;
            $client->mobile = $request->mobile;
            $client->save();
        }

        catch(Exception $exception)
        {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()),422);
        }
        return response()->json(['message'=>"added successfully",'client'=> $client],201);
    }

}

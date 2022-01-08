<?php

namespace App\Http\Controllers\api\v1\invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\api\v1\client\ClientController;
use App\Client;
use App\Invoice;
use Validator;

class InvoiceController extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>  'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|max:255|min:8',
            'due_date' => 'required|date',
            'amount' => 'required|numeric|gt:0',
        ]);

        if ($validator->fails())
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()),422);
		$clientId = $this->checkIfClientExists($request->email);
	    if(!$clientId){
			$client = new ClientController();
			$storeResponse = $client->store($request);
			if($storeResponse->status() != 201){
				// client not added, return the error response
				return $storeResponse;
			}
			else{
				// get added client id 
                $data = json_decode(json_encode($storeResponse->getData()), true);
				$clientId = $data["client"]["id"];
			}
	    }

	    // store invoice
        $invoice = new Invoice();
        $invoice->client_id = $clientId;
        $invoice->due_date = $request->due_date;
        $invoice->amount = $request->amount;
        $invoice->save();
	    // send mail

        Mail::send('emails.invoice',$invoice->toArray(),
            function($message) use ($invoice) {
                $message->to($invoice->client->email,'Your Invoice')->subject('Invoice');
            });
        return response()->json(['message'=>"added successfully",'invoice'=> $invoice],201);

    }

    public function checkIfClientExists($email)
    {    
        return Client::where('email',$email)->value('id');
    }
}

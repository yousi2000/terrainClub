<?php

namespace App\Http\Controllers;


use App\Models\Clients;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientsRequest;
use App\Http\Requests\UpdateClientsRequest;
use Validator;
class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $clients = Clients::all(); // Récupère tous les clients
        return response()->json($clients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Client = new Clients();
        $request->validate([
            'Prenom'=>'required',
            'Nom'=>'required',
            'Email'=>'required',
            'Tel'=>'required',
       
        ]);
        $Client->Prenom=$request->Prenom;
        $Client->Nom=$request->Nom;
        $Client->Email=$request->Email;
        $Client->Tel=$request->Tel;
        $result= $Client->save();
        if($result) {
          
            return response()->json(['message' =>'You signed up correctly']);
        }else {
            return response()->json(['errors'=>$request->validate->errors()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
            // Validation déjà effectuée par StoreClientsRequest
        
            // Créer un nouveau client        
        $validator = Validator::make($request->all(), [
            'Prenom' => 'required',
            'Nom' => 'required',
            'Email' => 'required|email|unique:clients,Email',
            'Tel' => 'required',
        ]);

        if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
        }
    else{


        // Créer un nouveau client
        $client = new Clients();
        $client->Prenom = $request->Prenom;
        $client->Nom = $request->Nom;
        $client->Email = $request->Email;
        $client->Tel = $request->Tel;
        $client->save();
        return response()->json(['message' => 'Client created successfully'], 201);
        // Sauvegarder le client
    }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function show(Clients $clients)
    {
        //
        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function edit(Clients $clients)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientsRequest  $request
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'Prenom' => 'required|string|max:255',
            'Nom' => 'required|string|max:255',
            'Email' => 'required|email|max:255',
            'Tel' => 'required|int|min:10',
        ]);

        // Find the client by ID
        $client = Clients::find($id);

        // Check if client exists
        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        // Update the client fields
        $client->Prenom = $validated['Prenom'];
        $client->Nom = $validated['Nom'];
        $client->Email = $validated['Email'];
        $client->Tel = $validated['Tel'];

        // Save the updated client
        if ($client->save()) {
            return response()->json(['message' => 'Client updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'Update failed.'], 500);
        }
    
       /* $validator = Validator::make($request->all(), [
            'Prenom' => 'required|string|max:255',
            'Nom' => 'required|string|max:255',
            'Email' => 'required|email|unique:clients,Email',
            'Tel' => 'required|string|max:20',
        ]);


        $client->Prenom = $request->input('Prenom', $client->Prenom);
        $client->Nom = $request->input('Nom', $client->Nom);
        $client->Email = $request->input('Email', $client->Email);
        $client->Tel = $request->input('Tel', $client->Tel);

        if ($client->save()) {
            return response()->json(['message' => 'Client updated successfully']);
        } else {
            return response()->json(['error' => 'Client update failed'], 500);
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $client = Clients::find($id);
        if ($client->delete()) {
            return response()->json(['message' => 'Client deleted successfully']);
        } else {
            return response()->json(['error' => 'Client deletion failed'], 500);
        }
    }
}

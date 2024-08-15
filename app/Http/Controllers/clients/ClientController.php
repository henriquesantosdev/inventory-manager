<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\client\StoreClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('name')) {
            $query->where('clientName', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phoneNumber', 'like', '%' . $request->phone . '%');
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('content.clients.clientsIndex', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.clients.clientsCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $data = $request->only([
            'clientName',
            'phoneNumber'
        ]);

        $created = Client::create($data);

        if ($created) {
            return redirect()
                ->route('clients.create')
                ->with(['successMessage' => 'Cliente registrado com sucesso!']);
        }

        return redirect()
            ->route('clients.create')
            ->with(['errorMessage' => 'Não foi possível registrar o cliente!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        if ($client) {
            return view('content.clients.clientsShow', compact('client'));
        }

        return view('dashboard.home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('content.clients.clientsEdit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClientRequest $request, Client $client)
    {
        $data = $request->only([
            'clientName',
            'phoneNumber'
        ]);

        $updated = $client->update($data);

        if ($updated) {
            return redirect()->back()->with(['successMessage' => 'Cliente atualizado com sucesso!']);
        }
        
        return redirect()->back()->with(['errorMessage' => 'Não foi possível atualizar o cliente!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->with('errorMessage', 'Cliente deletado(a) com sucesso!');
    }
}

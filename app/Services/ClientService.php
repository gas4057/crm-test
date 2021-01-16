<?php


namespace App\Services;

use App\Http\Requests\Api\ClientRequest;
use App\Models\Client;

class ClientService
{
    public function getClients()
    {
        return Client::with('company')->paginate(5);
    }

    public function createClient(ClientRequest $request)
    {
        return Client::create($request->post());
    }

    public function getClient($id)
    {
        return Client::with('company')->findOrFail($id);
    }

    public function updateClient(ClientRequest $request, $id)
    {
        $client = Client::with('company')->findOrFail($id);
        $client->update($request->post());
        if ($request->companies) {
            $companiesIds = json_decode($request->companies);
            $client->company()
                ->sync($companiesIds);
        }
        return $client;
    }

    public function deleteClient($id)
    {
        $company = Client::findOrFail($id);
        $company->company()->detach();
        $company->delete();
    }

    public function clientCompanies($id)
    {
        $client = Client::findorfail($id);
        return $client->company;
    }
}

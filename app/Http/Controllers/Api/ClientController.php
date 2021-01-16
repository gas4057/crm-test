<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ClientRequest;
use App\Services\ClientService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ClientService();
    }

    public function index()
    {
        try {
            $data = $this->service->getClients();
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'error'], 500);
        }
        return response()->json($data, 200);
    }

    public function store(ClientRequest $request)
    {
        try {
            $data = $this->service->createClient($request);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Client not created'], 500);
        }
        return response()->json([
            'message' => 'Client was created successfully',
            'company' => $data
        ], 200);
    }

    public function show($id)
    {
        try {
            $data = $this->service->getClient($id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json(['client' => $data], 200);
    }

    public function update(ClientRequest $request, $id)
    {
        try {
            $data = $this->service->updateClient($request, $id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Client not updated'], 404);
        }
        return response()->json([
            'message' => 'Client was updated',
            'client' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->service->deleteClient($id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Client not deleted'], 404);
        }
        return response()->json([
            'message' => 'Client was deleted',
        ], 200);
    }

    public function clientCompanies($client_id)
    {
        try {
            $data = $this->service->clientCompanies($client_id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Client not found'], 404);
        }
        return response()->json([
            'companies' => $data,
        ]);
    }
}

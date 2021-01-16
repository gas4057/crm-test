<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new CompanyService();
    }

    public function index(Request $request)
    {
        try {
            $data = $this->service->getCompanies($request);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'error'], 500);
        }
        return response()->json($data, 200);
    }

    public function store(CompanyRequest $request)
    {
        try {
            $data = $this->service->createCompany($request);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Company not created'], 500);
        }
        return response()->json($data, 200);
    }

    public function show($id)
    {
        try {
            $data = $this->service->getCompany($id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Company not found'], 404);
        }
        return response()->json(['company' => $data], 200);
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $data = $this->service->updateCompany($request, $id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Company not updated'], 404);
        }
        return response()->json([
            'message' => 'Company was updated',
            'company' => $data,
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
            $this->service->deleteCompany($id);
        } catch (Exception $e) {
            Log::info($e);
            return response()->json(['message' => 'Company not deleted'], 404);
        }
        return response()->json([
            'message' => 'Company was deleted',
        ], 200);
    }
}

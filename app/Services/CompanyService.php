<?php


namespace App\Services;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService
{
    public function getCompanies(Request $request)
    {
        return Company::paginate(5);
    }

    public function createCompany(CompanyRequest $request)
    {
        $company = Company::create($request->post());
        return response()->json([
            'message' => 'Company was created successfully',
            'company' => $company
        ], 200);
    }

    public function getCompany($id)
    {
        return Company::findOrFail($id);
    }

    public function updateCompany(CompanyRequest $request, $id)
    {
        $company = Company::with('client')->findOrFail($id);
        $company->update($request->post());
        if ($request->clients) {
            $clientIds = json_decode($request->clients);
            $company->client()
                ->sync($clientIds);
        }
        return $company;
    }

    public function deleteCompany($id)
    {
        $company = Company::findOrFail($id);
        $company->client()->detach();
        $company->delete();
    }
}

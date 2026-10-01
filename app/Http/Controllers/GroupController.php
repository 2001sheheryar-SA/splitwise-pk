<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\TeamResource;
use App\Services\GroupService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class GroupController extends Controller
{
    /**
     * GET /api/company
     */
    // public function show(Request $request): JsonResponse
    // {
    //     $company = $request->user()->company;
    
    //     Gate::authorize('view', $company);

    //     return Response::success('Company fetched successfully.', new CompanyResource($company));
    // }

    /**
     * Post /api/groups
     */
    public function store(GroupRequest $request): JsonResponse
    {
        //$company = $request->user()->company()->firstOrFail();
         //print_r( $request->validated());exit();
         $group= GroupService::create($request->validated());
       
        return Response::success('Group created successfully.', new GroupResource($group));
    }

    // /**
    //  * GET /api/company/teams
    //  */
    // public function teams(Request $request): JsonResponse
    // {

    //      return TeamController::index($request);
    // }



}

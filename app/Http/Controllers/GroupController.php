<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddGroupMemberRequest;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\GroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\GroupBalanceResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\TeamResource;
use App\Models\Groups;
use App\Models\User;
use App\Services\ExpenseService;
use App\Services\GroupService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class GroupController extends Controller
{
    /**
     * GET /api/groups
     */

    public function show(Request $request): JsonResponse
    {   
        $limit = $request->integer('limit', 10);
        //$group = GroupService::getGroups();
        $group = request()->user()->groups()
        ->when(request('name'), function ($query,$name){
            $query->where('name', 'like', "%{$name}%");
        })->paginate($limit);
        
    
        $message =  $group->total() === 0 ? 'No Groups found.' : 'Groups fetched successfully.';
    
       // Gate::authorize('view', $company);

        return Response::success($message,GroupResource::collection($group),200
        ,[
                'current_page' => $group->currentPage(),
                'last_page' => $group->lastPage(),
                'per_page' => $group->perPage(),
                'total' => $group->total(),
            ]);
    }

    /**
     * Post /api/groups
     */
    public function store(GroupRequest $request): JsonResponse
    {
        $group= GroupService::create($request->validated());
       
        return Response::success('Group created successfully.', new GroupResource($group));
    }


    public function update(GroupRequest $request,Groups $group): JsonResponse
    {
        $group= GroupService::update($group,$request->validated());
       
        return Response::success('Group updated successfully.', new GroupResource($group));
    }

    public function destroy(Groups $group): JsonResponse
    {
        
        $group->delete();


        return Response::success('Group deleted successfully.',200);
    }


    


    public function addMember(Request $request ,Groups $group): JsonResponse
    {
       
        $group = GroupService::addMember($group,$request->input('user_id'));
        return Response::success('Group member added successfully.', new GroupResource($group));
    }

    public function removeMember(Request $request,Groups $group): JsonResponse
    {
       
        GroupService::removeMember($group, $request->input('user_id'));
        return Response::success('Group member removed successfully.');
    }



    public function showBalance(Request $request ,Groups $group): JsonResponse
    {
       
        $balances=ExpenseService::getGroupBalances((string) $group->id);
        if(empty($balances)){
         return Response::error(' Group balances not found.');
        }
        return Response::success('Group balances fetched successfully.', new GroupBalanceResource(['group_id' => $group->id,
        'balances' => $balances,]));
    }



    


    // /**
    //  * GET /api/company/teams
    //  */
    // public function teams(Request $request): JsonResponse
    // {

    //      return TeamController::index($request);
    // }



}

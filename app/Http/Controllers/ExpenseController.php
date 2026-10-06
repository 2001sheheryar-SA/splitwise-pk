<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\TeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\TeamResource;
use App\Models\Expense;
use App\Models\Groups;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Services\ExpenseService;
use App\Services\GroupService;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class ExpenseController extends Controller
{
    public function __construct(private readonly ExpenseService $expenseService)
    {
    }

    
     public  function index(Groups $group,Request $request): JsonResponse
    {
       
         $limit = $request->integer('limit', 10);
        
         $expenses = $group->expenses()->paginate($limit);

         $message =  $expenses->total() === 0 ? 'No Expenses found.' : 'Expenses fetched successfully.';
    

        return Response::success(
            $message,
            ExpenseResource::collection($expenses)->resolve(),
            200,
            [
                'current_page' => $expenses->currentPage(),
                'last_page' => $expenses->lastPage(),
                'per_page' => $expenses->perPage(),
                'total' => $expenses->total(),
            ]
        );
    }



    public  function show(Expense $expense,Request $request): JsonResponse
    {
      
       $expenses = Expense::find($expense->id);
      

        return Response::success(
           'Expense fetched successfully.',
            new ExpenseResource($expenses),
            200 );
    }

    
    public function store(CreateExpenseRequest $request, Groups $group): JsonResponse
    {
      
        $expense = $this->expenseService->create($group,$request->validated());

        return Response::success('Expense created successfully.', new ExpenseResource($expense), 201);
    }



    public  function destroy(Expense $expense): JsonResponse
{
    // Soft delete the record (sets deleted_at timestamp)
   
    $expense->delete();

    return Response::success(
        'Expense  deleted successfully.',
        200
    );
}


 public  function update(CreateExpenseRequest $request,Expense $expense): JsonResponse
{
    // Soft delete the record (sets deleted_at timestamp)
   
    $expense = $this->expenseService->update($expense,$request->validated());

    return Response::success('Expense Updated successfully.', new ExpenseResource($expense), 201);
}

    

}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSettlementRequest;
use App\Http\Resources\SettlementResource;
use App\Models\Groups;
use App\Models\Settlements;
use App\Services\ExpenseService;
use App\Services\SettlementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SettlementController extends Controller
{
    public function __construct(private readonly SettlementService $settlementService)
    {
    }

 
    public function store(CreateSettlementRequest $request,Groups $group): JsonResponse
    {
        
        $balances=ExpenseService::getGroupBalances((string) $group->id);

        $validationError=SettlementService::validateSettlement($balances,$request->validated('paid_by'),$request->validated('amount'));

        if ($validationError) {
        return $validationError; // <-- This actually sends the 422 response back to Postman/Client
        }

        $settlement = $this->settlementService->create($group,$request->validated());

        return Response::success('Expense created successfully.', new SettlementResource($settlement), 201);
    }


    public function update(CreateSettlementRequest $request,Settlements $settlement): JsonResponse
    {
        
        $balances=ExpenseService::getGroupBalances((string) $settlement->group->id,(string) $settlement->id);

        $validationError=SettlementService::validateSettlement($balances,$request->validated('paid_by'),$request->validated('amount'));

        if ($validationError) {
        return $validationError; // <-- This actually sends the 422 response back to Postman/Client
        }

        $settlement = $this->settlementService->update($settlement,$request->validated());

        return Response::success('Settlement Updated successfully.', new SettlementResource($settlement), 201);
    }

    public function destroy(Settlements $settlement): JsonResponse
    {
        $settlement->delete();

        return Response::success('Settlement deleted successfully.', 200);
    }


    public  function show(Settlements $settlement): JsonResponse
    {
      
       $settlements = Settlements::find($settlement->id);
      
        return Response::success(
           'Settlements fetched successfully.',
            new SettlementResource($settlements),
            200 );
    }

    public function index(Request $request,Groups $group): JsonResponse
    {   
        $limit = $request->integer('limit');

        $settlements = $group->settlements()->paginate($limit);
        
        $message =  $settlements->total() === 0 ? 'No Settlement found.' : 'Settlements fetched successfully.';
    

        return Response::success($message,SettlementResource::collection($settlements),200
        ,[
                'current_page' => $settlements->currentPage(),
                'last_page' => $settlements->lastPage(),
                'per_page' => $settlements->perPage(),
                'total' => $settlements->total(),
            ]);
    }

   

}

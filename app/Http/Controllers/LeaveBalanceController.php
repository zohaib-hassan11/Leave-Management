<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LeaveBalanceRepositoryInterface;

class LeaveBalanceController extends Controller
{
    protected $leaveBalanceRepository;

    public function __construct(LeaveBalanceRepositoryInterface $leaveBalanceRepository){
        $this->leaveBalanceRepository = $leaveBalanceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('employee')) {
            $leaveBalance = $this->leaveBalanceRepository->loadRelations(['user', 'leaveType'])
                                                        ->where('user_id', $user->id);
            $leaveBalance = $this->leaveBalanceRepository->getFilteredLeavesBalance($user->id);

        } else {
            $leaveBalance = $this->leaveBalanceRepository->loadRelations(['user', 'leaveType']);
            $leaveBalance = $this->leaveBalanceRepository->getAll();
        }

        return view('leaveBalance.index', compact('leaveBalance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

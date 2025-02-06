<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\UserRequest;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use App\Mail\LeaveStatusUpdated;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\UserLeaveRequest;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserLeaveRepositoryInterface;

class UserLeaveController extends Controller
{
    protected $userLeaveRepository;

    public function __construct(UserLeaveRepositoryInterface $userLeaveRepository)
    {
        $this->userLeaveRepository = $userLeaveRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $leaveTypes = LeaveType::all();
        $roles = Role::all();

        $filters = [
            'search' => $request->search ?? null,
            'leave_type' => $request->leave_type ?? null,
            'roles' => $request->roles ?? null,
        ];

        if ($user->hasRole('employee')) {
            $filters['user_id'] = $user->id;
        }

        $userLeave = $this->userLeaveRepository->getFilteredLeaves($filters);

        if ($request->ajax()) {
            return view('partials.leave-list', compact('userLeave'))->render();
        }

        return view('userLeave.index', compact('userLeave', 'leaveTypes', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = LeaveType::all();
        $authUser = auth()->user();

        if ($authUser->hasRole('employee')) {
            $user = User::where('id', $authUser->id)->get();
        } else {
            $user = User::all();
        }

        return view('userLeave.create', compact('user', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserLeaveRequest $request)
    {
        $validated = $request->validated();

        $leaveBalance = LeaveBalance::where('user_id', auth()->id())
                                ->where('leave_type_id', $validated['leave_type_id'])
                                ->first();

        if (!$leaveBalance) {
            // $leaveBalance = LeaveBalance::create([
            //     'user_id' => auth()->id(),
            //     'leave_type_id' => $validated['leave_type_id'],
            //     'remaining_days' => 0,
            // ]);

            $this->userLeaveRepository->create($validated);
            return redirect()->back()->with('success', 'Leave request saved without balance record.');
        }

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $daysRequested = $startDate->diffInDays($endDate) + 1;

        if ($leaveBalance->remaining_days < $daysRequested) {
            return redirect()->back()->withErrors(['error' => 'Insufficient leave balance.']);
        }

        $leaveRequest = $this->userLeaveRepository->create($validated);

        $leaveBalance->remaining_days -= $daysRequested;
        $leaveBalance->save();

        return redirect()->back()->with('success', 'Leave request created successfully.');
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
        $user = User::all();
        $type = LeaveType::all();

        $userLeave = $this->userLeaveRepository->loadRelations(['user', 'leaveType'])->find($id);

        if (!$userLeave) {
            return redirect()->back()->with('errors', 'User Leave request not found.');
        }

        return view('userLeave.edit', compact('userLeave', 'type', 'user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UserLeaveRequest $request, string $id)
    {
        $userLeave = $this->userLeaveRepository->update($id, $request->validated());
        if($userLeave){
            return redirect()->back()->with('success', 'User Leave Update Successfully.');
        }
        return redirect()->back()->with('errors', 'Faild to Update User.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if($this->userLeaveRepository->delete($id)){
            return redirect()->back()->with('success', 'User Leave Deleted successfully');
        }
            return redirect()->back()->with('errors', 'User Leave Not Found');
    }

    public function updateStatus(Request $request, $id)
    {
        $leave = $this->userLeaveRepository->loadRelations(['user', 'leaveType'])->find($id);
        $userId = auth()->id();

        if (!$leave) {
            return back()->with('errors', 'Leave request not found.');
        }

        $previousStatus = $leave->status;

        $leave->status = $request->status;
        $leave->save();

        $userRequest = UserRequest::where('id', $leave->id)->first();
        if ($userRequest) {
            $userRequest->approved_by = $userId;
            $userRequest->status = $leave->status;
            $userRequest->save();
        } else {
            UserRequest::create([
                'approved_by' => $userId,
                'leave_id' => $leave->id,
                'status' => $leave->status,
            ]);
        }

        $startDate = Carbon::parse($leave->start_date);
        $endDate = Carbon::parse($leave->end_date);
        $days = $startDate->diffInDays($endDate) + 1;

        $leaveBalance = LeaveBalance::where('user_id', $leave->user_id)
                                    ->where('leave_type_id', $leave->leaveType->id)
                                    ->first();

        if (!$leaveBalance) {
            $leaveBalance = LeaveBalance::create([
                'user_id' => $leave->user_id,
                'leave_type_id' => $leave->leaveType->id,
                'remaining_days' => $leave->leaveType->allowed_days
            ]);
        }

        if ($previousStatus == 'approved' && ($leave->status == 'pending' || $leave->status == 'rejected')) {
            $leaveBalance->remaining_days = max(0, $leaveBalance->remaining_days + $days);
        } elseif ($leave->status == 'approved' && $previousStatus != 'approved') {
            $leaveBalance->remaining_days = max(0, $leaveBalance->remaining_days - $days);
        }

        $leaveBalance->save();

        Mail::to($leave->user->email)->send(new LeaveStatusUpdated($leave));

        return back()->with('success', 'Leave status updated and email sent.');
    }

}

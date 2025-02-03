<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveType;
use Illuminate\Http\Request;
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
        $userLeave = $this->userLeaveRepository->loadRelations(['user', 'leaveType']);
        $userLeave = $this->userLeaveRepository->getAll();

        return view('userLeave.index', compact('userLeave'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $type = LeaveType::all();

        return view('userLeave.create', compact('user', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserLeaveRequest $request)
    {
        // dd($request->all());
        $user = $this->userLeaveRepository->create($request->validated());
        return redirect()->back()->with('success', 'User Leave Create successfully');
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

    public function updateStatus(UserLeaveRequest $request, $id){

        $leave = $this->userLeaveRepository->loadRelations(['user', 'leaveType'])->find($id);
        if (!$leave) {
            return back()->with('errors', 'Leave request not found.');
        }

        $validated = $request->validated();
        $leave->status = $validated['status'];
        $leave->save();

        // Mail::to($user->email)->send(new LeaveStatusUpdated($leave));

        return back()->with('success', 'Leave status updated and email sent.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Regularization;

class PendingApprovalsController extends Controller
{
    /**
     * Display pending leave approvals.
     */
    public function leaveApprovals()
    {
        $leaves = Leave::with('employee')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.leave-approvals', compact('leaves'));
    }

    /**
     * Display pending regularization requests.
     */
    public function regularizations()
    {
        $regularizations = Regularization::with(['user', 'attendance'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.regularizations', compact('regularizations'));
    }
}
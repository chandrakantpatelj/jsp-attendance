<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regularization;
use App\Models\Attendance;
use Carbon\Carbon;

class RegularizationController extends Controller
{
    public function index()
    {
        $regularizations = Regularization::with(['user', 'attendance'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.regularizations', compact('regularizations'));
    }

    public function approve($id)
    {
        $regularization = Regularization::with('attendance')->findOrFail($id);
        
        if ($regularization->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ]);
        }

        $regularization->status = 'approved';
        $regularization->save();

        return response()->json([
            'success' => true,
            'message' => 'Regularization request approved successfully.'
        ]);
    }

    public function reject($id)
    {
        $regularization = Regularization::findOrFail($id);
        
        if ($regularization->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This request has already been processed.'
            ]);
        }
        
        $regularization->status = 'rejected';
        $regularization->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Regularization request rejected successfully.'
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = User::where('role_id', 2)
            ->orderByDesc('id')
            ->paginate(10);
        
        return view('admin.employee', compact('employees'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|different:business_email',
            'business_email' => 'required|email|unique:users,business_email|different:email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required',
            'designation' => 'required|in:UIUX Design,Developer,Designer',
        ], [
            'business_email.unique' => 'The business email address has already been taken by another employee.',
            'business_email.different' => 'The business email must be different from the personal email.',
        ]);
        
        if ($request->email === $request->business_email) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'business_email' => ['The business email must be different from the personal email.']
                ]
            ], 422);
        }

        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'business_email' => $request->business_email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'designation' => $request->designation,
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Employee created successfully.']);
        }

        return redirect()->route('admin.employee.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'different:business_email',
                Rule::unique('users')->ignore($id)
            ],
            'business_email' => [
                'required',
                'email',
                'different:email',
                Rule::unique('users')->ignore($id)
            ],
            'role_id' => 'required',
            'designation' => 'required|in:UIUX Design,Developer,Designer',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'business_email.unique' => 'The business email address has already been taken by another employee.',
            'business_email.different' => 'The business email must be different from the personal email.',
        ]);

        $user = User::findOrFail($id);
        
        if ($request->email === $request->business_email) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'business_email' => ['The business email must be different from the personal email.']
                ]
            ], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->business_email = $request->business_email;
        $user->role_id = $request->role_id;
        $user->designation = $request->designation;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->status = $request->has('status') ? 'active' : 'inactive';
        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Employee updated successfully.']);
        }

        return redirect()->route('admin.employee.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.employee.index')->with('success', 'Employee deleted successfully.');
    }

    /**
     * Export employees as CSV
     */
    public function exportCsv()
    {
        $employees = User::where('role_id', 2)
            ->orderBy('name')
            ->get();

        $filename = 'employees-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($employees) {
            $handle = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add CSV headers
            fputcsv($handle, ['Name', 'Department', 'Personal Email', 'Work Email', 'Status', 'Joined Date']);

            // Add data rows
            foreach ($employees as $employee) {
                fputcsv($handle, [
                    $employee->name,
                    $employee->designation ?? 'N/A',
                    $employee->email,
                    $employee->business_email ?? 'N/A',
                    ucfirst($employee->status ?? 'active'),
                    $employee->created_at->format('d-m-Y'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show create form (if needed for modal)
     */
    public function create()
    {
        return view('admin.employee_form');
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role_id', 2)
            ->orderByDesc('id')
            ->paginate(10);
        //dd($employees);
        return view('admin.employee', compact('employees'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|different:business_email',
            'business_email' => 'required|email|unique:users,business_email|different:email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required',
            'designation' => 'required|in:UIUX Design,Developer,Designer',
        ],[
            'business_email.unique' => 'The business email address has already been taken by another employee.',
            'business_email.different' => 'The business email must be different from the personal email.',
        ]);
        
        if ($request->email === $request->business_email) {
            return redirect()->back()->withInput()->withErrors([
                'business_email' => 'The business email must be different from the personal email.'
            ]);
        }

        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'business_email' => $request->business_email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
           'designation' => $request->designation,
            //'designation' => $request->designation,
             'status' => $request->has('status') ? 'active' : 'inactive',
        ]);
        return redirect()->route('employee.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        //return view('employee.edit', compact('user'));
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {   //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            //'email' => 'required|email|unique:users,email,' . $id,'different:business_email',
            //'business_email' => 'required|email|unique:users,business_email,' . $id,'different:email',
            'email' => ['required','email','different:business_email',Rule::unique('users')->ignore($id)],
            'business_email' => ['required','email','different:email',Rule::unique('users')->ignore($id)],
            'role_id' => 'required',
            'designation' => 'required|in:UIUX Design,Developer,Designer',
            'password' => 'nullable|min:8|confirmed',
        ],[
            'business_email.unique' => 'The business email address has already been taken by another employee.',
            'business_email.different' => 'The business email must be different from the personal email.',
        ]);

        $user = User::findOrFail($id);
        
        if ($request->email === $request->business_email) {
            return redirect()->back()->withInput()->withErrors([
                'business_email' => 'The business email must be different from the personal email.'
            ]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->business_email = $request->business_email;
        $user->role_id = $request->role_id;
        $user->designation = $request->designation;
         if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        //dd($user->name);
        $user->status = $request->has('status') ? 'active' : 'inactive';
         $user->save();
            return redirect()->route('employee.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully.');

    }
}
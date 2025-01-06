<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role_id', 2)->get();
        return view('admin.employee', compact('employees'));
    }

    // public function create()
    // {
    //     return view('employee.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required',
            'designation' => 'required',
        ]);

        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'designation' => $request->designation,
        ]);
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        //return view('employee.edit', compact('user'));
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required',
            'designation' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role_id' => $request->role_id,
            'designation' => $request->designation,
        ]);
        return redirect()->route('employee.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully.');

    }
}
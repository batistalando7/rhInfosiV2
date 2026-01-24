<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $data = LeaveType::orderByDesc('id')->get();
        return view('admin.leaveType.list.index', compact('data'));
    }

    public function create()
    {
        return view('admin.leaveType.create.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        LeaveType::create($request->only('name', 'description'));

        return redirect()->route('admin.leaveType.index')
                         ->with('msg', 'Tipo de licença criado com sucesso!');
    }

    public function show($id)
    {
        $data = LeaveType::findOrFail($id);
        return view('admin.leaveType.show.index', compact('data'));
    }

    public function edit($id)
    {
        $data = LeaveType::findOrFail($id);
        return view('admin.leaveType.edit.index', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $data = LeaveType::findOrFail($id);
        $data->update($request->only('name', 'description'));

        return redirect()->back()->with('msg', 'Tipo de licença atualizado com sucesso!');
    }

    public function destroy($id)
    {
        LeaveType::destroy($id);
        return redirect()->back()->with('msg', 'Tipo de licença removido com sucesso!');
    }
}

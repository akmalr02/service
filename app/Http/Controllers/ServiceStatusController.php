<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceStatus;
use Illuminate\Http\Request;

class ServiceStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Status service';
        $status = ServiceStatus::all();
        return view('status.index', [
            'title' => $title,
            'status' => $status
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create status service';
        // $status = ServiceStatus::all();
        return view('status.create', [
            'title' => $title,
            // 'status' => $status
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'status_name' => 'required|string|unique:service_status',
            'description' => 'required|max:225'
        ]);
        //debuging validate
        // dd($validate);

        ServiceStatus::create($validate);
        return redirect()->route('status.index')->with('success', 'Berhasil tambah status');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $title = 'Status service';
        // $status = ServiceStatus::all();
        // return view('status.show', [
        //     'title' => $title,
        //     'status' => $status
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Update status service';
        $status = ServiceStatus::find($id);
        return view('status.edit', [
            'title' => $title,
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $status = ServiceStatus::find($id);
        if (!$status) {
            return redirect()->back()->with('error', 'Status not found');
        }
        $validate = $request->validate([
            'status_name' => 'required|string|unique:service_status',
            'description' => 'required|max:225'
        ]);
        //debuging validate
        // dd($validate);
        // dd($status);

        $status->update($validate);

        return redirect()->route('status.index')->with('success', 'Data status berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = ServiceStatus::findOrFail($id);
        $status->delete();

        return redirect()->back()->with('danger', 'status berhasil di hapus!!!');
    }
}

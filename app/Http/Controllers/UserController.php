<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $satuan = Satuan::all();
        return view('masters.user', compact('roles', 'satuan'));
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
        $result = User::create([
            'role_id' => $request->role_id,
            'name' => $request->nama_user,
            'email' => $request->email,
            'phone' => $request->telp,
            'password' => Hash::make($request->password),
            'address' => $request->alamat
        ]);
        
        return redirect()->route('user.index');

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

    public function datatable()
    {
        $query = User::get();
        $data = UserResource::collection($query);
        $res = $data->toArray(request());
        

        return DataTables::of($res)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                return '<div class="flex gap-3 mt-2">
            <button onclick="getData(' . $row["id_user"] . ', \'' . addslashes($row["name_user"]) . '\', \'' . addslashes($row["email"]) . '\', \'' . addslashes($row["phone"]) . '\', \'' . addslashes($row["address"]) . '\', ' . $row["id_role"] . ', \'' . addslashes($row["name_role"]) . '\')" id="delete-faktur-all" class="text-yellow-300 font-semibold mb-3 self-end" ><i class="fa-solid fa-pencil"></i></button> |
            <button id="delete-faktur-all" class="text-red-600 font-semibold mb-3 self-end" ><i class="fa-solid fa-trash"></i></button>
            </div>';
            })
            ->rawColumns(['aksi'])
            ->make();
    }
}
 
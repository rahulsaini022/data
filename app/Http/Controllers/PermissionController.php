<?php
namespace App\Http\Controllers;


// use App\Permission;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class PermissionController extends Controller

{ 

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    function __construct()

    {

         $this->middleware('permission:permission-list');

         $this->middleware('permission:permission-create', ['only' => ['create','store']]);

         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);

         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {
        $permissions = Permission::latest()->paginate(10);

        return view('permissions.index',compact('permissions'))

            ->with('i', (request()->input('page', 1) - 1) * 5);

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('permissions.create');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        request()->validate([

            'name' => 'required',
        ]);
        $permission_name=$request->name;
        Permission::create(['name' => $permission_name]);

        return redirect()->route('permissions.index')

                        ->with('success','Permission created successfully.');

    }


    /**

     * Display the specified resource.

     *

     * @param  \App\Permission  $permission

     * @return \Illuminate\Http\Response

     */

    public function show(Permission $permission)

    {

        return view('permissions.show',compact('permission'));

    }


    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Permission  $permission

     * @return \Illuminate\Http\Response

     */

    public function edit(Permission $permission)

    {

        return view('permissions.edit',compact('permission'));

    }


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Permission  $permission

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Permission $permission)

    {

         request()->validate([

            'name' => 'required',

        ]);


        $permission->update($request->all());


        return redirect()->route('permissions.index')

                        ->with('success','Permission updated successfully');

    }


    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Permission  $permission

     * @return \Illuminate\Http\Response

     */

    public function destroy(Permission $permission)

    {

        $permission->delete();


        return redirect()->route('permissions.index')

                        ->with('success','Permission deleted successfully');

    }

}
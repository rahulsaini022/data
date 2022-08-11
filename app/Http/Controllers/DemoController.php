<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Demo;
use Illuminate\Support\Facades\DB;

class DemoController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        // $data = Demo::orderBy('id','DESC')->get();
        $data=DB::table('demos')
        ->select('demos.*', DB::raw('(CASE WHEN EXISTS (SELECT * FROM   users WHERE  users.email = demos.email) THEN "Yes" ELSE "No" END) AS fdd_user')
        )
        ->orderBy('demos.id', 'desc')
        ->get();

        return view('admin.demos.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        die('Not Valid');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {
        die('Not Valid');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $demo = Demo::find($id);

        return view('admin.demos.show',compact('demo'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        die('Not Valid');

    }


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        die('Not Valid');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        die('Not Valid');

    }

}
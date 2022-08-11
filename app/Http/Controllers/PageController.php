<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = Page::orderBy('id','DESC')->get();

        return view('admin.pages.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.pages.create');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request, [

            'title' => 'required',
            
            'slug' => 'required|alpha_dash|unique:pages,slug',

            'content' => 'required'

        ]);


        $input = $request->all();
        
        $page = Page::create($input);

        return redirect()->route('pages.index')

                        ->with('success','New page created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $page = Page::find($id);

        return view('admin.pages.show',compact('page'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $page = Page::find($id);

        return view('admin.pages.edit',compact('page'));

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

        $this->validate($request, [
            
            'title' => 'required',
            
            'slug' => 'required|alpha_dash|unique:pages,slug,'.$id,

            'content' => 'required'

        ]);


        $input = $request->all();

        $page = Page::find($id);

        $page->update($input);

        return redirect()->route('pages.index')

                        ->with('success','Page updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Page::find($id)->delete();

        return redirect()->route('pages.index')

                        ->with('success','Page deleted successfully');

    }

}
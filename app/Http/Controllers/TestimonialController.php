<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Testimonial;

class TestimonialController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = Testimonial::orderBy('id','DESC')->get();

        return view('admin.testimonials.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.testimonials.create');

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

            'author_name' => 'required',
            
            'author_position' => 'required',

            'description' => 'required'

        ]);


        $input = $request->all();
        
        $testimonial = Testimonial::create($input);

        return redirect()->route('testimonials.index')

                        ->with('success','New testimonial created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $testimonial = Testimonial::find($id);

        return view('admin.testimonials.show',compact('testimonial'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $testimonial = Testimonial::find($id);

        return view('admin.testimonials.edit',compact('testimonial'));

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

            'author_name' => 'required',

            'author_position' => 'required',
            
            'description' => 'required'

        ]);


        $input = $request->all();

        $testimonial = Testimonial::find($id);

        $testimonial->update($input);

        return redirect()->route('testimonials.index')

                        ->with('success','Testimonial updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Testimonial::find($id)->delete();

        return redirect()->route('testimonials.index')

                        ->with('success','Testimonial deleted successfully');

    }

}
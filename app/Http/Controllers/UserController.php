<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Usercredithistory;
use App\Caseuser;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

use Hash;
use Session;
use Auth;
use Illuminate\Support\Facades\DB ;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('role:super admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
           
            $draw = $request->get('draw');
            $start = $request->get("start");

            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');
            // print_r($request->all());
            // exit;
            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value
             $role_r=123;
 
            // Total records
            $totalRecords = User::select('count(*) as allcount')->count();
            $totalRecordswithFilter = User::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
            DB::statement(DB::raw('set @rownum=0'));
            // Fetch records
            $records = User::orderBy($columnName, $columnSortOrder)
                ->where('users.name', 'like', '%' . $searchValue . '%')
                ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                // ->orWhere('users.document_sign_name', 'like', '%' . $searchValue . '%')

                ->skip($start)
                ->take($rowperpage)
                ->get([
                    'users.*',
                    DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);

            //  dd($records);
            $data_arr = array();
            $sno = $start + 1;
            foreach ($records as $record) { 
                $sno = $sno;
                $id = $record->id;
                $active= $record->active;
                $name = $record->name;

                $email = $record->email;
                $role = $record->getRoleNames();


                $data_arr[] = array(

                    'no' => $sno,
                    "name" => $name,
                  
                    'active'=>$active,
                    "email" => $email,
                    "role" => $role,
                    "id" => $id,

                );
                $sno++;
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            return json_encode($response);
        }
     
        return view('users.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
            'roles' => 'required',
            'credits' => 'required'
        ]);
        $input = $request->all();
        if (in_array('client', $request->input('roles'))) {
            Session::put('is_client', true);
        } else {
            Session::put('is_client', false);
        }
        Session::put('entered_password', $input['password']);
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        // update user credits. 
        $old_credits = $user->credits;
        $new_credits = $request->credits;
        $user->credits = $new_credits;
        if ($user->save()) {
            // dd($user->role());
            if ($user->hasRole('attorney')) {
                
                $mail_view = 'emails.attorney-register';
                $subject = "Attorney Registration";
            }
            if ($user->hasRole('Advertise')) {
              
                $mail_view = 'emails.advertise-register';
                $subject = "Advertiser Registration";
            }
            else  {
              
                $mail_view = 'emails.client-register';
                $subject = " Registration";
            
           }
            $name = $user->name;
            $email = $user->email;
            $email_from = env('MAIL_FROM_ADDRESS');
            $email_us = Mail::send(
                $mail_view,
                array(
                    'name' => $name,
                    'email' => $email,
                    'password' => $request->password
                ),
                function ($message) use ($name, $email, $email_from, $subject) {
                    $message->from($email_from);
                    $message->to($email, $name)->subject('FDD - ' . $subject . '');
                }
            );
        }
        if ($new_credits > $old_credits) {
            $type = 'credit';
            $destype = 'ADDED TO';
            $number_of_credited_debited = $new_credits - $old_credits;
        } else {
            $type = 'debit';
            $destype = 'DEBITED FROM';
            $number_of_credited_debited = $old_credits - $new_credits;
        }
        if ($new_credits != $old_credits) {
            // to update user credit history
            $history = array(
                'user_id' => $user->id,
                'source' => 'Admin',
                'source_id' => Auth::user()->id,
                'type' => $type,
                'number_of_credited_debited' => $number_of_credited_debited,
                'description' => $number_of_credited_debited . ' FDD CREDITS ' . $destype . ' ' . $user->name . ' #' . $user->id . ' ACCOUNT BY ADMIN ON ' . date('m-d-Y') . '.',
                'created_at' => now(),
                'updated_at' => now(),
            );
            $user_credits_history = Usercredithistory::create($history);
        }
        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
        } else {
            return redirect()->route('users.index')
                ->with('error', 'User not found.');
        }
        $number_of_cases_involved_in = Caseuser::where('user_id', $id)->count();
        $number_of_cases_involved_in = Caseuser::select('case_id', DB::raw('count(*) as total'))
            ->where('user_id', $id)
            ->groupBy('case_id')
            ->get()
            ->count();
        if (isset($number_of_cases_involved_in) && $number_of_cases_involved_in != '') {
        } else {
            $number_of_cases_involved_in = 0;
        }
        $user->setAttribute('number_of_cases_involved_in', $number_of_cases_involved_in);
        return view('users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $re)
    {
      
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {  $r_url=$request->pre_url;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'confirm-password'=>'same:password',
            'roles' => 'required',
        ]);
        $user = User::find($id);
        $input = $request->all();
        $roles = $input['roles'];
        foreach ($roles as $val) {
            if ($val == 'Advertise') {
                $check_advertiser = DB::table('advertisers')->where('email', $user->email)->first();
                if ($check_advertiser) {
                } else {
                    return redirect()->route('users.edit', $user->id)
                        ->with('error', 'This user advertiser account is not created,Please create advertiser account for this user,then assign role Advertise.');
                }
            }
        }
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user->update($input);
        // update user credits. 
        $old_credits = $user->credits;
        $new_credits = $request->credits;
        $user->credits = $new_credits;
        $user->save();
        if ($new_credits > $old_credits) {
            $type = 'credit';
            $destype = 'ADDED TO';
            $number_of_credited_debited = $new_credits - $old_credits;
        } else {
            $type = 'debit';
            $destype = 'DEBITED FROM';
            $number_of_credited_debited = $old_credits - $new_credits;
        }
        if ($new_credits != $old_credits) {
            // to update user credit history
            $history = array(
                'user_id' => $user->id,
                'source' => 'Admin',
                'source_id' => Auth::user()->id,
                'type' => $type,
                'number_of_credited_debited' => $number_of_credited_debited,
                'description' => $number_of_credited_debited . ' FDD CREDITS ' . $destype . ' ' . $user->name . ' #' . $user->id . ' ACCOUNT BY ADMIN ON ' . date('m-d-Y') . '.',
                'created_at' => now(),
                'updated_at' => now(),
            );
            $user_credits_history = Usercredithistory::create($history);
        }
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        if($r_url=='clients')
        {
            return redirect()->route('all.clients')
                ->with('success', 'User updated successfully');}
                else{

            return
            redirect()->route('users.index')
                ->with('success', 'User updated successfully');
                }
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
    public function deactivate($id)
    {
        $user = User::find($id);
        $user->active = '0';
        $user->save();
        return redirect()->back()
            ->with('success', 'User deactivated successfully');
    }
    public function activate($id)
    {
        $user = User::find($id);
        $user->active = '1';
        $user->save();
        return redirect()->back()
            ->with('success', 'User activated successfully');
    }
    public function clients(Request $request)
    {


        if ($request->ajax()) {

            $draw = $request->get('draw');
            $start = $request->get("start");

            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');


            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value


            // Total records
            $totalRecords = User::role('client')->count();
            $totalRecordswithFilter = User::role('client')->where('id', 'like', '%' . $searchValue . '%')->count();

            // Fetch records
            $records = User::role('client')->orderBy($columnName, $columnSortOrder)
                ->where('users.name', 'like', '%' . $searchValue . '%')
                // ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                // ->orWhere('users.document_sign_name', 'like', '%' . $searchValue . '%')
                // ->where([
                //     ['users.name', 'like', '%' . $searchValue . '%'],
                //     ['users.email', 'like', '%' . $searchValue . '%'],
                // ])
                ->skip($start)
                ->take($rowperpage)
                ->get();

            //  dd($records);
            $data_arr = array();
            $sno = $start + 1;
            foreach ($records as $record) {
                $sno = $sno;
                $id = $record->id;
                $active = $record->active;
                $name = $record->name;
                $req = $request->all();
                $email = $record->email;
                $role = $record->getRoleNames();


                $data_arr[] = array(

                    'no' => $sno,
                    "name" => $name,
                    "req" => $req,
                    'active' => $active,
                    "email" => $email,
                    "role" => $role,
                    "id" => $id,

                );
                $sno++;
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            return json_encode($response);
        }

        return view('users.clients_list');
    }
}

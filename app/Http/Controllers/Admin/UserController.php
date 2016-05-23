<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\Bootgrid;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'prefix' => $request->input('prefix'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'position' => $request->input('position'),
            'belong_to' => $request->input('belong-to'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'telephone' => $request->input('telephone'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'created_by' => Auth::user()->getKey(),
        ]);

        if (is_null($user))
        {
            return back()
                ->withInput($request->except(['password']))
                ->with([
                    'status' => 'fail',
                    'class' => 'danger',
                    'icon' => 'warning',
                    'message' => 'ไม่สามารถเพิ่มผู้ใช้ได้',
                ]);
        }
        
        return redirect('/admin/users')
            ->with([
                'status' => 'success',
                'class' => 'success',
                'icon' => 'alert',
                'message' => 'เพิ่มผู้ใช้ใหม่แล้ว',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.user.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', ['user' => $user]);
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
        $user = User::findOrFail($id);

        $user->prefix = $request->input('prefix');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->position = $request->input('position');
        $user->belong_to = $request->input('belong-to');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->telephone = $request->input('telephone');
        $user->username = $request->input('username');
        
        if ($user->save())
        {
            return back()
                ->withInput($request->except(['password']))
                ->with([
                    'status' => 'success',
                    'class' => 'success',
                    'icon' => 'alert',
                    'message' => 'บันทึกข้อมูลแล้ว',
                ]);
        }
        
        return back()
            ->with([
                'status' => 'success',
                'class' => 'success',
                'icon' => 'alert',
                'message' => 'ไม่สามารถบันทึกข้อมูลได้',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        return $user->delete() ? 'true':'false';
    }

    public function jsonIndex(Request $request)
    {
        $bootgrid = new Bootgrid($request);

        $connection = User::where('created_by', Auth::user()->getKey());

        if( $bootgrid->hasSearch() )
        {
            $connection = $connection->Where(function($query) use ($bootgrid)
            {
                $query
                    ->where('firstname', 'LIKE', '%'.$bootgrid->getKeyword().'%')
                    ->orWhere('lastname', 'LIKE', '%'.$bootgrid->getKeyword().'%')
                    ->orWhere('username', 'LIKE', '%'.$bootgrid->getKeyword().'%');
            });
        }

        $bootgrid->setConnection($connection);

        return response()->json($bootgrid->get());
    }
}

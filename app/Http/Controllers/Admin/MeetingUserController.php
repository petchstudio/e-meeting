<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Meeting;
use App\MeetingUser;
use App\Bootgrid;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MeetingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $meetingId
     * @return \Illuminate\Http\Response
     */
    public function index($meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);

        return view('admin.meeting-user.index', ['meeting' => $meeting]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $meetingId
     * @return \Illuminate\Http\Response
     */
    public function create($meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);

        return view('admin.meeting-user.create', ['meeting' => $meeting]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $meetingId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $meetingId)
    {
        $meeting = Meeting::findOrFail($meetingId);

        $meetingUser = MeetingUser::create([
            'positions_id' => $request->input('position'),
            'users_id' => $request->input('user'),
            'meetings_id' => $meeting->getKey(),
        ]);

        if (is_null($meetingUser))
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
        
        return redirect('/admin/meeting/'.$meeting->getKey().'/user')
            ->with([
                'status' => 'success',
                'class' => 'success',
                'icon' => 'alert',
                'message' => 'เพิ่มผู้ใช้แล้ว',
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $meetingId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($meetingId, $id)
    {
        return view('admin.meeting-user.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $meetingId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($meetingId, $id)
    {
        $meetingUser = MeetingUser::findOrFail($id);

        return view('admin.meeting-user.edit', ['meetingUser' => $meetingUser]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $meetingId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $meetingId, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $meetingId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($meetingId, $id)
    {
        $meetingUser = MeetingUser::findOrFail($id);
        return $meetingUser->delete() ? 'true':'false';
    }

    /**
     * Display a listing of the resource via json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $meetingId
     * @return \Illuminate\Http\Response
     */
    public function jsonIndex(Request $request, $meetingId)
    {
        $bootgrid = new Bootgrid($request);

        $connection = MeetingUser::where('meetings_id', $meetingId)
                        ->leftJoin('positions', 'meeting_users.positions_id', '=', 'positions.id')
                        ->join('users', 'meeting_users.users_id', '=', 'users.id')
                        ->select(
                            'meeting_users.*',
                            'positions.name as position',
                            'users.username',
                            'users.firstname',
                            'users.lastname'
                        );

        if( $bootgrid->hasSearch() )
        {
            $connection = $connection->Where(function($query) use ($bootgrid)
            {
                $query
                    ->where('users.username', 'LIKE', '%'.$bootgrid->getKeyword().'%')
                    ->orWhere('users.lastname', 'LIKE', '%'.$bootgrid->getKeyword().'%')
                    ->orWhere('users.lastname', 'LIKE', '%'.$bootgrid->getKeyword().'%');
            });
        }

        $bootgrid->setConnection($connection);

        return response()->json($bootgrid->get());
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use App\Meeting;
use App\MeetingUser;
use App\Bootgrid;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MeetingController extends Controller
{
    public function jsonIndex(Request $request, $status=false)
    {
        $bootgrid = new Bootgrid($request);

        $connection = MeetingUser::where('users_id', Auth::user()->getKey())
                        ->join('meetings', 'meeting_users.meetings_id', '=', 'meetings.id')
                        ->select(
                            'meetings.*'
                        );

        if ($status == 'new')
        {
        	$connection = $connection->where('start_at', '>=', Carbon::tomorrow());
        }
        else if ($status == 'today')
        {
        	$connection = $connection->where('start_at', '=', Carbon::today());
        }
        else
        {
        	$connection = $connection->where('start_at', '<', Carbon::yesterday());
        }

        if( $bootgrid->hasSearch() )
        {
            $connection = $connection->Where(function($query) use ($bootgrid)
            {
                $query
                    ->where('name', 'LIKE', '%'.$bootgrid->getKeyword().'%')
                    ->orWhere('year', 'LIKE', '%'.$bootgrid->getKeyword().'%');
            });
        }

        $bootgrid->setConnection($connection);

        return response()->json($bootgrid->get());
    }
}

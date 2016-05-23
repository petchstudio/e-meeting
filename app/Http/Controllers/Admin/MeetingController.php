<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use Carbon\Carbon;
use App\Meeting;
use App\Bootgrid;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.meeting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.meeting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meeting = Meeting::create([
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'start_at' => Carbon::create(
                $request->input('start-year'),
                $request->input('start-month'),
                $request->input('start-day')
            ),
            'created_by' => Auth::user()->getKey(),
        ]);

        if ($request->hasFile('file')) {
            $meeting->file = $this->upload($request->file('file'), $meeting->getKey());
            $meeting->save();
        }

        if (is_null($meeting))
        {
            return back()
                ->withInput($request->except(['password']))
                ->with([
                    'status' => 'fail',
                    'class' => 'danger',
                    'icon' => 'warning',
                    'message' => 'ไม่สามารถเพิ่มการประชุมได้',
                ]);
        }
        
        return redirect('/admin/meeting')
            ->with([
                'status' => 'success',
                'class' => 'success',
                'icon' => 'alert',
                'message' => 'เพิ่มการประชุมใหม่แล้ว',
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
        return view('admin.meeting.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('admin.meeting.edit', ['meeting' => $meeting]);
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
        $meeting = Meeting::findOrFail($id);
        
        $meeting->name = $request->input('name');
        $meeting->year = $request->input('year');
        $meeting->start_at = Carbon::create(
            $request->input('start-year'),
            $request->input('start-month'),
            $request->input('start-day')
        );
 
        if ($request->hasFile('file')) {
            $meeting->file = $this->upload($request->file('file'), $meeting->getKey());
        }
       
        if ($meeting->save())
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
        $meeting = Meeting::findOrFail($id);
        return $meeting->delete() ? 'true':'false';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyFile($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        if (Storage::disk('public')->delete($meeting->file))
        {
            $meeting->file = NULL;
            $meeting->save();

            return back()
                ->with([
                    'status' => 'success',
                    'class' => 'success',
                    'icon' => 'alert',
                    'message' => 'ลบไฟล์แล้ว',
                ]);
        }
        
        return back()
            ->with([
                'status' => 'success',
                'class' => 'success',
                'icon' => 'alert',
                'message' => 'ไม่สามารถลบไฟล์ได้หรือไม่มีไฟล์อยู่',
            ]);
    }

    public function jsonIndex(Request $request)
    {
        $bootgrid = new Bootgrid($request);

        $connection = Meeting::where('created_by', Auth::user()->getKey());

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

    public function upload($file, $id)
    {   
        $path = 'meeting/'.$id.'/'.$file->getClientOriginalName();

        Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));

        return $path;
    }
}

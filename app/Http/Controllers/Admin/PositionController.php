<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Position;
use App\Bootgrid;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.position.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.position.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $position = Position::create([
            'name' => $request->input('name'),
            'created_by' => Auth::user()->getKey(),
        ]);

        if (is_null($position))
        {
            return back()
                ->withInput($request->except(['password']))
                ->with([
                    'status' => 'fail',
                    'class' => 'danger',
                    'icon' => 'warning',
                    'message' => 'ไม่สามารถเพิ่มตำแหน่งได้',
                ]);
        }
        
        return redirect('/admin/position')
            ->with([
                'status' => 'success',
                'class' => 'success',
                'icon' => 'alert',
                'message' => 'เพิ่มตำแหน่งใหม่แล้ว',
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
        return view('admin.position.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = Position::findOrFail($id);
        return view('admin.position.edit', ['position' => $position]);
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
        $position = Position::findOrFail($id);

        $position->name = $request->input('name');
        
        if ($position->save())
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
        $position = Position::findOrFail($id);
        return $position->delete() ? 'true':'false';
    }

    public function jsonIndex(Request $request)
    {
        $bootgrid = new Bootgrid($request);

        $connection = Position::where('created_by', Auth::user()->getKey());

        if( $bootgrid->hasSearch() )
        {
            $connection = $connection->Where(function($query) use ($bootgrid)
            {
                $query
                    ->where('name', 'LIKE', '%'.$bootgrid->getKeyword().'%');
            });
        }

        $bootgrid->setConnection($connection);

        return response()->json($bootgrid->get());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WarungFormRequest;

class WarungController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/warung/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();

        if($user->warung){
            return redirect('warung/' . $user->warung->id . '/edit');
        }

        return view('warung.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarungFormRequest $request)
    {
        $user = auth()->user();

        $user->warung()->firstOrCreate(['user_id' => $user->id], [
            'nama'      => $request->nama,
            'alamat'    => $request->alamat
        ]);

        session()->flash('status', 'Horee!, warung sudah siap digunakan');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->user();

        $warung = $user->warung()->find($id);

        return view('warung.edit', ['data' => $warung]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WarungFormRequest $request, $id)
    {
        $user = auth()->user();

        $user->warung()->update([
            'nama'      => $request->nama,
            'alamat'    => $request->alamat
        ]);

        session()->flash('status', 'Data berhasil disimpan!');
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

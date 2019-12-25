<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarangFormRequest;
use Yajra\Datatables\Datatables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return redirect(route('barang.create'));
        return view('barang.index');
    }

    public function getData()
    {
        $user = auth()->user();
        return Datatables::of($user->barang)
        ->addColumn('actions', function ($data) {
            return '
                <div style="display:flex;justify-content: center;">
                <a href="'. route('barang.edit', $data->id) .'" class="btn btn-sm btn-primary">Edit</a>&nbsp;
                <form action="'. route('barang.destroy', $data->id) .'" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="'. csrf_token() .'">
                    <button class="btn btn-sm btn-danger" onclick="return confirm('. var_export("Anda yakin ingin menghapus barang ini?", true) .')">Hapus</button>
                </form>
                </div>
            ';
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarangFormRequest $request)
    {
        $user   = $request->user();
        $warung = $user->warung;
        
        $warung->barang()->create([
            'nama'          => $request->nama,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'stok'          => $request->stok,
        ]);

        session()->flash('status', 'Barang berhasil di buat');

        return redirect(route('barang.index'));
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

        $barang = $user->barang()->find($id);
        
        return view('barang.edit', ['data' => $barang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BarangFormRequest $request, $id)
    {
        
        $user = auth()->user();

        $user->barang()->find($id)->update($request->all());

        session()->flash('status', 'Barang berhasil di ubah');
        return redirect(route('barang.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $user->barang()->find($id)->delete();

        session()->flash('status', 'Barang berhasil di hapus');
        return redirect(route('barang.index'));
    }
}

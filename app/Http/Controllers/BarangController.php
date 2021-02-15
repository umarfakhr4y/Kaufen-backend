<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Barang::select("*"); 
        if ($request->keyword) {
            $query = $request->keyword;     
            $data->where(function ($q) use($query){
                $q->where('name','LIKE', "%".$query."%")//untuk membuat fitur search ( "%{$query}%" / "%".$query."%" )
                 ->orwhere('name_barang','LIKE', "%".$query."%")
                 ->orWhere('jenis','LIKE', "%".$query."%")
                 ->orWhere('stock','LIKE', "%".$query."%")
                 ->orWhere('harga','LIKE', "%".$query."%");
            });
                                                   
        }
        return $data->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getuser = Auth::user();
        $userId = $getuser['id'];
        $barang = new Barang;
        $barang->user_id = $userId;
        $barang->name = $request->name;
        $barang->name_barang = $request->name_barang;
        $barang->jenis = $request->jenis;
        $barang->stock = $request->stock;
        $barang->harga = $request->harga;                  
        if ($barang->save()) {
            return ["status" => "Berhasi Menyimpan Data", 201];
        }  else {
            return ["status" => "Gagal Menyimpan Data"];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Barang::where('id',$id)->exists()) {
            Barang::where('id',$id)->first();
        } else{
            return response()->json([
                "message" => "id Not Found"
            ], 404);
        }
        return Barang::where('id',$id)->with('saver')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Barang::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::where('id', $id)->first();
        $barang->name = $request->name;
        $barang->name_barang = $request->name_barang;
        $barang->jenis = $request->jenis;
        $barang->stock = $request->stock;
        $barang->harga = $request->harga;                  
        if ($barang->save()) {
            return ["status" => "Berhasi Mengubah Data", 201];
        }  else {
            return ["status" => "Gagal Mengubah Data"];
        }
    }

     /**
     * For Decreasing Stock only for seller.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function decStock(Request $request, $id)
    {
        $barang = Barang::where('id', $id)->first();        
        $barang->stock = $request->stock;                  
        if ($barang->save()) {
            return ["status" => "Berhasi Mengubah Stock", 201];
        }  else {
            return ["status" => "Gagal Mengubah Stock"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::where('id',$id)->first();    
        if ($barang->delete()) {
            return ["status" => "Berhasi Menghapus Data"];
        }  else {
            return ["status" => "Gagal Menghapus Data"];
        }
    }
}

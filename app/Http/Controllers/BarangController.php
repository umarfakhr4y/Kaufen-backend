<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;
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
        // $getuser = Auth::user();
        // $userId = $getuser['id'];

        // $barang = new Barang;
        // $barang->user_id = $request->user_id;
        // $barang->name = $request->name;
        // $barang->name_barang = $request->name_barang;
        // $barang->jenis = $request->jenis;
        // $barang->stock = $request->stock;
        // $barang->harga = $request->harga;

        // if ($barang->save()) {
        //     return ["status" => "Berhasi Menyimpan Data", 201];
        // }  else {
        //     return ["status" => "Gagal Menyimpan Data"];
        // }

        // $validator = Validator::make($request->all(), [
        //     // "description" =>"required",
        //     "image" => "required|image:jpeg,png,gif,svg|max:2048"
        //     ]);
        // if($validator->fails()) {
        //     return response()->json(["error" => $validator->errors()], 500);
        // }

        $validator = Validator::make($request->all(), [            
            "image" => "required|image:jpeg,png,jpg|max:2048"
            ]);
        if($validator->fails()) {
            return response()->json(["error" => $validator->errors()], 500);
        }
        $input = $request->all();
        $input['user_id'] = $request->user_id;
        $input['name'] = $request->name;
        $input['name_barang'] = $request->name_barang;
        $input['jenis'] = $request->jenis;
        $input['stock'] = $request->stock;
        $input['harga'] = $request->harga;

        // $barang = Barang::save();

        $img = $request->file('image');
        // $txt = $request->file('image')->guessExtension();
        $name_file = time()."_".$img->getClientOriginalName();

            // $imgUpload = new Image;
            // $imgUpload->name = $request->name;
            $input['image'] = $name_file;
            $img->move(public_path().'/img', $name_file);    
            Barang::create($input); 

            if ($input) {
                return ["status" => "Berhasi Menyimpan Barang dengan Image", 201];
            }  else {
                return ["status" => "Gagal Menyimpan Barang"];
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
        return Barang::where('id',$id)->get();
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
        $img = $request->file('image');
        // $txt = $request->file('image')->guessExtension();
        $name_file = time()."_".$img->getClientOriginalName();

            // $imgUpload = new Image;
            // $imgUpload->name = $request->name;
            $barang['image'] = $name_file;
            $img->move(public_path().'/img', $name_file);    
            // Barang::create($input);                   
        if ($barang->update()) {
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
    public function transaksi(Request $request, $id)
    {
        $transaksi = Barang::where('id', $id)->first();
        // $transaksi->name = $request->name;
        // $transaksi->name_barang = $request->name_barang;
        // $transaksi->jenis = $request->jenis;
        // $transaksi->stock = $request->('stock');
        $transaksi->stock =  $request->stock;
        // $transaksi->stock =  stock - dec_stock;
        // $transaksi->harga = $request->harga;  
        if ($transaksi->update()) {
            return response()->json(['Terbeli' => $transaksi], 201);
        }  else {
            return ["status" => "Gagal Mlakukan Transaksi"];
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

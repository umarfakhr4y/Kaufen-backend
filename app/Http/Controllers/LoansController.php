<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Loans;
use Illuminate\Http\Request;

class LoansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Loans::select("*"); 
        if ($request->keyword) {
            $query = $request->keyword;     
            $data->where(function ($q) use($query){
                $q->where('name','LIKE', "%".$query."%")//untuk membuat fitur search ( "%{$query}%" / "%".$query."%" )
                 ->orwhere('return','LIKE', "%".$query."%");
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
        $loan = new Loans;
        $loan->user_id = $userId;
        $loan->name = $request->name;
        $loan->total = $request->total;
        $loan->return = $request->return;
        if ($loan->save()) {
            return ["status" => "Berhasil Menyimpan Data"];
        } else {
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
        if (Loans::where('id',$id)->exists()) {
            Loans::where('id',$id)->first();
        } else{
            return response()->json([
                "message" => "id Not Found"
            ], 404);
        }
        return Loans::where('id',$id)->with('saver')->get();    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Loans::where('id', $id)->first();
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
        $loan = Loans::where('id', $id)->first();
        $loan->name = $request->name;
        $loan->total = $request->total;
        $loan->return = $request->return;
        if ($loan->save()) {
            return ["status" => "Berhasil Merubah Data"];
        } else {
            return ["status" => "Gagal Merubah Data"];
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
        $loan = Loans::where('id', $id)->first();
        if ($loan->delete()) {
            return ["status" => "Berhasil Menghapus Data"];
        } else {
            return ["status" => "Berhasil Menghapus Data"];
        }
    }
}

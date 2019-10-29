<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Mush;

class poTempController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = [
            'nota_id' => "THISISNOTAID",
            'barang_id' => $request->produk_id,
            'jml_barang' => $request->jml_produk,
            'order_price' => $request->harga_total,
            'customer_id' => $request->customer_name."1",
            'user_id' => auth()->user()->id,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];

            if(Session::has('transKey')) {
                $data['trans_session'] = session('transKey');

            } else {
                session(['transKey' => Mush::getUniqStr()]);
                $data['trans_session'] = session('transKey');
            }
            
            $produkby_id = \App\Models\Tbl_temp_po::where('barang_id', '=', $data['barang_id'])
                                                    ->where('trans_session', '=', Session::get('transKey'))
                                                    ->first();

            // dd($produkby_id);

            if($produkby_id == null || $produkby_id->count() == 0) {

                $porder = \App\Models\Tbl_temp_po::create($data);                

            } else {

                $prd = \App\Models\Tbl_temp_po::find($produkby_id->id);

                $jml_new = $prd->jml_barang+$data['jml_barang'];
                $jhrg_new = $jml_new*$prd->getProduk()->product_price;
    
                $prd->jml_barang = $jml_new;
                $prd->order_price = $jhrg_new;
    
                $prd->save();
                
            }
            
            $order = \App\Models\Tbl_temp_po::where('trans_session', '=', session('transKey'))->get();
            
            $produk = \App\Models\Tbl_product::all();
            return back()->with('data_produk', $produk)
                        ->with('data_order', $order)
                        ->with(['msg', 'success']);

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
        //
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
        $potm = \App\Models\Tbl_temp_po::find($id);
        $potm->jml_barang = $request->jml_barang;
        $potm->order_price = $potm->jml_barang*$potm->getProduk()->product_price;
        $potm->save();

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $potm = \App\Models\Tbl_temp_po::find($id);
        
        $potm->forceDelete();

        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
        
    }
}
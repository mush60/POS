<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon as Carbon;
use Session;
use Mush;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penjualan = \App\Models\Tbl_sale::all();
        return view('penjualan.index', ['data_penjualan' => $penjualan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = \App\Models\Tbl_product::all();
        $order = \App\Models\Tbl_temp_po::where('trans_session', '=', session('transKey'))->get();
        return view('penjualan.create_sale', ['data_produk' => $produk, 'data_order' => $order]);
    }

    public function storeTemp(Request $request) 
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

    public function updateTempTrans(Request $request) {



    }

    public function flushSs() {
        Session::forget('transKey');
        Session::forget('customer');
        \App\Models\Tbl_temp_po::truncate();
        return back();
        

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trans_key = $request->trans_key;
        if(is_null($trans_key) || $trans_key == '') {
            Session::flash('status', 'error');
            Session::flash('msg', 'Something Wrong :(');
            return back();
        } else {

            $data['cust_id'] = Session::get('customer.cust_id');
            // dd($request->all());
            $data_temp = \App\Models\Tbl_temp_po::where('trans_session', $trans_key)->get();
            
            $row_po = \App\Models\Tbl_faktur::count();
            
            if($row_po > 0) {
                $nota = \App\Models\Tbl_faktur::max('id');
                $nota_id = $nota + 1;
            } else {
                $nota_id = 1;
            }
            $str_id = str_pad(strval($nota_id), 3, '0', STR_PAD_LEFT);
            $nota_number    = Carbon::now()->format('Ymd').$str_id;
            $cust_id        = Session::get('customer.cust_id');

            $biaya_total    = 0;

            $data = [];

            foreach ($data_temp as $temp) {

                $data[] = array(
                    'nota_number'   => $nota_number,
                    'customer_id'   => $cust_id,
                    'barang_id'     => $temp->barang_id,
                    'jml_barang'    => $temp->jml_barang,
                    'diskon_satuan' => 0,
                    'order_price'   => $temp->order_price,
                    'customer_id'   => $cust_id, 
                    'user_id'       => auth()->user()->id,
                    'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')

                );

                $biaya_total = $biaya_total + $temp->order_price;

            }
            
            // add data into faktur table
            $data_nota = array(
                'nota_number'       => $nota_number,
                'customer_id'       => $cust_id,
                'id_pengiriman'     => 0,
                'order_date'        => Carbon::now()->format('Y-m-d'),
                'order_price'       => $biaya_total,
                'status_pembayaran' => 'utang',
                'sisa_pembayaran'   => $biaya_total,
                'user_id'           => auth()->user()->id
            );

            $faktur = \App\Models\Tbl_faktur::create($data_nota);

            // add data into po table



            // dd($data);
            dd($faktur);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = \App\Models\Tbl_sale::find($id);
        return view('penjualan.show_sale', ['data_penjualan' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('penjualan.edit_sale');
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
        //
    }

    public function delete($id){
        
        return view('penjualan.delete_sale');

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

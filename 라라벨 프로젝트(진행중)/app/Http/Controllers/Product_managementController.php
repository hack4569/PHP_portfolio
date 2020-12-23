<?php
namespace App\Http\Controllers;

use \Illuminate\Http\Request;
use App\Models\Product_info;

class Product_managementController extends Controller
{
    /**
     *  The product info instance 
     */
    protected $product_info;
    protected $request;
    /**
     *  Create a new controller instance
     * 
     * @param Product_info $product_info
     * @return void
     */
    public function __construct(Product_info $product_info)
    {
        $this->product_info = $product_info;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchVar = $this->store(new Request);
        extract($searchVar);
        
        $list = $this->product_info->leftJoin('sales_info','product_info.product_code', '=', 'sales_info.product_code')
        ->where('sales_info.isnew','=','new')
        ->when($sfst_cate, function($query,$sfst_cate){
            return $query->where('product_info.fst_cate', 'like', '%'.$sfst_cate.'%');
        })
        ->when($ssnd_cate, function($query,$ssnd_cate){
            return $query->where('product_info.snd_cate', 'like', '%'.$ssnd_cate.'%');
        })
        ->when($sfst_cate, function($query,$sfst_cate){
            return $query->where('product_info.eng_name', 'like', '%'.$skey.'%');
        })
        ->orderby('product_info.product_code')
        ->get();
        $listArr = $list->toArray();
        return view('productManagement.list')->with('list',$listArr);
        //return view('welcome');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request  $request)
    {
        $searchVar = [];
        $searchVar['sfst_cate'] = $request->has('sfst_cate') ? $request->input['sfst_cate'] : '';
        $searchVar['ssnd_cate'] = $request->has('ssnd_cate') ? $request->input['ssnd_cate'] : '';
        $searchVar['skey'] = $request->has('skey') ? $request->input['skey'] : '';

        return $searchVar;
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
        //
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

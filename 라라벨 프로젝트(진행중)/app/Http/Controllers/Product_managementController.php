<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_info;
use App\Models\Sales_info;
class Product_managementController extends Controller
{
    /**
     *  The product info instance
     */
    protected $product_info;
    protected $sales_info;
    protected $request;
    /**
     *  Create a new controller instance
     *
     * @param Product_info $product_info
     * @return void
     */
    public function __construct(Product_info $product_info, Sales_info $sales_info, Request $request)
    {
        $this->product_info = $product_info;
        $this->sales_info = $sales_info;
        $this->request = $request;
        \Illuminate\Pagination\Paginator::useBootstrap();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skey = $this->request->input('skey');
        $sfst_cate = $this->request->input('sfst_cate');
        $ssnd_cate = $this->request->input('ssnd_cate');
        $searchData = array(
            'sfst_cate' => $sfst_cate,
            'ssnd_cate' => $ssnd_cate,
            'skey' => $skey
        );
        $sfst_cate=='All' ? $sfst_cate='' : $sfst_cate=$sfst_cate;
        $ssnd_cate=='All' ? $ssnd_cate='' : $ssnd_cate=$ssnd_cate;
        $list = $this->product_info->leftJoin('sales_info','product_info.product_code', '=', 'sales_info.product_code')
        ->where('sales_info.isnew','=','new')
        ->when($sfst_cate, function($query,$sfst_cate){
            return $query->where('product_info.fst_cate', 'like', "%$sfst_cate%");
        })
        ->when($ssnd_cate, function($query,$ssnd_cate){
            return $query->where('product_info.snd_cate', 'like', "%$ssnd_cate%");
        })
        ->when($skey, function($query,$skey){
            return $query->where('product_info.eng_name', 'like', "%$skey%");
        })
        ->orderby('product_info.eng_name')
        ->paginate(3);

        return view('productManagement.list')->with([
            'list'=>$list,
            'searchData'=> $searchData
        ]);
        //return view('welcome');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $request = $this->request;

        $rules = [
            'eng_name' => 'required',
            'kor_name' => 'required'
        ];
        $messages = [
            'required' => ':attribute (는)은 필수 입력 항목입니다.'
        ];
        $customattribute = [
            'eng_name' => '영문명',
            'kor_name' => '한글명'
        ];
        $validator = \Validator::make($request->all(), $rules, $messages, $customattribute);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $product_info = $this->product_info;
        $sales_info = $this->sales_info;

        $product_info->fst_cate = $request->fst_cate;
        $product_info->snd_cate = $request->snd_cate;
        $product_info->eng_name = $request->eng_name;
        $product_info->kor_name = $request->kor_name;
        $product_info->origin = $request->origin;
        $product_info->type = $request->type;
        $product_info->personality = $request->personality;
        $product_info->in_price = $request->in_price;
        $product_info->out_price = $request->out_price;
        $product_info->descr = $request->description;

        $product_info->save();
        if(!$product_info){
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }
        $key = $product_info->product_code;
        $sales_info->product_code = $key;
        $sales_info->eng_name = $request->eng_name;
        $sales_info->quantity = 0;
        $sales_info->count = 0;
        $sales_info->initial_stock = $request->stock;
        $sales_info->stock = $request->stock;
        $sales_info->isnew = 'new';
        $sales_info->save();
        if(!$sales_info){
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }
        return redirect('/wine/adm/product_managements')->with('flash_message', '작성하신 글이 저장되었습니다.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productManagement.create');
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
     * @param  int  $product_code
     * @return \Illuminate\Http\Response
     */
    public function edit($product_code)
    {
        $products = $this->product_info->join('sales_info','product_info.product_code', '=', 'sales_info.product_code')
            ->where('sales_info.product_code','=',$product_code)
            ->where('sales_info.isnew','=','new')
            ->orderby('product_info.eng_name')
            ->get();
        return view('productManagement.edit')->with([
            'products'=>$products,
            'product_code'=>$product_code
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $product_code
     * @return \Illuminate\Http\Response
     */
    public function update($product_code)
    {
        $request = $this->request;
        $rules = [
            'eng_name' => ['required'],
            'kor_name' => ['required']
        ];
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $product_info = $this->product_info->where('product_code', $product_code)->first();

        $product_info->fst_cate = $request->fst_cate;
        $product_info->snd_cate = $request->snd_cate;
        $product_info->eng_name = $request->eng_name;
        $product_info->kor_name = $request->kor_name;
        $product_info->origin = $request->origin;
        $product_info->type = $request->type;
        $product_info->personality = $request->personality;
        $product_info->in_price = $request->in_price;
        $product_info->out_price = $request->out_price;
        $product_info->descr = $request->description;

        $product_info->save();
        if(!$product_info){
            return back()->with('flash_message', '글이 저장되지 않았습니다.')->withInput();
        }

        $sales_info = $this->sales_info->where('product_code', $product_code)
            ->update([
                'eng_name'=>$request->eng_name,
                'stock'=>$request->stock
            ]);
        return redirect('/wine/adm/product_managements');
    }

    /**
     * Remove the specified resource from storage
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $this->sales_info->destroy($this->request->selectdel);
        $this->product_info->destroy($this->request->selectdel);
        return redirect('/wine/adm/product_managements');
    }
}

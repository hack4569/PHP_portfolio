@extends('layouts.adm')

@section('title', '상품추가')

@section('leftmenu_js')
    <script>
        //<![CDATA[
        autoChildMenuOpen($('#lnb > li'),'1'); //]]>
    </script>
@endsection

@section('sub_title', '상품추가')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="rForm" name="rForm" action="/wine/adm/product_managements" method="post" enctype="multipart/form-data">
        @csrf
        <div class="product_list_cate layout">
            <p class="manager_cate_font">
                카테고리
            </p>
            <select name="fst_cate" value="1차 카테고리" class="sfst_cate">
                @foreach(Config::get('wineInfo.wineNames') as $key=>$wineName)
                    @continue($key=='All')
                    <option value="{{$key}}"> {{$wineName}}</option>
                @endforeach
            </select>
            <select name="snd_cate" value="2차 카테고리" class="ssnd_cate">
                @foreach(Config::get('wineInfo.wineNames') as $nameKey=>$wineName)
                    @continue($nameKey=='All')
                    <optgroup label="{{$wineName}}">
                        @foreach(Config::get('wineInfo.wineCates') as $cateKey=>$wineCate)
                            @if($nameKey == $cateKey)
                                @foreach($wineCate as $wineSndCate)
                                    <option value="{!! $wineSndCate !!}" >{!! $wineSndCate !!}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>
            <div class="layout">
                <p class="manager_cate_font">상품명(eng)</p>
                <input type="text" name="eng_name" value="{{old('eng_name')}}" class="rg_input" id="eng_name">
                <input type="hidden" name="product_code" value="">
            </div>
            <div class="layout">
                <p class="manager_cate_font">상품명(kor)</p>
                <input type="text" name="kor_name" value="{{old('kor_name')}}" class="rg_input" id="kor_name">
            </div>
            <div class="layout">
                <p class="manager_cate_font">와이너리</p>
                <input type="text" name="origin" value="{{old('origin')}}" class="rg_input" id="origin">
            </div>
            <div class="layout">
                <p class="manager_cate_font">국가</p>
                <input type="text" name="type" value="{{old('type')}}" class="rg_input" id="type">
            </div>
            <div class="layout">
                <p class="manager_cate_font">품종</p>
                <input type="text" name="personality" value="{{old('personality')}}" class="rg_input" id="personality">
            </div>
            <div class="layout">
                <p class="manager_cate_font">재고수량</p>
                <input type="text" name="stock" value="{{old('stock')}}" class="rg_input1" id="stock">
            </div>
            <div class="layout">
                <p class="manager_cate_font">입고가</p>
                <input type="text" name="in_price" value="{{old('in_price')}}" class="rg_input1" id="in_price">
            </div>
            <div class="layout">
                <p class="manager_cate_font">판매가</p>
                <input type="text" name="out_price" value="{{old('out_price')}}" class="rg_input1" id="out_price">
            </div>
            <div class="layout">
                <p class="manager_cate_font">상세설명</p>
                <textarea name="description" id="description" cols="30" rows="20">{{old('descr')}}</textarea>
            </div>

        <div class="btn_wrap rg_btn_wrap">
            <input type="button" id="reg_btn" class="reg_btn img_upload" value="입력하기">
        </div>
        <div class="btn_wrap rg_btn_wrap">
            <a style='display:inline-block; margin-right:10px' class="reg_btn img_upload" href="/wine/adm/product_managements">목록</a>
        </div>
    </form>
@endsection

@section('validate_js')
<script>
    //<![CDATA[
    $(document).ready(function(){
        // 등록버튼
        $("#reg_btn").click(function(){
            $("#rForm").submit();
        });
    });

    //]]>
</script>
@endsection

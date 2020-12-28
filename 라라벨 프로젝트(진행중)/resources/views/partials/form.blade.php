<div class="product_list_cate layout">
    <p class="manager_cate_font">
        카테고리
    </p>
    <select name="sfst_cate" value="1차 카테고리" class="sfst_cate">
        @foreach(Config::get('wineInfo.wineNames') as $key=>$wineName)
            @continue($key=='All')
            <option value="{{$key}}"> {{$wineName}}</option>
        @endforeach
    </select>
    <select name="ssnd_cate" value="2차 카테고리" class="ssnd_cate">
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
@foreach($products as $product)
<div class="layout">
    <p class="manager_cate_font">상품명(eng)</p>
    <input type="text" name="eng_name" value="{{$product->eng_name}}" class="rg_input" id="eng_name">
    <input type="hidden" name="product_code" value="">
</div>
<div class="layout">
    <p class="manager_cate_font">상품명(kor)</p>
    <input type="text" name="kor_name" value="{{$product->kor_name}}" class="rg_input" id="kor_name">
</div>
<div class="layout">
    <p class="manager_cate_font">와이너리</p>
    <input type="text" name="origin" value="{{$product->origin}}" class="rg_input" id="origin">
</div>
<div class="layout">
    <p class="manager_cate_font">국가</p>
    <input type="text" name="type" value="{{$product->type}}" class="rg_input" id="type">
</div>
<div class="layout">
    <p class="manager_cate_font">품종</p>
    <input type="text" name="personality" value="{{$product->personality}}" class="rg_input" id="personality">
</div>
<div class="layout">
    <p class="manager_cate_font">상품이미지</p>
    <input type="file" id="img_upload" name="image">
</div>
<div class="layout">
    <p class="manager_cate_font">재고수량</p>
    <input type="text" name="stock" value="{{$product->initial_stock - $product->quantity}}" class="rg_input1" id="stock">
</div>
<div class="layout">
    <p class="manager_cate_font">입고가</p>
    <input type="text" name="in_price" value="{{$product->in_price}}" class="rg_input1" id="in_price">
</div>
<div class="layout">
    <p class="manager_cate_font">판매가</p>
    <input type="text" name="out_price" value="{{$product->out_price}}" class="rg_input1" id="out_price">
</div>
<div class="layout">
    <p class="manager_cate_font">상세설명</p>
    <textarea name="description" id="description" cols="30" rows="20">{{$product->descr}}</textarea>
</div>
@endforeach

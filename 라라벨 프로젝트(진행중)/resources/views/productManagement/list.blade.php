@extends('layouts.adm')

@section('title', '상품목록')

@section('leftmenu_js')
    <script>
        //<![CDATA[
        autoChildMenuOpen($('#lnb > li'),'1'); //]]>
    </script>
@endsection

@section('sub_title', '상품목록')

@section('content')
<div class="layout1"><a href="/wine/adm/product_managements/create" class="btn_add">제품 추가</a></div>
			<div class="product_list_cate">
				<form name="rForm" id="rForm" method="get" action="/wine/adm/product_managements">
					<p class="manager_cate_font">
							카테고리
					</p>
					<select name="sfst_cate" value="1차 카테고리" class="sfst_cate">
                        @foreach(Config::get('wineInfo.wineNames') as $key=>$wineName)
                            <option value="{{$key}}" {{ $key==$searchData['sfst_cate'] ? "selected":''}}> {{$wineName}}</option>
						@endforeach
                    </select>
					<select name="ssnd_cate" value="2차 카테고리" class="ssnd_cate">
                        @foreach(Config::get('wineInfo.wineNames') as $nameKey=>$wineName)
                            <optgroup label="{{$wineName}}">
                                @foreach(Config::get('wineInfo.wineCates') as $cateKey=>$wineCate)
                                    @if($nameKey == $cateKey)
                                        @foreach($wineCate as $wineSndCate)
                                            <option value="{!! $wineSndCate !!}" {{ $wineSndCate==$searchData['ssnd_cate'] ? "selected":''}} >{!! $wineSndCate !!}</option>
                                        @endforeach
                                    @endif
                                @endforeach
							</optgroup>
						@endforeach
                    </select>

					<div class="product_list_keyword">
						<p class="manager_cate_font">
								상품검색
						</p>
						<input type="text" name="skey" value="{{$searchData['skey']}}" class="skey">
						<div class="skey_submit" id="skey_submit">
							<img src="/images/Search.png" alt="">
						</div>
					</div>
				</form>
				<form action="/wine/adm/product_managements/destroy" name="delForm" id="delForm" method="post">
                    @csrf
					<input type="hidden" name="sfst_cate" value="<?php //echo $sfst_cate;?>">
					<input type="hidden" name="ssnd_cate" value="<?php //echo $ssnd_cate;?>">
					<input type="hidden" name="skey" value="<?php //echo urldecode($skey);?>">
					<div class="productlist_content">
					<table summary="진행현황목록표" class="table_list">
						<caption>진행현황 목록표</caption>
						<colgroup>
							<col width="6%"/>
							<col width="8%"/>
							<col width="14%"/>
							<col width="*"/>
							<col width="11%"/>
							<col width="11%"/>
							<col width="11%"/>
							<col width="10%"/>
						</colgroup>
						<thead>
							<tr>
								<th scope="col"><input type="checkbox" name="allchk" onclick="if (this.checked) all_check(true); else all_check(false);" id="checkAll" value="전체선택" title="전체선택"/></th>
								<th scope="col">NO</th>
								<th scope="col">카테고리</th>
								<th scope="col">상품명</th>
								<th scope="col">수량</th>
								<th scope="col">입고가</th>
								<th scope="col">판매가</th>
								<th scope="col"></th>
							</tr>

						</thead>
						<tbody>
                                @if(count($list) <= 0)
									<tr>
										<td colspan="<?php echo "8";?>">자료가 없습니다.</td>
									</tr>
								@else
                                    @foreach($list as $var)
                                    <tr>
                                        <td><input type="checkbox" name="selectdel[]" value="{{$var->product_code}}" title="선택"/></td>
                                        <td>
											{{$loop->iteration}}
										</td>
                                        <td>
                                            {{ Config::get('wineInfo.wineNames')[$var->fst_cate] }}
                                        </td>
                                        <td style="padding-left:30px">{{$var->eng_name}}</td>
                                        <td>{{$var->initial_stock - $var->quantity}}</td>
                                        <td>{{$var->in_price}}</td>
                                        <td>{{$var->out_price}}</td>
                                        <td>
                                            <a href="/wine/adm/product_managements/{{$var->product_code}}/edit" name="btn_modify"  class="btn_modify" id="btn_modify">수정</a>
                                        </td>
                                    </tr>
                                    @endforeach
								@endif
						</tbody>
					</table>
						<div class="btn_wrap">
							<button id="btn_seldel" class="btn_del">삭제</button>
						</div>
					</div><!-- productlist_content -->
				</form>
                {{ $list->links() }}
			</div>
@endsection

@section('validate_js')
<script>
//<![CDATA[
$(document).ready(function(){
	// 등록버튼
	$("#skey_submit").click(function(){
		$("#rForm").submit();
	});

	//선택삭제버튼
	$("#btn_seldel").click(function(){
		var chk_count = 0;
		var msg = "";

		var f = document.forms.delForm;
		for (var i=0; i<f.length; i++) {
			if (f.elements[i].name == "selectdel[]" && f.elements[i].checked)
				chk_count++;
		}

		if(!chk_count){
			alert("삭제하려는 상품을 한개 이상 선택하세요.");
			return false;
		}

		var msg = "선택한 상품을 삭제하시겠습니까?\n삭제 후에는 복구할 수 없습니다."
		if(confirm(msg)) {
			$("#delForm").submit();
		}
	});
});
//전체선택
function all_check(val){
    var f = document.forms.delForm;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "selectdel[]")
            f.elements[i].checked = val;
    }
}
//]]>
</script>
@endsection

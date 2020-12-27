<?php
include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";

// if($_SESSION['userid']!="admin"){
//     Util::alert_redirect("권한이 없습니다.", "../login.php");
// }
$rfst_cate = isset($_GET['rfst_cate'])?$_GET['rfst_cate']:"rw";

switch ($rfst_cate){
	case 'snack' : 
        $fst_cate_str='간식';
        break;
    case 'cs' :
        $fst_cate_str='Champagne & Sparkling';
        break;
    case 'sw' :
        $fst_cate_str='Sweet Wines';
        break;
    case 'ww':
        $fst_cate_str='White Wine';
        break;
    case 'rw':
        $fst_cate_str='Red Wine';
        break;
}
$rkey = isset($_GET['rkey'])?$_GET['rkey']:"";
$rsnd_cate = isset($_GET['rsnd_cate'])?$_GET['rsnd_cate']:'';
$reng_name = isset($_GET['eng_name'])?$_GET['eng_name']:'';
if($rfst_cate=="" && $rsnd_cate=="" && $rkey==""){
    Util::alert_redirect("데이터가 없습니다", "../main.php");
}
//리스트 조회
$query = "
	select a.fst_cate, a.snd_cate, a.eng_name, a.kor_name, a.image, a.fimage, a.origin, a.personality, a.type, a.descr, a.in_price, a.out_price,
    b.initial_stock, b.quantity
	from product_info a
		left outer join sales_info b
		on a.eng_name = b.eng_name
	where a.eng_name='$reng_name' and b.isnew='new'
    group by a.eng_name";

$result = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($result);
$eng_name = str_replace("'","\'",$row['eng_name']);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title>상세정보 BONHEUR</title>

<?php require ("../comm/common_resource.php");?>

</head>
<body>
<div class="main_content">
<div class="sub_wrap"><!-- footer.php에 닫는 태그가 있음. -->
<div class="topmenu">
	<div  class="tmenu_wrap">
		<!--h1><a href="<?php echo $http_url?>/index.php"><img src="../images/logo.png" alt="카페 보네르" /></a></h1-->

		<?php require("../comm/layout/left_menu.php");?>
	</div>
</div>
	<div class="sub_content">
		<div class="sub_content_layout1">
    		<div class="sub_menu">
    			<?php if(!empty($rfst_cate)){?>
        			<h2><?php echo $fst_cate_str;?></h2>
            		<!--ul>
            			<?php
        			         $two_dep_cate = $wine_cate[$rfst_cate]; 
        			         for($i=0; $i<count($two_dep_cate); $i++){
            			?>
            					<li><a href="<?php echo $http_url?>/product/product_list.php?fst_cate=<?php echo $rfst_cate;?>&snd_cate=<?php echo $two_dep_cate[$i]?>" class="course_btn"><?php echo $two_dep_cate[$i];?></a></li>
            			<?php 
            			      }
            			?>
            		</ul-->
            		<ul></ul>
            	<?php }else if($rkey){?>
            		<h2><?php echo $rkey;?></h2>
            	<?php }?>
    		</div>
    		<div class="product_detail">
    			<div class="product_detail_layout1">
    				<?php 
                		//가로와 세로중 큰 값을 가진쪽을 x으로 설정하고 나머지 값은 그에 맞는 비율로 축소해서 가로, 세로 값을 넘겨 줍니다.
                		$size_factor = 350; //x
                		if($row['fimage']){
                    		$img_dir = "../data/file/".$row['fimage'];
                    		$size = GetImageSize($img_dir);
                    		if($size[0] == 0 ) $size[0]=1;
                    		if($size[1] == 0 ) $size[1]=1;
                    		if($size[0]>$size[1]) { $per=$size_factor / $size[0]; }
                    		else { $per=$size_factor / $size[1]; }
                    		$x_size=$size[0]*$per;
                    		$y_size=$size[1]*$per;
                		}
            		?>
            		<?php if($row['fimage']){?>
            			<img alt="<?php echo $row['kor_name'];?>" style="width: 250px;" src="../data/file/<?php echo $row['fimage']?>">
            		<?php }else{?>
        				<img alt="<?php echo $row['kor_name'];?>" style="width: 250px;"  src="../images/product_list.png">
            		<?php }?>
    			</div>
    			<div class="product_detail_layout2">
    				<h3 class="detail_eng_name"><?php echo $row['eng_name'];?></h3>
    				<p class="detail_kor_name"><?php echo $row['kor_name']?></p>
    				<div class="detail_id">
    					<p>국&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;가 : <?php echo $row['type'];?></p>
    					<p>와이너리 : <?php echo $row['origin'];?></p>
    					<p>품&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;종 : <?php echo $row['personality'];?></p>
    				</div>
    				<div class="detail_stock">
    					<span>재고수량&nbsp;&nbsp;</span>
    					<input type="text" name="detail_stock" value="<?php echo ($row['initial_stock']-$row['quantity'])?>" readOnly />
    				</div>
    				<div class="detail_price_order">
    					<p class="price"><?php echo number_format($row['out_price']);?></p>
    					<span class="stock_control_m loc1" id="stock_control_m">-</span>
    					<input type="text" id="stock_control_t" value="0">
    					<span class="stock_control_p loc2" id="stock_control_p">-</span>
    					<button class="order" id="order">주문하기</button>
    				</div>
    				<!-- <button class="detail_order_cancle" id="detail_order_cancle">
    					주문취소
    				</button> -->
    			</div>
    			<div class="clear"></div>
        			<div class="product_detail_layout3">
        			<p>
        				<?php echo textarea_replace($row['descr']);?>
        			</p>
        			<form name="rForm" id="rForm" action="stock_proc.php" method="post">
        				<input type="hidden" name="order" value="">
        				<input type="hidden" name="quantity" value="">
        				<input type="hidden" name="fst_cate" value="<?php echo $rfst_cate;?>">
        				<input type="hidden" name="snd_cate" value="<?php echo $rsnd_cate;?>">
        				<input type="hidden" name="skey" value="<?php echo $rkey;?>">
        				<input type="hidden" name="eng_name" value="<?php echo $eng_name;?>">
        			</form>
    			</div>
    			<a href="./product_list.php?fst_cate=<?php echo $rfst_cate;?>&snd_cate=<?php echo $rsnd_cate;?>&eng_name=<?php echo $reng_name;?>&skey=<?php echo $rkey;?>" class="detail_prev">이전페이지</a>
    			<?php 
        			mysqli_free_result($result);
    			?>
    	 	</div><!-- product_detail -->
	 	</div><!-- sub_content_layout1 -->
	</div><!-- sub_content -->
</div><!-- main_content -->	
</div>
<script>
	var m_quantity = document.querySelector("#stock_control_m");
	var p_quantity = document.querySelector("#stock_control_p");
	var t_quantity = document.querySelector("#stock_control_t");
	var order = document.querySelector("#order");
	var cancle = document.querySelector("#detail_order_cancle");
	var f = document.rForm;
	console.dir(f);
	t_quantity.addEventListener("blur",function(){
		if(t_quantity.value<0){
			alert("0보다 작을 수 없습니다.");
			t_quantity.value=0;
			return false;
		}
		
	});
	m_quantity.addEventListener("click",function(){
		if(t_quantity.value==0){
			alert("0보다 작을 수 없습니다.");
			return false;
		}
		t_quantity.value=parseInt(t_quantity.value)-1;
	});
	p_quantity.addEventListener("click",function(){
		t_quantity.value=parseInt(t_quantity.value)+1;
	});
	order.addEventListener("click",function(){
		f.elements[0].value="order";
		f.elements[1].value=parseInt(t_quantity.value);
		if(f.elements[1].value==0){
			alert("수량을 입력해주세요");
			return false;
		}
		f.submit();
	});
	cancle.addEventListener("click",function(){
		f.elements[0].value="cancle";
		f.elements[1].value=parseInt(t_quantity.value);
		if(f.elements[1].value==0){
			alert("수량을 입력해주세요");
			return false;
		}
		f.submit();
	});

	
</script>
</body>
</html>
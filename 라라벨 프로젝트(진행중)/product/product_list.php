<?php

include_once  $_SERVER['DOCUMENT_ROOT'] ."/wine/common.php";
require_once $_SERVER['DOCUMENT_ROOT'].'/wine/comm/lib/PHPExcel-1.8/Classes/PHPExcel.php';
include_once $_SERVER['DOCUMENT_ROOT'] ."/wine/comm/JSON_function.php";

$fst_cate = isset($_GET['fst_cate'])?$_GET['fst_cate']:"";

switch ($fst_cate){
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

if(isset($_GET['snd_cate'])){
    if($_GET['snd_cate']=="" || $_GET['snd_cate']=="All"){
        $snd_cate="";
    }else{
        $snd_cate=$_GET['snd_cate'];
    }
}else{
    $snd_cate="";
}
$skey = isset($_GET['skey'])?$_GET['skey']:"";
if($fst_cate=="" && $snd_cate=="" && $skey==""){
    Util::alert_redirect("데이터가 없습니다", "../main.php");
}

// only Redirect variable
$rfst_cate = $fst_cate;
$rsnd_cate = $snd_cate;
$rkey = $skey;

$addquery = "";
if($fst_cate){
    $addquery .= " and a.fst_cate like concat(concat('%', '".$fst_cate."'),'%') ";
}
if($snd_cate){
    $addquery .= " and a.snd_cate like concat(concat('%', '".$snd_cate."'),'%') ";
}
if($skey){
    $addquery .= " and a.eng_name like concat(concat('%', '".$skey."'),'%') ";
}
//리스트 카운트 조회
$query = "
	select count(*) as cnt
	from product_info a
		left outer join sales_info b
		on a.eng_name = b.eng_name
	where b.isnew = 'new' $addquery
    ";

$result = mysqli_query($db_conn, $query);
$row = mysqli_fetch_assoc($result);
$listcnt =  $row['cnt'];

    //리스트 조회
    $query = "
	select *  
	from  product_info a 
		left outer join sales_info b
		on a.eng_name = b.eng_name
	where b.isnew='new' $addquery order by a.eng_name
    ";

    $result = mysqli_query($db_conn, $query);


?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="author" content="BONHEUR"/>
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW"/>
<meta name="keyword" content="BONHEUR"/>

<title>제품목록 BONHEUR</title>

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
        		<?php if(!empty($fst_cate)){?>
        			<h2><?php echo $fst_cate_str;?></h2>
        			
            		<ul>
            			<?php
							 $two_dep_cate = $wine_cate[$fst_cate]; 
							 if($two_dep_cate==""){
								 $two_dep_cate=0;
							 }
        			         if($two_dep_cate==0){
            			    }else{
							for($i=0; $i<count($two_dep_cate); $i++){
						?>
							<li><a href="<?php echo $http_url?>/product/product_list.php?fst_cate=<?php echo $fst_cate;?>&snd_cate=<?php echo $two_dep_cate[$i]?>" class="course_btn"><?php echo $two_dep_cate[$i];?></a></li>
						<?php 
							}
							}
						?>
            		</ul>
            	<?php }else if($skey){?>
            		<h2><?php echo "'$skey'에 대한 검색결과 값입니다.";?></h2>
            	<?php }?>
    		</div>
    		<div class="productlist_content">
    			<?php 
        			if($listcnt==0){
			    ?>
			    	<div style="width:100%">데이터가 없습니다.</div>
    			<?php   
        			}
    			?>
    			<?php while($row = mysqli_fetch_assoc($result)) {?>
        			<div class="product_list">
        			<div class="product_list_img_container">
        			<?php 
                		//가로와 세로중 큰 값을 가진쪽을 x으로 설정하고 나머지 값은 그에 맞는 비율로 축소해서 가로, 세로 값을 넘겨 줍니다.
                		$size_factor = 200; //x
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
            			<img alt="<?php echo $row['kor_name'];?>" style="width: <?php echo $x_size;?>px; height:<?php echo $y_size;?>px;" src="../data/file/<?php echo $row['fimage']?>">
            		<?php }else{?>
        				<img src="../images/product_list.png">
            		<?php }?>
						</div>
						<?php $eng_name = str_replace("'","\'",$row['eng_name']);?>
        				<p class="eng_txt"><strong><?php echo $row['eng_name'];?></strong></p>
        				<p class="kor_txt"><?php echo $row['kor_name'];?></p>
        				<p class="price"><?php echo number_format($row['out_price']);?></p>
        				<p class="stock"><?php echo "재고 : ". ($row['initial_stock']-$row['quantity'])."개"?></p>
						<?php if(($row['initial_stock']-$row['quantity'])==0){?>
							<a href="#;" style="background-color:gray; color:white;" class="order">주문불가</a>
						<?php }else{ ?>
							<a href="./product_detail.php?rfst_cate=<?php echo $fst_cate;?>&rsnd_cate=<?php echo $snd_cate;?>&eng_name=<?php echo $eng_name;?>&rkey=<?php echo $skey;?>" class="order">주문하기</a>
						<?php }?>
        				
        			</div>
    			<?php }?>
    			<?php 
        			mysqli_free_result($result);
    			?>
    	 	</div><!-- productlist_content -->
	 	</div><!-- sub_content_layout1 -->
	</div><!-- sub_content -->
</div><!-- main_content -->	
</div>
</body>
</html>
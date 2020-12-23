<?php 
/**********************************************************
 프로그램명 : public.php
 설명 : 공통함수
 설명 : 공통변수
 **********************************************************/

//====================================================================================================
//XSS 방지
//----------------------------------------------------------------------------------------------------

function convert_content($content, $filter=true)
{
    global $config, $board;
    
    // & 처리 : &amp; &nbsp; 등의 코드를 정상 출력함
    $content = html_symbol($content);
    
    // 공백 처리
    //$content = preg_replace("/  /", "&nbsp; ", $content);
    $content = str_replace("  ", "&nbsp; ", $content);
    $content = str_replace("\n ", "\n&nbsp;", $content);
    
    $content = get_text($content, 1);
    $content = url_auto_link($content);
    
    return $content;
}
function url_auto_link($str){
	global $g5;
	global $config;
	
	$str = str_replace(array("&lt;", "&gt;", "&amp;", "&quot;", "&nbsp;", "&#039;"), array("\t_lt_\t", "\t_gt_\t", "&", '"', "\t_nbsp_\t", "'"), $str);
	$str = preg_replace("/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#!=_\?\/~\+%@;\-\|\,\(\)]+)/i", "\\1<A HREF=\"\\2\" TARGET=\"{$config['cf_link_target']}\">\\2</A>", $str);
	$str = preg_replace("/(^|[\"'\s(])(www\.[^\"'\s()]+)/i", "\\1<A HREF=\"http://\\2\" TARGET=\"{$config['cf_link_target']}\">\\2</A>", $str);
	$str = str_replace(array("\t_nbsp_\t", "\t_lt_\t", "\t_gt_\t", "'"), array("&nbsp;", "&lt;", "&gt;", "&#039;"), $str);
	
	return $str;
}
function get_text($str, $html=0, $restore=false)
{
	$source[] = "<";
	$target[] = "&lt;";
	$source[] = ">";
	$target[] = "&gt;";
	$source[] = "\"";
	$target[] = "&#034;";
	$source[] = "\'";
	$target[] = "&#039;";
	
	if($restore)
		$str = str_replace($target, $source, $str);
		
		// 3.31
		// TEXT 출력일 경우 &amp; &nbsp; 등의 코드를 정상으로 출력해 주기 위함
		if ($html == 0) {
			$str = html_symbol($str);
		}
		
		if ($html) {
			$source[] = "\n";
			$target[] = "<br/>";
		}
		
		return str_replace($source, $target, $str);
}
function html_symbol($str){
    return preg_replace("/\&([a-z0-9]{1,20}|\#[0-9]{0,3});/i", "&#038;\\1;", $str);
}

function textarea_replace($str) {
    $source[] = "\n";
    $target[] = "<br/>";
    return str_replace($target, $source, $str);
}
//====================================================================================================
//페이징 함수
//----------------------------------------------------------------------------------------------------
//$page_num : 현재 페이지 수
//$totalpage : 전체 페이지 수
//$search : 검색 조건
//$searchword : 검색어
//$page : 현재 페이지
//----------------------------------------------------------------------------------------------------
function getpaging($page_num,$totalpage,$search,$flag,$page,$etc=""){
	$boardpage = 10;//페이징 영역
	$pagelist = ceil($page_num/$boardpage);
	$totallist = ceil($totalpage/$boardpage);
	$prev_page = ($pagelist-"1")*$boardpage;
	$next_page=(($pagelist+"1")*$boardpage)-9;
	if($totalpage<$next_page)
		$next_page=$totalpage;

	$i = 1;
    $html = "";
	
	if(($pagelist - 1) == 0) {
		$html .= "";
	}else{
		$html .= "<a href='$page?page_num=1&search=$search&flag=$flag$etc'  class='pg_page pg_start'>[처음]</a>";
		$html .= "<a href='$page?page_num=$prev_page&search=$search&flag=$flag$etc' class='pg_page pg_prev'>[이전]</a>";
	}

	while($i <= $totalpage) {
		if (($i > ($pagelist - 1) * $boardpage) && ($i <= $pagelist * $boardpage)) {
			if($i == $page_num)
				$html .= "<strong class='pg_current'>$i</strong>";
			else
				$html .= "<a href='$page?page_num=$i&search=$search&flag=$flag$etc'  class='pg_page'>$i</a>";
		}
		$i++;
	}

	if($totallist == 0 || $totallist == $pagelist) {
		$html .= "";
	}else{
		$html .= "<a href='$page?page_num=$next_page&search=$search&flag=$flag$etc' class='pg_page pg_next'>[다음]</a>";
		$html .= "<a href='$page?page_num=$totalpage&search=$search&flag=$flag$etc' class='pg_page pg_end'>[맨끝]</a>";
	}

	if ($html){
	    return "<nav class=\"pg_wrap\"><span class=\"pg\">{$html}</span></nav>";
	}else{
	    return "";
	}
}

?>
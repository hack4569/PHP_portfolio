
window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

//관리자 - 자기정보 수정
function openMyInfoModifyPopup(csrf){
	var url = "/member/myinfo_modify_form.php?CSRF_TOKEN="+csrf;
	var win = window.open(url, "MyInfoModify", "width=1015,height=660,scrollbars=no,resizable=yes");
	win.focus();
}

//푸터 - family사이트이동
function openFamilyWin(select_id) {
	var selectObj = document.getElementById(select_id);
	var ObjUrl = "";
	if(selectObj){
		ObjUrl = selectObj.value;
		if(ObjUrl!=""){
			window.open(ObjUrl, "openFamilyWin", "");
		}
	}
}
$( document ).ready(function() {

    $(".header_menu_ico").click(function(){
        $(this).toggleClass("on");
    });

    // 관리자 left메뉴

    
});
function autoChildMenuOpen(temp, sort1, sort2) {
    if (sort1 == 1) {
        sort1 = 0;
    } else {
        sort1 = sort1 - 1;
    }
    if (sort2 == 1) {
        sort2 = 0;
    } else {
        sort2 = sort2 - 1;
    }
    var obj = null;
    temp.each(function(index, item) {
        
        console.log(index);
        console.log(sort1);
        if (index == sort1) {
            obj = $(item);
            console.log(obj, "obj");
            var showObj = $(obj).next();
            console.log(showObj, "showobj");
            //2차 메뉴가 닫혀 있을때
            if (showObj.css("display") == "none") {
                $('#lnb > li > ul').animate({
                    height : "hide"
                }, 0, function() {
                    $('#lnb > li').removeClass('active_menu');
                    $(obj).addClass("active_menu");
                    // 2014-02-21 : 선택된 메뉴만 마이너스로 셋팅!!
                    $(obj).find("span").removeClass('plus');
                    $(obj).find("span").addClass("minus");
                });
                showObj.animate({
                    height : "toggle"
                }, 0, function() {
                    showObj.addClass("active_menu");
                    //$('.con_title').html(showObj.children().eq(sort2).find(" > a").text());	
                });
                
            }

            //2차 메뉴가 열려있을때
            else if (showObj.css("display") == "block") {

                if (url != "") {
                    location.href = url;
                } else {
                    showObj.animate({
                        height : "toggle"
                    }, 0);
                }
            } else {
                $(obj).addClass("active_menu");
                //$('.con_title').html($(obj).text());
            }
        }
    });
}
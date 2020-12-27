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
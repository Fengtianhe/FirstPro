/**
 * Created by Administrator on 2015/9/22 0022.
 */
    $(function(){
        var $li_btn = $("#sel ul li");
        $li_btn.on("click",function(){
            $(this).addClass("selected").siblings().removeClass("selected");
            var $index = $li_btn.index(this);
            $(".content").slideDown();
            $(".content div").eq($index).show().siblings().hide();
        });

        $(".content ul li").on("click",function(){
            $(".content").hide();
            $li_btn.removeClass("selected");
        }).hover(function(){
            $(this).addClass("selected").siblings().removeClass("selected");
        })




    })

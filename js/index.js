//显示第一个元素
// $('#warp_indexs').children(".wrap_index").eq(0).addClass('pic_show');
// $('#left_menu').children("ul").children("li").eq(0).addClass('bgcolor');

$(document).ready(function(){


 	$(document).bind("contextmenu",function(e){
   		return false;
    });

    // var left_menu = document.getElementById("left_menu");
    // var right_img = document.getElementById("warp_indexs");
    // var left_li = left_menu.getElementsByTagName("li");
    // var right_li = right_img.getElementsByTagName("div");
    // for (var i = 0; i < left_li.length; i++) {
    //     left_li[i].index = i;
    //     left_li[i].onclick = function(){
    //         for (var j = 0; j < left_li.length; j++) {
    //             left_li[j].className = "pic_show";
    //             right_li[j].className = "pic_hide";
    //         }
    //         this.className = "bgcolor";
    //         right_li[this.index].className = "";
    //     }
    // }


    layui.use(['layer', 'form'], function(){
        var layer = layui.layer
        ,form = layui.form;
        $(".hot_piont").click(function(){
            layer.open({
                type: 1,
                // shadeClose : false,
                title : false,
                content: $('#show'),
                area: ['1710px', '720px'],
            });
        })
    });


    var mySwiper = new Swiper('.swiper-container',{
          loop: true,
            pagination : '.pagination',
        });  
      $('.btn1').click(function(){
        mySwiper.swipePrev(); 
      })
      $('.btn2').click(function(){
        mySwiper.swipeNext(); 
      })
      
    $(".hot_piont").click(function(){
        if($("#show").html("")){
            var values = $(this).attr("alt");
             $.ajax({
                url:"demo.php", //处理页面的路径
                data:{id:values}, //要提交的数据是一个JSON
                type:"get", //提交方式
                success:function(data){ //回调函数 ,成功时返回的数据存在形参data   
                    $("#show").html(data);
                }
            });
        }
    });

    
    // //页面多长时间不操作就刷新页面
    // var lastTime = new Date().getTime();
    // var currentTime = new Date().getTime();
    // var timeOut = 60 * 1000; //设置超时时间： 1分
    // $(function(){
    //     /* 鼠标移动事件 */
    //     $(document).mouseover(function(){
    //         lastTime = new Date().getTime(); //更新操作时间
    //     });
    //     $(document).click(function(){
    //         lastTime = new Date().getTime(); //更新操作时间
    //     });
    // });
    // var timer = window.setInterval(testTime, 1000);
    // setInterval(timer,1000);
    // /* 定时器  间隔1秒检测是否长时间未操作页面  */

    // function testTime(){
    //     currentTime = new Date().getTime(); //更新当前时间
    //     if(currentTime - lastTime >= timeOut){ //判断是否超时
    //         window.clearInterval(timer);
    //         window.location.reload();
    //     }
    // }


    document.body.addEventListener('touchmove', function(event) {
        event.preventDefault();
    }, false);
    document.body.addEventListener('touchstart', function(event) {
        event.preventDefault();
    }, false);
    document.body.addEventListener('gesturechange', function(event) {
        event.preventDefault();
    }, false);


    // chrome 浏览器直接加上下面这个样式就行了，但是ff不识别
    $('body').css('zoom', 'reset');
    $(document).keydown(function (event) {
        //event.metaKey mac的command键
        if ((event.ctrlKey === true || event.metaKey === true)&& (event.which === 61 || event.which === 107 || event.which === 173 || event.which === 109 || event.which === 187  || event.which === 189)){
            event.preventDefault();
        }
    });
    $(window).bind('mousewheel DOMMouseScroll', function (event) {
        if (event.ctrlKey === true || event.metaKey) {
            event.preventDefault();
        }
    });

});

$(function () {
    /**通用-banner大图自定义缩放**/
    var zoomWidth = 992; //缩放阀值992px, 即所有小于992px的视口都会对原图进行缩放, 只是缩放比例不同
    var maxWidth = 1920; //最大宽度1920px
    var maxWidth1 = 1200; //最大宽度1920px
    var ratio = 1; //缩放比例
    var viewWidth = window.innerWidth; // 视口宽度
    var zoomSlider = function () {
        if (viewWidth < 768) { //当视口小于768时(移动端), 按992比例缩放
            ratio = viewWidth / zoomWidth; //视口宽度除以阀值, 计算缩放比例
        } else if (viewWidth < zoomWidth) { //当视口界于768与992之间时, bootstrap主宽度为750, 这区间图片缩放比例固定.
            ratio = zoomWidth / (zoomWidth + (zoomWidth - 750));
        } else { // PC端不缩放
            ratio = 1;
        }
        //ratio = viewWidth / zoomWidth; //视口宽度除以阀值, 计算缩放比例
        //ratio = (ratio<=1) ? ratio : 1; //如果比例值大于1, 说明视口宽度高于阀值, 则不进行任何缩放
        var width = maxWidth * ratio; //缩放宽度
        var width1 = maxWidth1 * ratio; //缩放宽度
        $("#carousel-example-generic img").each(function () {
            $(this).css({
                "width": width,
                "max-width": width,
                "margin-left": -(width - viewWidth) / 2
            }); //图片自适应居中, 图片宽度与视口宽度差除以2的值, 设置为负margin
        });
        $(".news-ad img").each(function () {
            if(viewWidth>1200){
                viewWidth=1200
            }
            $(this).css({
                "width": width1,
                "max-width": width1,
                "margin-left": -(width1 - viewWidth) / 2
            }); //图片自适应居中, 图片宽度与视口宽度差除以2的值, 设置为负margin
        });
    }
    zoomSlider(); //页面加载时初始化并检查一次.
    /**视口发生变化时的事件**/
    $(window).resize(function () {
        viewWidth = window.innerWidth; // 重置视口宽度
        zoomSlider();//判断是否绽放banner
    });
})
    
    
    
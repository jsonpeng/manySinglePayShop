$(document).ready(function(){
	$('.carousel').carousel({
        interval: 1500
    })
    $("#carousel-example-generic").swipe({
        swipeLeft: function() { $(this).carousel('next'); },
        swipeRight: function() { $(this).carousel('prev'); },
    }); 
	$('.dropdown').mouseover(function(e) {  
        $(this).addClass('open');
    }).mouseleave(function(e){   
        $(this).removeClass('open');
    });
	$('.users').hover(function() {
		$(this).toggleClass('pseudo');
		$(this).children('.user-menu').toggle();
	});
	$('.users-xs').hover(function() {
		$(this).children('.users-menu').toggle();
	});
	$('.toLogin').click(function(){
		$('.zhezhao,.loginframe').show();
	});
	$('.toRegist').click(function(){
		$('.zhezhao,.register').show();
	});
	$('#forgetPassword').click(function(){
		$('.loginframe').hide();
		$('.forgetPassword').show();
	});
	$('#newRegist').click(function(){
		$('.loginframe').hide();
		$('.register').show();
	});
	$(document).on('click','#logout',function(){
		$.zcjyRequest('/auth/logout',function(res){
			if(res){
				layer.msg('您已退出登录');
				window.location.href='/';
			}
		})
	});
	$('.zhezhao').click(function(){
		$(this).hide();
		$('.register,.loginframe,.forgetPassword').hide();
	});
	$('.cha').click(function(){
		$(this).parent().parent().hide();
		$('.zhezhao').hide();
	});
	$('.send-code').click(function(){
		var email = $(this).siblings('input[name=email]').val();
		var type=$(this).attr('data-type');
		console.log(type);
		if($.empty(email)){
			alert('请输入邮箱');
			return false;
		}
		var that=this;
		if(checkEmail(email)){
			if(type=='inputEmail'){
				$.zcjyRequest('/ajax/send_mail_code',function(res){
					if(res){
						sendCode(that);
					}
				},{email:email});	
			}else{
				$.zcjyRequest('/ajax/send_mail_code/change',function(res){
					if(res){
						sendCode(that);
					}
				},{email:email});
			}
		}
	});
	$('.regist').click(function(){
		if(sumByte($('#inputName'))>14||sumByte($('#inputName'))<2){
			alert('账号字符数在2-14之间');
			return false;
		}
		if(sumByte($('#inputPassword'))<6||sumByte($('#inputPassword'))>20){
			alert('密码字符数在6-20之间');
			return false;
		}
		$.zcjyRequest('/auth/reg',function(res){
			if(res){
				layer.msg('注册成功');
				location.reload();
			}
		},$('.regForm').serialize());
	});
	$('.login').click(function(){
		$.zcjyRequest('/auth/login',function(res){
			if(res){
				location.reload();
			}
		},$('.loginForm').serialize())
	})
	$('.reset').click(function(){
		if(sumByte($('#resetPassword'))<6||sumByte($('#resetPassword'))>20){
			alert('密码字符数在6-20之间');
			return false;
		}
			$.zcjyRequest('/ajax/change_account',function(res){
				if(res){
					console.log(res);
					layer.msg('修改成功');
					location.reload();
				}
			},$('.resetForm').serialize())
		
	});
	$(document).on('click','.reply-num',function(){
		$(this).hide();
		$(this).next().fadeToggle();
	});
	$(document).on('click','.shou',function(){

		$(this).parent().hide();
		$(this).parent().prev().show();
	});
	$(".nowrap").each(function(){
		var maxwidth=8;
		var bytesCount=0;
		var str=$(this).text();
		for(var i=0;i<str.length;i++){
			var c=str.charAt(i);
			if(/^[\u0000-\u00ff]$/.test(c)){
				bytesCount += 1;
			}else{
				bytesCount += 2;
			}
		}
		console.log(bytesCount)
		if(bytesCount>maxwidth){
			$(this).text($(this).text().substring(0,maxwidth));
			$(this).html($(this).html()+'…');
		}
	});
	$('.ellipsis').each(function(){
		console.log($(this).height());
		if($(this).height()>44){
			$(this).addClass('show');
		}
	})
	maxHeight($('.ellipsis'));
	// $('.wx_show').hover(function(){
	// 	$('.wx-erweima')
	// })
});
var leaveTime=60;
function sendCode(obj){
	if(leaveTime==0){
		$(obj).attr('disabled',false);
		$(obj).val('发送验证码')
		leaveTime=60;
		return false;
	}
	else{
		leaveTime--;
		console.log(leaveTime);
		$(obj).attr('disabled',true);
		$(obj).val('重新发送('+leaveTime+')');
	}
	setTimeout(function() {
        sendCode(obj);
    },1000);
}
function scrollToLocation(obj) {
	$('html,body').animate({
		scrollTop:obj.offset().top-obj.height()-35
	},800)
}
function maxHeight(sel){
	var sels=[];
	sel.each(function(){
		var i=$(this).height();
		sels.push(i);
	})
	var maxH=Math.max.apply(null, sels);
	sel.height(maxH);
}
function checkEmail(email){
    var str = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
    if (str.test(email)) {
      return true;
    } else {
      alert('请填写正确的邮箱');
      return false;
    }
}
function sumByte(obj){
	var bytesCount=0;
	var str=$(obj).val();
	for(var i=0;i<str.length;i++){
		var c=str.charAt(i);
		if(/^[\u0000-\u00ff]$/.test(c)){
			bytesCount += 1;
		}else{
			bytesCount += 2;
		}
	}
	return bytesCount;
}

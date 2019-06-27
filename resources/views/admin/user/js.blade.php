@section('scripts')
    <script type="text/javascript">
        //发送消息
     $('.authMessage').click(function(){
       var userid=$(this).data('id');
       var username = $(this).data('name');
        layer.open({
        type: 1,
        closeBtn: false,
        shift: 7,
        shadeClose: true,
        shade: 0.8,
        area: ['30%', '280px'],
        title:'发送消息给'+username,
        content: "<div style='padding: 0 15px;'><div class='content' style='min-width: 100%;min-height: 200px;'><div class='ui message hide'></div><div class='field'><textarea class='form-control message-textarea' rows='6' maxlength='255' onkeyup='messageInput(this)' placeholder='请在这里输入内容'></textarea></div></div><div class='actions pull-right' style='    margin-bottom: 15px;'><div onclick='cancleMessage()' style='    display: inline-block;'>取消</div><button disabled='true'  class='message' onclick='sendMessage("+userid+")'>发送</button></div></div>"
         });
     });



     //取消
     function cancleMessage(){
      console.log('取消');
      layer.closeAll();
     }

     //输入框监听事件
     function messageInput(obj){
      var value = $(obj).val();
      if(value.length > 0){
        $('.message').addClass('message-active');
        $('.message').removeAttr('disabled');
      }
      else{
        $('.message').removeClass('message-active');
        $('.message').attr('disabled','true');
      }
     }

     //发送消息给用户
     function sendMessage(userid){
          $.zcjyRequest('/ajax/send_notice/'+userid,function(res){
              if(res){
                  layer.closeAll();
                  layer.msg(res, {
                    icon: 1,
                    skin: 'layer-ext-moon' 
                    });
              }
          },{content:$('.message-textarea').val()},'POST');
     }

     //发送群组消息
     $('.group-notices').click(function(){
       layer.open({
        type: 1,
        closeBtn: false,
        shift: 7,
        shadeClose: true,
        shade: 0.8,
        area: ['30%', '280px'],
        title:'发送消息给当前所有用户',
        content: "<div style='padding: 0 15px;'><div class='content' style='min-width: 100%;min-height: 200px;'><div class='ui message hide'></div><div class='field'><textarea class='form-control message-textarea' rows='6' maxlength='255' onkeyup='messageInput(this)' placeholder='请在这里输入内容'></textarea></div></div><div class='actions pull-right' style='    margin-bottom: 15px;'><div onclick='cancleMessage()' style='    display: inline-block;'>取消</div><button disabled='true'  class='message' onclick='sendGroupMessage()'>发送</button></div></div>"
         });
     });

     //发送群组消息
     function sendGroupMessage(){
        $.zcjyRequest('/ajax/send_group_notice',function(res){
              if(res){
                  layer.closeAll();
                  layer.msg(res, {
                    icon: 1,
                    skin: 'layer-ext-moon' 
                    });
              }
          },{content:$('.message-textarea').val()},'POST');
     }

     $('.setWriter').click(function(){
        var good_wirter_text = parseInt($(this).data('now')) == 0 ? '取消优秀作家' : '设置为优秀作家';
        var user_id = $(this).data('id');
        var that = this;
        $.zcjyRequest('/ajax/set_goodwriter/'+user_id,function(res){
            if(res){
              $.alert(res);
              $(that).text(good_wirter_text);
            }
        });
     });
    </script>
@endsection
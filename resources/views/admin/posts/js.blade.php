@section('scripts')
    <script src="{{ asset('vendor/dropzone/dropzone.js') }}"></script>
    <script type="text/javascript">
 	var myDropzone = $(document.body).dropzone({
        url:'/ajax/upload_file',
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        addRemoveLinks:false,
        maxFiles:100,
        autoQueue: true, 
        previewsContainer: ".dp_upload", 
        clickable: ".dp_upload",
        headers: {
         'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        addedfile:function(file){
            console.log(file);
        },
        totaluploadprogress:function(progress){
			progress=Math.round(progress);
			$('.dp_upload').find('span').text(progress+"%");

        },
        queuecomplete:function(progress){
        	//console.log(progress);
        	// $('.dp_upload').find('span').text('上传完毕√');
        },
        success:function(file,data){
        	if(data.code == 0){
            	$('.dp_upload').find('span').text(data.message.src+',点击可替换附件文件');
            	if(data.message.type == 'image'){
            		$('.dp_upload').find('img').attr('src',data.message.src);
            	}
            	else if(data.message.type == 'sound'){
            		$('.dp_upload').find('audio').show().attr('src',data.message.src);
            	}
                else if(data.message.type == 'excel'){
                  //  console.log($('#import_form').find('input[name=excel_path]'));
                    // $('#import_form').find('input[name=excel_path]').val(data.message.current_src);
                    // $('.import_class').find('button').show();
                    //return;
                }
                else{
                	$('.dp_upload').find('img').attr('src','');
                }
            	$('.dp_upload').find('input').val(data.message.src);
        	}
        	else{
        		$('.dp_upload').find('span').text('上传失败╳ ');
        		alert('文件格式不支持!');
        	}
      },
      error:function(){
      	console.log('失败');
      }
  	});
    </script>
@endsection
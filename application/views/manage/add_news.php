<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_news');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	    <dl>
        			<dt>标题：</dt>
        			<dd>
        			<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        			<input name="title" type="text" class="required" value="<?php if(!empty($title)) echo $title;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>相关楼盘：</dt>
        			<dd>
	        			<input name="house_id" type="hidden" class="required" value="<?php if(!empty($house_id)) echo $house_id;?>" />
	        			<input type="text" name="house_name" value="<?php if(!empty($house_name)) echo $house_name;?>" readonly>
	        			<a lookupgroup="" href="<?php echo site_url('manage/list_house_dialog');?>" class="btnLook">查找带回</a>
        			</dd>
        		</dl>
        		<dl>
        			<dt>封面：</dt>
        			<dd>
        			<div class="file-box">
        			<input type="hidden" name="old_img" value="<?php if(!empty($pic)) echo $pic;?>" />
    				<input type='text' id='textfield' class='txt' value="<?php if(!empty($pic)) echo $pic;?>" />  
			 		<input type='button' class='btn' value='浏览...' />
					<input type="file" name="userfile" class="file" id="fileField"  onchange="document.getElementById('textfield').value=this.value" />
					</div>
        			</dd>
        		</dl>
				
        	    <dl class="nowrap">
        			<dt>图片预览：</dt>
        			<dd id="img"><?php if(!empty($pic)):?><img height="100px" src="<?php echo base_url().'uploadfiles/news/'.$pic;?>" /><?php endif;?></dd>
        		</dl>
        		
        		
        		
        	</fieldset>
    	<fieldset>
    	    <legend>最新动态</legend>
    	    <dl class="nowrap">
    			<dd><textarea class="editor" name="content" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  ><?php if(!empty($content)) echo $content;?></textarea></dd>
    		</dl>
    	</fieldset>
        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>
<script>
$("#fileField").change(function(){
	var objUrl = getObjectURL(this.files[0]);
	if (objUrl) {
		html = '<img height="100px" src="'+objUrl+'" />';
		$("#img").html(html) ;
	}
}) ;
//建立一個可存取到該file的url
function getObjectURL(file) {
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}
</script>


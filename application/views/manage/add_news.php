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
        			<dt>副标题：</dt>
        			<dd>
        			<input name="title2" type="text" value="<?php if(!empty($title2)) echo $title2;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>照片：</dt>
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
        		
        		<dl>
        			<dt>相关小区：</dt>
        			<dd><input name="xq_id" type="hidden" class="required" value="<?php if(!empty($xq_id)) echo $xq_id;?>" />
        			<input type="text" name="xq_name" value="<?php if(!empty($xq_name)) echo $xq_name;?>" readonly>
        			<a lookupgroup="" href="<?php echo site_url('manage/list_xq_dialog');?>" class="btnLook">查找带回</a>
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>首页区域：</dt>
        			<dd>
        			<select class="combox" name="index_area">
	        			<option value="">-不放到首页-</option>
	        			<option value="1" <?php if(!empty($index_area) && $index_area == 1) echo 'selected="selected"';?>>区域1</option>
	        			<option value="2" <?php if(!empty($index_area) && $index_area == 2) echo 'selected="selected"';?>>区域2</option>
	        			<option value="3" <?php if(!empty($index_area) && $index_area == 3) echo 'selected="selected"';?>>区域3</option>
	        			<option value="4" <?php if(!empty($index_area) && $index_area == 4) echo 'selected="selected"';?>>区域4</option>
	        			<option value="5" <?php if(!empty($index_area) && $index_area == 5) echo 'selected="selected"';?>>区域5</option>
        			</select>
        			</dd>
        		</dl>
        	</fieldset>
    	<fieldset>
    	    <legend>新闻详情</legend>
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


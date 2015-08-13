<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_xiaoqu');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	<legend>小区信息</legend>
        	    <dl>
        			<dt>名称：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        				<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>首字母：</dt>
        			<dd>
        				<input name="short" type="text" class="required" value="<?php if(!empty($short)) echo $short;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>简拼：</dt>
        			<dd><input type="text" name="jianpin" class="required" value="<?php if(!empty($jianpin)) echo $jianpin;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>地址：</dt>
        			<dd><input type="text" name="address" class="required" value="<?php if(!empty($address)) echo $address;?>" /></dd>
        		</dl>
        	</fieldset>
        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save" onclick="save_broker();">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>
<script>
function save_broker() {
	
}
</script>

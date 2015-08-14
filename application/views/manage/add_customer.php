<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_customer');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        		<legend>开发商信息</legend>
        	    <dl>
        			<dt>名称：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        				<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>地址：</dt>
        			<dd>
        				<input name="address" type="text" class="required" value="<?php if(!empty($address)) echo $address; ?>" style="width:360px;" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>联系电话：</dt>
        			<dd>
        				<input name="tel" type="text" class="required" value="<?php if(!empty($tel)) echo $tel; ?>" />
        			</dd>
        		</dl>
        	</fieldset>
        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save" onclick="save_customer();">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>

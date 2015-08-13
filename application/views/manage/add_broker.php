<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_broker');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        	<legend>经纪人信息</legend>
        	    <dl>
        			<dt>姓名：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        				<input name="rel_name" type="text" class="required" value="<?php if(!empty($rel_name)) echo $rel_name;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>电话：</dt>
        			<dd>
        				<input name="tel" type="text" class="required" value="<?php if(!empty($tel)) echo $tel;?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>所属公司：</dt>
        			<dd><input type="text" name="company_name" class="required" value="<?php if(!empty($company_name)) echo $company_name;?>" /></dd>
        		</dl>
        		<dl>
        			<dt>熟悉区域：</dt>
        			<dd>
        				<select name="region_id" class="combox">
        					<?php          
				                if (!empty($region_list)):
				            	    foreach ($region_list as $row):
				            	    	$selected = $row->id == $region_id ? "selected" : "";          
				            ?>
        								<option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
        					<?php 
				            		endforeach;
				            	endif;
				            ?>
        				</select>
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

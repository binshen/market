<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_house');?>" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        		<legend>楼盘信息</legend>
        	    <dl>
        			<dt>名称：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        				<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>均价：</dt>
        			<dd>
        				<input name="avg_price" type="text" value="<?php if(!empty($avg_price)) echo $avg_price; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>开盘时间：</dt>
        			<dd>
        				<input name="kp_date" type="text" value="<?php if(!empty($kp_date)) echo $kp_date; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>地址：</dt>
        			<dd>
        				<input name="address" type="text" value="<?php if(!empty($address)) echo $address; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>联系电话：</dt>
        			<dd>
        				<input name="tel" type="text" value="<?php if(!empty($tel)) echo $tel; ?>" />
        			</dd>
        		</dl>
        		
        		
        		<dl>
        			<dt>装修情况：</dt>
        			<dd>
        				<select class="combox" name="decoration_id">
	        			<?php          
			                if (!empty($decoration_list)):
			            	    foreach ($decoration_list as $row):
			            	    	$selected = !empty($decoration_id) && $row->id == $decoration_id ? "selected" : "";          
			            ?>
	        								<option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
	        					<?php 
			            		endforeach;
			            	endif;
			            ?>
	        			</select>
        			</dd>
        		</dl>
        		<dl>
        			<dt>产权：</dt>
        			<dd>
        				<input name="property_right" type="text" value="<?php if(!empty($property_right)) echo $property_right; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>建筑面积：</dt>
        			<dd>
        				<input name="covered_area" type="text" value="<?php if(!empty($covered_area)) echo $covered_area; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>开发商：</dt>
        			<dd>
        				<input name="developer" type="text" value="<?php if(!empty($developer)) echo $developer; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>入住时间：</dt>
        			<dd>
        				<input name="rz_date" type="text" value="<?php if(!empty($rz_date)) echo $rz_date; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>容积率：</dt>
        			<dd>
        				<input name="plot_rate" type="text" value="<?php if(!empty($plot_rate)) echo $plot_rate; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>绿化率：</dt>
        			<dd>
        				<input name="greening_rate" type="text" value="<?php if(!empty($greening_rate)) echo $greening_rate; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>占地面积：</dt>
        			<dd>
        				<input name="floor_area" type="text" value="<?php if(!empty($floor_area)) echo $floor_area; ?>" />
        			</dd>
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

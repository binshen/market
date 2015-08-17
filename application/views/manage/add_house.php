<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
.pageFormContent dl { width: 480px; }
.pageFormContent dl dd { width: 320px; }
.pageFormContent dl dd input { width: 280px; }
span.error { width: 50px; left: 416px; }
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
        	
        	<fieldset>
	    	    <legend>效果图</legend>
	    	    <dl class="nowrap">
	    	    	<dt>
	    	    		<input type="hidden" name="folder" value="<?php if(!empty($folder)) echo $folder;?>" id="folder">
	    	    		<?php if(!empty($folder)):?>
	    	    		<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/1')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
	    	    		<?php else:?>
	    	    		<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/1')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
	    	    		<?php endif;?>
	    	    	</dt>
	    		</dl>
	    		<dl class="nowrap" id="append1">
	    		<?php if(!empty($pics)):?>
	    		<?php foreach($pics as $k=>$v):?>
	    		<?php if($v->type_id == '1'):?>
	    		
	    		<dt style="width: 250px; position:relative; margin-top:20px">
				<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,1);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
				    <div class="fengmian">
				    </div>
					<img height="118" width="200" src="<?php echo base_url().'uploadfiles/pics/'.$folder.'/'.$v->type_id.'/'.$v->pic_short;?>" style="border:1px solid #666;">
					<input type="hidden" size="22" name="pic_short1[]" class="pic_short" value="<?php echo $v->pic_short;?>">
				</dt>
	    		
	    		<?php endif;?>
	    		<?php endforeach;?>
	    		<?php endif;?>
	    		</dl>
	    	</fieldset>
	    	
	    	<fieldset>
	    	    <legend>实景图</legend>
	    	    <dl class="nowrap">
	    	    	<dt>
	    	    	<?php if(!empty($folder)):?>
	    	    	<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/2')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
	    	    	<?php else:?>
	    	    	<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/2')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
	    	    	<?php endif;?>
	    	    	</dt>
	    		</dl>
	    		<dl class="nowrap" id="append2">
	    		<?php if(!empty($pics)):?>
	    		<?php foreach($pics as $k=>$v):?>
	    		<?php if($v->type_id == '2'):?>
	    		
	    		<dt style="width: 250px; position:relative; margin-top:20px">
				<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,2);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
				    <div class="fengmian">
				    </div>
					<img height="118" width="200" src="<?php echo base_url().'uploadfiles/pics/'.$folder.'/'.$v->type_id.'/'.$v->pic_short;?>" style="border:1px solid #666;">
					<input type="hidden" size="22" name="pic_short2[]" class="pic_short" value="<?php echo $v->pic_short;?>">
				</dt>
	    		
	    		<?php endif;?>
	    		<?php endforeach;?>
	    		<?php endif;?>
	    		</dl>
	    	</fieldset>
        	
        	<fieldset>
	    	    <legend>户型图</legend>
	    	    <dl class="nowrap">
	    	    	<dt>
	    	    	<?php if(!empty($folder)):?>
	    	    	<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/3')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
	    	    	<?php else:?>
	    	    	<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/3')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
	    	    	<?php endif;?>
	    	    	</dt>
	    		</dl>
	    		<dl class="nowrap" id="append3">
	    		<?php if(!empty($pics)):?>
	    		<?php foreach($pics as $k=>$v):?>
	    		<?php if($v->type_id == '3'):?>
	    		
	    		<dt style="width: 250px; position:relative; margin-top:20px">
					<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,2);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
				    <div class="fengmian">
				    </div>
					<img height="118" width="200" src="<?php echo base_url().'uploadfiles/pics/'.$folder.'/'.$v->type_id.'/'.$v->pic_short;?>" style="border:1px solid #666;">
					<input type="hidden" size="22" name="pic_short3[]" class="pic_short" value="<?php echo $v->pic_short;?>">
				</dt>
	    		
	    		<?php endif;?>
	    		<?php endforeach;?>
	    		<?php endif;?>
	    		</dl>
	    	</fieldset>
        	
        	<fieldset>
	    	    <legend>项目简介</legend>
	    	    <dl class="nowrap">
	    			<dd><textarea class="editor" name="description" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  tools="simple"><?php if(!empty($description)) echo $description;?></textarea></dd>
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

</script>
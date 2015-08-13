<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_new_house');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        <fieldset>
        	<legend>基本信息</legend>
        	    <dl>
        			<dt>楼盘名称：</dt>
        			<dd>
        			<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        			<input type="hidden" size="22" name="is_bg" value="<?php if(!empty($bg_pic)) echo $bg_pic;?>">
        			<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name;?>" />
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>小区：</dt>
        			<dd><input name="xq_id" type="hidden" class="required" value="<?php if(!empty($xq_id)) echo $xq_id;?>" />
        			<input type="text" name="xq_name" value="<?php if(!empty($xq_name)) echo $xq_name;?>" readonly>
        			<a lookupgroup="" href="<?php echo site_url('manage/list_xq_dialog');?>" class="btnLook">查找带回</a>
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>区域：</dt>
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
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>房源类型：</dt>
        			<dd>
        				<select name="style_id" class="combox" id="selectStyle" ref="selectSubStyle" refUrl="/manage/get_substyle_list/{value}" >
        					<?php          
				                if (!empty($style_list)):
				            	    foreach ($style_list as $row):
				            	    	$selected = !empty($style_id) && $row->id == $style_id ? "selected" : "";          
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
        			<dt>房源类型(二级)：</dt>
        			<dd>
        				<select name="substyle_id" class="combox" id="selectSubStyle">
        					<?php          
				                if (!empty($substyle_list)):
				            	    foreach ($substyle_list as $row):
				            	    	$selected = !empty($substyle_id) && $row['id'] == $substyle_id ? "selected" : "";          
				            ?>
        								<option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
        					<?php 
				            		endforeach;
				            	endif;
				            ?>
        				</select>
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>优惠折扣：</dt>
        			<dd><input name="discount" type="text" class="required" value="<?php if(!empty($discount)) echo $discount;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>均价：</dt>
        			<dd><input name="unit_price" type="text" class="required" value="<?php if(!empty($unit_price)) echo $unit_price;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>开盘日期：</dt>
        			<dd>
        			<input type="text" name="kp_date" class="date required" dateFmt="yyyy-MM-dd" readonly="true" value="<?php if(!empty($kp_date)) echo $kp_date;?>">
        			<a class="inputDateButton" href="javascript:;"></a>
        		</dl>
        		
        		<dl>
        			<dt>交房日期：</dt>
        			<dd>
        			<input type="text" name="jf_date" class="date required" dateFmt="yyyy-MM-dd" readonly="true" value="<?php if(!empty($jf_date)) echo $jf_date;?>">
        			<a class="inputDateButton" href="javascript:;"></a>
        		</dl>
        		
        		<dl>
        			<dt>产权年限：</dt>
        			<dd><input name="cq_limit" type="text" class="required" value="<?php if(!empty($cq_limit)) echo $cq_limit;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>装修标准：</dt>
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
        			<dt>所属商圈：</dt>
        			<dd><input name="bs_area" type="text" class="required" value="<?php if(!empty($bs_area)) echo $bs_area;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>物业管理：</dt>
        			<dd><input name="estate_mng" type="text" class="required" value="<?php if(!empty($estate_mng)) echo $estate_mng;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>物业费：</dt>
        			<dd><input name="estate_price" type="text" class="required" value="<?php if(!empty($estate_price)) echo $estate_price;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>售楼地址：</dt>
        			<dd><input name="sell_addr" type="text" class="required" value="<?php if(!empty($sell_addr)) echo $sell_addr;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>开发商：</dt>
        			<dd><input name="developer" type="text" class="required" value="<?php if(!empty($developer)) echo $developer;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>开发商电话：</dt>
        			<dd><input name="dev_phono" type="text" class="required" value="<?php if(!empty($dev_phono)) echo $dev_phono;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>物业类型：</dt>
        			<dd><input name="estate_type" type="text" class="required" value="<?php if(!empty($estate_type)) echo $estate_type;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>容积率：</dt>
        			<dd><input name="plot_rate" type="text" class="required" value="<?php if(!empty($plot_rate)) echo $plot_rate;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>绿化率：</dt>
        			<dd><input name="greening_rate" type="text" class="required" value="<?php if(!empty($greening_rate)) echo $greening_rate;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>占地面积：</dt>
        			<dd><input name="zd_area" type="text" class="required" value="<?php if(!empty($zd_area)) echo $zd_area;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>建筑面积：</dt>
        			<dd><input name="jz_area" type="text" class="required" value="<?php if(!empty($jz_area)) echo $jz_area;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>建筑设计：</dt>
        			<dd><input name="house_design" type="text" class="required" value="<?php if(!empty($house_design)) echo $house_design;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>主力户型：</dt>
        			<dd><input name="mian_hx" type="text" class="required" value="<?php if(!empty($mian_hx)) echo $mian_hx;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>环线位置：</dt>
        			<dd><input name="circle_line" type="text" class="required" value="<?php if(!empty($circle_line)) echo $circle_line;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>是否推荐：</dt>
        			<dd><select class="combox" name='recommend'>
        			<option value="-1" <?php if(!empty($recommend) && $recommend == '-1') echo 'selected="selected";'?>>否</option>
        			<option value="1" <?php if(!empty($recommend) && $recommend == '1') echo 'selected="selected";'?>>是</option>
        			</select></dd>
        		</dl>
        		
       	</fieldset>
       	
		<fieldset>
    	    <legend>特色标签</legend>
    	    <dl class="nowrap" id="feature_app" style="height:35px;">
    		<?php 
    			if(!empty($feature)):
    				$features = explode(',', $feature);
    				foreach ($features as $feature):
    		?>
    			<a href="javascript:;" class="button feature_selected" onclick="del_feature(this);">
    				<input type="hidden" name="feature[]" value="<?php echo $feature; ?>">
    				<span><?php echo $feature; ?></span>
    			</a>
    		<?php
    				endforeach;
    			endif;	
    		?>
    		</dl>
    		<dl class="nowrap">
    			<div class="tabs" currentIndex="1" eventType="click">
					<div class="tabsHeader">
						<div class="tabsHeaderContent">
							<ul>
								<?php foreach($feature_list as $k=>$v):?>
								<li><a href="javascript:;"><span>
								<?php if($k == 1) echo '小区';?>
								<?php if($k == 2) echo '户型';?>
								<?php if($k == 3) echo '房屋结构';?>
								<?php if($k == 4) echo '位置';?>
								<?php if($k == 5) echo '装修';?>
								<?php if($k == 6) echo '附加';?>
								</span></a></li>
								<?php endforeach;?>
							</ul>
						</div>
					</div>
					<div class="tabsContent" style="height:100px;">
					<?php foreach($feature_list as $k=>$v):?>
						<div>
						<?php foreach($v as $kk=>$vv):?>
							<?php if(!empty($features) && in_array($vv, $features)): ?>
								<a href="javascript:;" class="feature buttonDisabled" >
									<span><?php echo $vv;?></span>
								</a>
							<?php else: ?>
								<a href="javascript:;" class="button feature" onclick="select_feature(this);" >
									<span><?php echo $vv;?></span>
								</a>
							<?php endif; ?>
						<?php endforeach;?>
						</div>
					<?php endforeach;?>
					</div>
						<div class="tabsFooter">
							<div class="tabsFooterContent"></div>
						</div>
				</div>
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
    	    <legend>规划图</legend>
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
    	    <legend>样板间</legend>
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
			<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,3);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
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
    	    <legend>实景图</legend>
    	    <dl class="nowrap">
    	    	<?php if(!empty($folder)):?>
    	    	<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/4')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    	<?php else:?>
    	    	<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/4')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    	<?php endif;?>
    		</dl>
    		<dl class="nowrap" id="append4">
    		<?php if(!empty($pics)):?>
    		<?php foreach($pics as $k=>$v):?>
    		<?php if($v->type_id == '4'):?>
    		
    		<dt style="width: 250px; position:relative; margin-top:20px">
			<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,4);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
			    <div class="fengmian">
			    </div>
				<img height="118" width="200" src="<?php echo base_url().'uploadfiles/pics/'.$folder.'/'.$v->type_id.'/'.$v->pic_short;?>" style="border:1px solid #666;">
				<input type="hidden" size="22" name="pic_short4[]" class="pic_short" value="<?php echo $v->pic_short;?>">
			</dt>
    		
    		<?php endif;?>
    		<?php endforeach;?>
    		<?php endif;?>
    		</dl>
    	</fieldset>
    	
    	<fieldset>
    	    <legend>配套图</legend>
    	    <dl class="nowrap">
    	    	<dt>
    	    		<?php if(!empty($folder)):?>
    	    		<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/5')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    		<?php else:?>
    	    		<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/5')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    		<?php endif;?>
    	    	</dt>
    		</dl>
    		<dl class="nowrap" id="append5">
    		<?php if(!empty($pics)):?>
    		<?php foreach($pics as $k=>$v):?>
    		<?php if($v->type_id == '5'):?>
    		
    		<dt style="width: 250px; position:relative; margin-top:20px">
			<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,5);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
			    
				<img height="118" width="200" src="<?php echo base_url().'uploadfiles/pics/'.$folder.'/'.$v->type_id.'/'.$v->pic_short;?>" style="border:1px solid #666;">
				<input type="hidden" size="22" name="pic_short5[]" class="pic_short" value="<?php echo $v->pic_short;?>">
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
    	    		<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/6/1')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    		<?php else:?>
    	    		<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/6/1')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    		<?php endif;?>
    	    	</dt>
    		</dl>
    		<dl class="nowrap" id="append6">
    		<?php if(!empty($hx_pics)):?>
    		<?php foreach($hx_pics as $k=>$v):?>
    		
    		<dt style="width: 250px; position:relative; margin-top:20px">
			<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,6);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
				<div class="fengmian">
			    </div>
				<img height="118" width="200" src="<?php echo base_url().'uploadfiles/pics/'.$folder.'/6/'.$v->pic_short;?>" style="border:1px solid #666;"><br/>
				<input type="text" name="room[]" size="1" value="<?php echo $v->room;?>" required><label style="width:10px;">室</label><input type="text" name="lounge[]" value="<?php echo $v->lounge;?>" size="1" required><label style="width:10px;">厅</label><input type="text" name="toilet[]" value="<?php echo $v->toilet;?>" size="1" required><label style="width:10px;">卫</label><input type="text" name="area[]"  value="<?php echo $v->area;?>" size="1" required><label style="width:10px;">㎡</label><br />
				<select name="orientation_id[]" class="combox">
        		<?php          
	            	    foreach ($orientation_list as $row):
	            	    	$selected = $row->id == $v->orientation_id ? "selected" : "";
	            ?>
        			<option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
        		<?php 
	            		endforeach;
	            ?>
        		</select>
				<input type='text' name="title[]" value="<?php echo $v->title;?>" placeholder='简述'>
				<input type="hidden" size="22" name="pic_short6[]" class="pic_short" value="<?php echo $v->pic_short;?>">
			</dt>
    		
    		<?php endforeach;?>
    		<?php endif;?>
    		</dl>
    	</fieldset>
        
        
        	
		<fieldset>
    	    <legend>楼盘详情</legend>
    	    <dl class="nowrap">
    			<dd><textarea class="editor" name="description" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  tools="simple"><?php if(!empty($description)) echo $description;?></textarea></dd>
	    		</dl>
    	</fieldset>
    	
    	<fieldset>
				<table class="list nowrap itemDetail" addButton="添加价格" width="100%" >
					<thead>
						<tr>
							<th type="text" width="80" name="month[]"  fieldClass="required" size="30">月份</th>
							<th type="file_class" name="price[]" fieldClass="required" size="10" >价格</th>
							<th type="del" width="30">操作</th>
						</tr>
					</thead>
					<tbody class="tbody" id="file_list">
						<?php if(!empty($list)): 
								foreach($list as $k=>$v):
						?>
						<tr class="unitBox" id="<?php echo "olda".$v->id;?>">
							<td><input type="text" class="required" size='30' name="month[]" value="<?php echo $v->month?>"></td>
							<td><input type="text" class="required" size='10' name="price[]" value="<?php echo $v->price?>"></td>
							<td><a class="btnDel" href="javascript:$('#olda<?php echo $v->id;?>').remove();void(0);"><span>删除</span></a></td>
						</tr>
						<?php 
								endforeach;
							endif;
								
						?>
					</tbody>
				</table>
			</fieldset>
    	
        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save" >保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>
<script>
$(function() {
/*	folder = $("#folder",navTab.getCurrentPanel()).val();
	if(folder != ''){
		callbacktime(folder,-1);
	}*/
    $(".tpsc",navTab.getCurrentPanel())
      .button()
      .click(function( event ) {
        event.preventDefault();
      });

    a = $('[name="is_bg"]').val();
    b = a.split("/");
    $('.pic_short').each(function(){
		if($(this).val() == b[2]){
			html_img = '<img src="<?php echo base_url().'images/fengmian.png';?>" style=" position:absolute; top:0px;">';
			$(this).parent().find('.fengmian').html(html_img);
		}
		
    });

    
});


function callbacktime(time,is_back, type_id){
	id = $("[name='id']",navTab.getCurrentPanel()).val();
	if (id == ''){
		$("#folder",navTab.getCurrentPanel()).val(time);		
	}
	$.getJSON("<?php echo site_url('manage/get_pics')?>"+"/"+time + "/" + type_id + "?_=" +Math.random(),function(data){
		html = '';
		now_pic = [];
		$('input[name="pic_short'+type_id+'[]"]').each(function(index){
			now_pic[index] = $(this).val();
		});
		$.each(data.img,function(index,item){
			path = "<?php echo base_url().'uploadfiles/pics/';?>"+data.time + "/" + type_id +"/"+item;
			if($.inArray(item, now_pic) < 0){
				html+='<dt style="width: 250px; position:relative; margin-top:20px">';
				html+='<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; ">';
				html+='<a href="javascript:void(0);" onclick="del_pic(this,'+type_id+');" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,'+type_id+');" style="text-decoration:none; color:#fff">设为封面</a></div>';
				html+='<div class="fengmian"></div>';
				html+='<img height="118" width="200" src="'+path +'" style="border:1px solid #666;">';
				html+='<input type="hidden" size="22" name="pic_short'+type_id+'[]" value="'+item+'" class="pic_short"></dt>';
			}
		});
		$("#append"+type_id,navTab.getCurrentPanel()).append(html); 
	});

	//兼容chrome
	var isChrome = navigator.userAgent.toLowerCase().match(/chrome/) != null;
	if (isChrome)
		event.returnValue=false;
}

//户型
function callbacktime_huxing(time,is_back, type_id){
	var select_html = '<select name="orientation_id[]">'
		<?php foreach ($orientation_list as $row):?>
        select_html = select_html+'<option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>'
		<?php endforeach;?>
		select_html = select_html+'</select>'
		id = $("[name='id']",navTab.getCurrentPanel()).val();
		if (id == ''){
			$("#folder",navTab.getCurrentPanel()).val(time);		
		}
	$.getJSON("<?php echo site_url('manage/get_pics')?>"+"/"+time + "/" + type_id + "?_=" +Math.random(),function(data){
		html = '';
		now_pic = [];
		$('input[name="pic_short'+type_id+'[]"]').each(function(index){
			now_pic[index] = $(this).val();
		});
		$.each(data.img,function(index,item){
			path = "<?php echo base_url().'uploadfiles/pics/';?>"+data.time + "/" + type_id +"/"+item;
			if($.inArray(item, now_pic) < 0){
				html+='<dt style="width: 250px; position:relative; margin-top:20px">';
				html+='<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; ">';
				html+='<a href="javascript:void(0);" onclick="del_pic(this,'+type_id+');" style="text-decoration:none; color:#fff">删除</a></div>';
				html+='<div class="fengmian"></div>';
				html+='<img height="118" width="200" src="'+path +'" style="border:1px solid #666;"><br /><input type="text" name="room[]" size="1" required>室<input type="text" name="lounge[]" size="1" required>厅<input type="text" name="toilet[]" size="1" required>卫<input type="text" name="area[]" size="1" required>㎡';
				html+='<input type="hidden" name="pic_short'+type_id+'[]" value="'+item+'"><br /><input type="text" name="title[]" placeholder="简述">'+select_html+'</dt>';
			}
		});
		$("#append"+type_id,navTab.getCurrentPanel()).append(html); 
	});

	//兼容chrome
	var isChrome = navigator.userAgent.toLowerCase().match(/chrome/) != null;
	if (isChrome)
		event.returnValue=false;
}

function set_bg(obj,type_id){
	pic = $("#folder",navTab.getCurrentPanel()).val() + '/' + type_id + '/' + $(obj).parent().parent().find('.pic_short').val();
	//将所有是否为封面都变成0，将封面图片删除
/*	$(obj).parent().parent().parent().find('input:[name="is_bg[]"]').each(function(){
		$(this).val('');
	});*/
	$(".fengmian",navTab.getCurrentPanel()).html('');
	$("[name='is_bg']").val(pic);
	//current_bg = $(obj).parent().parent().find('input:[name="is_bg[]"]');
	//current_bg.val(pic);
	html_img = '<img src="<?php echo base_url().'images/fengmian.png';?>" style=" position:absolute; top:0px;">';
	$(obj).parent().parent().find('.fengmian').html(html_img);
}
function del_pic(obj,type_id){
	id = $("[name='id']",navTab.getCurrentPanel()).val();
	folder = $("[name='folder']",navTab.getCurrentPanel()).val();
		current_pic = $(obj).parent().parent().find('input[name="pic_short'+type_id+'[]"]').val();
		$.getJSON("<?php echo site_url('manage/del_pic')?>"+"/"+ folder + "/" + type_id + "/" + current_pic + "/" + id,function(data){
			if(data.flag == 1){
				$("#append"+type_id,navTab.getCurrentPanel()).find('input[name="pic_short'+type_id+'[]"]').each(function(){
					if($(this).val() == data.pic){
						$(this).parent().remove();
					}
				});
			}else{
				alertMsg.warn("删除图片失败，请清理图片缓存并刷新标签页");
			}
		});
}

function select_feature(obj){
	count = $('.feature_selected').length;
	if(count >= 6){
		alertMsg.warn("最多上传6个特色");
		return false;
	}
	btn = '<a href="javascript:;" class="button feature_selected" onclick="del_feature(this);" ><input type="hidden" name="feature[]" value="'+$(obj).children().html()+'">'+$(obj).html()+'</a>';
	$(obj).removeClass('button');
	$(obj).addClass('buttonDisabled');
	$(obj).removeAttr("onclick");
	$('#feature_app').append(btn);
}

function del_feature(obj){
	html = $(obj).find('span').html();
	$('.feature').each(function(){
		if($(this).find('span').html() == html){
			$(obj).remove();
			$(this).removeClass('buttonDisabled');
			$(this).addClass('button');
			$(this).attr("onclick",'select_feature(this)');
		}
	});
}
</script>
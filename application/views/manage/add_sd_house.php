<style type="text/css">
.file-box{ position:relative;width:340px}
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:21px; width:70px;}
.file{ position:absolute; top:0; right:80px; height:24px; filter:alpha(opacity:0);opacity: 0;width:300px }
</style>
<div class="pageContent">
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_sd_house');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        <fieldset>
        	<legend class="topLegend">二手房基本信息</legend>
        	    <dl >
        			<dt>房源名称(标题)：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>">
        				<input type="hidden" name="type_id" value="2">
        				<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name;?>" />
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>副标题(红字)：</dt>
        			<dd><input name="sub_title" type="text" class="required" value="<?php if(!empty($sub_title)) echo $sub_title;?>" /></dd>
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
				            	    	$selected = !empty($region_id) && $row->id == $region_id ? "selected" : "";          
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
        			<dt>总价(万元)：</dt>
        			<dd><input name="total_price" type="text" class="required" value="<?php if(!empty($total_price)) echo $total_price;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>面积(平米)：</dt>
        			<dd><input name="acreage" type="text" class="required" value="<?php if(!empty($acreage)) echo $acreage;?>" /></dd>
        		</dl>
        		
        		
        		<dl>
        			<dt>朝向：</dt>
        			<dd>
        				<select name="orientation_id" class="combox">
        					<?php          
				                if (!empty($orientation_list)):
				            	    foreach ($orientation_list as $row):
				            	    	$orientation_id = empty($orientation_id) ? 2 : $orientation_id;
				            	    	$selected = $row->id == $orientation_id ? "selected" : "";          
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
        			<dt>户型：</dt>
        			<dd>
        				<input name="room" type="text" class="required" value="<?php if(!empty($room)) echo $room;?>" style="width:26px"/>
        				<label style="width:12px;">室</label>
        				<input name="lounge" type="text" class="required" value="<?php if(!empty($lounge)) echo $lounge;?>" style="width:26px"/>
        				<label style="width:12px;">厅</label>
        				<input name="toilet" type="text" class="required" value="<?php if(!empty($toilet)) echo $toilet;?>" style="width:26px"/>
        				<label style="width:12px;">卫</label>
        			</dd>
        		</dl>
        		
        		<dl>
        			<dt>装修状况：</dt>
        			<dd>
        				<select name="decoration_id" class="combox">
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
        			<dt>建造年代：</dt>
        			<dd><input name="build_year" type="text" class="required" value="<?php if(!empty($build_year)) echo $build_year;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>所在楼层：</dt>
        			<dd><input name="floor" type="text" class="required" value="<?php if(!empty($floor)) echo $floor;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>总楼层：</dt>
        			<dd><input name="total_floor" type="text" class="required" value="<?php if(!empty($total_floor)) echo $total_floor;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>物业费(元/平米/月)：</dt>
        			<dd><input name="estate_price" type="text" class="required" value="<?php if(!empty($estate_price)) echo $estate_price;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>配套设施：</dt>
        			<dd><input name="facility" type="text" class="required" value="<?php if(!empty($facility)) echo $facility;?>" /></dd>
        		</dl>
<!--  
        		<dl>
        			<dt>经度：</dt>
        			<dd><input name="longitude" type="text" class="required" value="<?php if(!empty($longitude)) echo $longitude;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>纬度：</dt>
        			<dd><input name="latitude" type="text" class="required" value="<?php if(!empty($latitude)) echo $latitude;?>" /></dd>
        		</dl>
        		
        		<dl>
        			<dt>业务员：</dt>
        			<dd><input name="broker_id" type="hidden" class="required" value="<?php if(!empty($broker_id)) echo $broker_id;?>" />
        			<input type="text" name="broker_name" value="<?php if(!empty($broker_name)) echo $broker_name;?>" readonly>
        			<a lookupgroup="" href="<?php echo site_url('manage/list_broker_dialog');?>" class="btnLook">查找带回</a>
        			</dd>
        		</dl>
-->
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
    	    		<?php if(empty($folder)):?>
    	    			<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.date('YmdHis').'/1')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    		<?php else: ?>
    	    			<a class="tpsc" href="<?php echo site_url('manage/add_pics/'.$folder.'/1')?>" target="dialog" rel="add_pics" title="图片选择" width="800" height="370" mask=true>图片上传</a>
    	    		<?php endif; ?>
    	    		<input type="hidden" name="folder" value="<?php if(!empty($folder)) echo $folder;?>" id="folder">
    	    		<input type="hidden" name="is_bg" value="<?php if(!empty($bg_pic)) echo $bg_pic;?>" id="is_bg">
    	    	</dt>
    		</dl>
    		<dl class="nowrap" id="imageSection">
    			<?php
    				if(!empty($house_img)):
						foreach ($house_img as $img):
							$pic = "/uploadfiles/pics/" . $folder . "/1/" .$img['pic_short'];
    						$pic_short = $img['pic_short'];
    			?>
    			<dt style="width: 250px; position:relative; margin-top:20px">
    				<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; ">
    					<a href="javascript:void(0);" onclick="del_pic(this,1);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;
    					<a href="javascript:void(0);" onclick="set_bg(this,1);" style="text-decoration:none; color:#fff">设为封面</a>
    				</div>
    				<div class="fengmian"></div>
    				<img height="118" width="200" src="<?php echo $pic; ?>" style="border:1px solid #666;">
    				<input type="hidden" size="22" name="pic_short1[]" class="pic_short" value="<?php echo $pic_short; ?>">
    			</dt>
    			<?php
    					endforeach;
    				endif; 
    			?>
    		</dl>
    		
    	</fieldset>
    	
		<fieldset>
    	    <legend>房源描述</legend>
    	    <dl class="nowrap">
    			<dd><textarea class="editor" name="description" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  tools="simple"><?php if(!empty($description)) echo $description;?></textarea></dd>
    		</dl>
    	</fieldset>
<!--      	
    	<fieldset>
    	    <legend>房源图片</legend>
    	    <dl class="nowrap">
    			<dd><textarea class="editor" name="house_pic" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png"  tools="simple"><?php if(!empty($house_pic)) echo $house_pic;?></textarea></dd>
    		</dl>
    	</fieldset>
-->    		
        </div>
        <div class="formBar">
    		<ul>
    			<li><div class="buttonActive"><div class="buttonContent"><button type="submit" class="icon-save" id="btn_submit_form">保存</button></div></div></li>
    			<li><div class="button"><div class="buttonContent"><button type="button" class="close icon-close">取消</button></div></div></li>
    		</ul>
        </div>
	</form>
</div>
<script>

function iframeCallback(form, callback){
	var $form = $(form), $iframe = $("#callbackframe");
	if(!$form.valid()) {return false;}

	if($("#imageSection").children().length == 0) {
		alertMsg.warn("请上传房源效果图");
		return false;
	}
	var bg_pic = $("#is_bg").val();
	if(bg_pic == "") {
		alertMsg.warn("请选择房源图片封面");
		return false;
	}
	
	if ($iframe.size() == 0) {
		$iframe = $("<iframe id='callbackframe' name='callbackframe' src='about:blank' style='display:none'></iframe>").appendTo("body");
	}
	if(!form.ajax) {
		$form.append('<input type="hidden" name="ajax" value="1" />');
	}
	form.target = "callbackframe";
	
	_iframeResponse($iframe[0], callback || DWZ.ajaxDone);
}

$(function() {
	folder = $("#folder",navTab.getCurrentPanel()).val();
	if(folder != ''){
		callbacktime(folder, -1, 1);
	}
    $(".tpsc",navTab.getCurrentPanel())
      .button()
      .click(function( event ) {
        event.preventDefault();
      });

    var a = $('[name="is_bg"]').val();
    var b = a.split("/");
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
				html+='<a href="javascript:void(0);" onclick="del_pic(this,'+type_id+');" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this, 1);" style="text-decoration:none; color:#fff">设为封面</a></div>';
				html+='<div class="fengmian"></div>';
				html+='<img height="118" width="200" src="'+path +'" style="border:1px solid #666;">';
				html+='<input type="hidden" size="22" name="pic_short'+type_id+'[]" class="pic_short" value="'+item+'"></dt>';
			}
		});
		$("#imageSection",navTab.getCurrentPanel()).append(html); 
	});

	//兼容chrome
	var isChrome = navigator.userAgent.toLowerCase().match(/chrome/) != null;
	if (isChrome)
		event.returnValue=false;
}

function set_bg(obj,type_id){
	pic = $("#folder",navTab.getCurrentPanel()).val() + '/' + type_id + '/' + $(obj).parent().parent().find('.pic_short').val();
	$(".fengmian",navTab.getCurrentPanel()).html('');
	$("[name='is_bg']").val(pic);
	html_img = '<img src="<?php echo base_url().'images/fengmian.png';?>" style=" position:absolute; top:0px;">';
	$(obj).parent().parent().find('.fengmian').html(html_img);
}

function del_pic(obj,type_id){
	id = $("[name='id']",navTab.getCurrentPanel()).val();
	folder = $("[name='folder']",navTab.getCurrentPanel()).val();
		current_pic = $(obj).parent().parent().find('input[name="pic_short'+type_id+'[]"]').val();
		$.getJSON("<?php echo site_url('manage/del_pic')?>"+"/"+ folder + "/" + type_id + "/" + current_pic + "/" + id,function(data){
			if(data.flag == 1){
				$("#imageSection",navTab.getCurrentPanel()).find('input[name="pic_short'+type_id+'[]"]').each(function(){
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

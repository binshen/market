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
    <form method="post" enctype="multipart/form-data" action="<?php echo site_url('manage/save_house');?>" class="pageForm required-validate" onsubmit="return iframeCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="55">
        	<fieldset>
        		<legend>楼盘信息</legend>
        	    <dl>
        			<dt>名称：</dt>
        			<dd>
        				<input type="hidden" name="id" value="<?php if(!empty($id)) echo $id;?>" id="house_id">
        				<input type="hidden" name="is_bg" value="<?php if(!empty($bg_pic)) echo $bg_pic;?>" id="is_bg">
        				<input name="name" type="text" class="required" value="<?php if(!empty($name)) echo $name; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>副标题：</dt>
        			<dd>
        				<input name="title" type="text" class="required" value="<?php if(!empty($title)) echo $title; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>均价 (元 / 平方米)：</dt>
        			<dd>
        				<input name="avg_price" type="text" class="required" value="<?php if(!empty($avg_price)) echo $avg_price; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>开盘时间：</dt>
        			<dd>
        				<input name="kp_date" type="text" class="required" value="<?php if(!empty($kp_date)) echo $kp_date; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>地址：</dt>
        			<dd>
        				<input name="address" type="text" class="required" value="<?php if(!empty($address)) echo $address; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>联系电话：</dt>
        			<dd>
        				<input name="tel" type="text" class="required" value="<?php if(!empty($tel)) echo $tel; ?>" />
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
        				<input name="property_right" type="text" class="required" value="<?php if(!empty($property_right)) echo $property_right; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>建筑面积 (平方米)：</dt>
        			<dd>
        				<input name="covered_area" type="text" class="required" value="<?php if(!empty($covered_area)) echo $covered_area; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>入住时间：</dt>
        			<dd>
        				<input name="rz_date" type="text" class="date required" dateFmt="yyyy-MM-dd" readonly="true" value="<?php if(!empty($rz_date)) echo $rz_date; ?>" />
        				<a class="inputDateButton" href="javascript:;"></a>
        			</dd>
        		</dl>
        		<dl>
        			<dt>容积率：</dt>
        			<dd>
        				<input name="plot_rate" type="text" class="required" value="<?php if(!empty($plot_rate)) echo $plot_rate; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>绿化率：</dt>
        			<dd>
        				<input name="greening_rate" type="text" class="required" value="<?php if(!empty($greening_rate)) echo $greening_rate; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>占地面积 (平方米)：</dt>
        			<dd>
        				<input name="floor_area" type="text" class="required" value="<?php if(!empty($floor_area)) echo $floor_area; ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>开发商：</dt>
        			<dd>
        				<input name="developer" type="text" class="required" value="<?php if(!empty($developer)) { echo $developer; } else { echo $this->session->userdata('customer_name'); } ?>" />
        			</dd>
        		</dl>
        		<dl>
        			<dt>微信关键字：</dt>
        			<dd>
        				<input name="keyword" type="text" class="required" value="<?php if(!empty($keyword)) echo $keyword; ?>" id="keyword" />
        			</dd>
        		</dl>
        		<?php if($this->session->userdata('group_id') == 1): ?>
	        		<dl>
	        			<dt>是否置顶：</dt>
	        			<dd>
	        				<select class="combox" name='is_top'>
	        					<option value="-1" <?php if(!empty($is_top) && $is_top == '-1') echo 'selected="selected";'?>>否</option>
	        					<option value="1" <?php if(!empty($is_top) && $is_top == '1') echo 'selected="selected";'?>>是</option>
	        				</select>
	        			</dd>
	        		</dl>
        		<?php endif; ?>
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
				<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
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
				<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
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
					<div style="position:absolute;filter:alpha(opacity=50);-moz-opacity:0.5;-khtml-opacity:0.5;opacity:0.5; top:95px; width:200px; height:24px; line-height:24px; left:6px; background:#000; font-size:12px; font-family:宋体; font-weight:lighter; text-align:center; "><a href="javascript:void(0);" onclick="del_pic(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">删除</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="set_bg(this,<?php echo $v->type_id?>);" style="text-decoration:none; color:#fff">设为封面</a></div>
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
	    			<dd><textarea class="editor" name="description" rows="22" cols="100" upImgUrl="<?php echo site_url('manage/upload_pic')?>" upImgExt="jpg,jpeg,gif,png" tools="simple"><?php if(!empty($description)) echo $description;?></textarea></dd>
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
function iframeCallback(form, callback){
	var $form = $(form), $iframe = $("#callbackframe");
	if(!$form.valid()) {return false;}

	var result = $.ajax({
        type: "POST",
        data: { keyword: $("#keyword").val(), id: $("#house_id").val() },
       	url: "<?php echo site_url('manage/check_keyword/')?>",
       	cache:false,
       	async:false
	}).responseText;
	if(result > 0) {
		alertMsg.warn("微信关键字已经被使用过");
		return false;
	}
	
	if($("#append1").children().length == 0) {
		alertMsg.warn("请上传楼盘效果图");
		return false;
	}
	if($("#append2").children().length == 0) {
		alertMsg.warn("请上传楼盘实景图");
		return false;
	}
	if($("#append3").children().length == 0) {
		alertMsg.warn("请上传楼盘户型图");
		return false;
	}
	var bg_pic = $("#is_bg").val();
	if(bg_pic == "") {
		alertMsg.warn("请选择楼盘图片封面");
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
	$(".tpsc",navTab.getCurrentPanel()).button().click(function( event ) {
		event.preventDefault();
	});
    var a = $('[name="is_bg"]').val();
    var b = a.split("/");
    $('.pic_short').each(function(){
		if($(this).val() == b[2]){
			var html_img = '<img src="<?php echo base_url().'images/fengmian.png';?>" style=" position:absolute; top:0px;">';
			$(this).parent().find('.fengmian').html(html_img);
		}
    });
});

function callbacktime(time, is_back, type_id){
	var id = $("[name='id']", navTab.getCurrentPanel()).val();
	if (id == ''){
		$("#folder", navTab.getCurrentPanel()).val(time);		
	}
	$.getJSON("<?php echo site_url('manage/get_pics')?>"+"/"+time + "/" + type_id + "?_=" +Math.random(),function(data){
		var html = '';
		var now_pic = [];
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

function set_bg(obj,type_id){
	var pic = $("#folder",navTab.getCurrentPanel()).val() + '/' + type_id + '/' + $(obj).parent().parent().find('.pic_short').val();
	$(".fengmian",navTab.getCurrentPanel()).html('');
	$("[name='is_bg']").val(pic);
	var html_img = '<img src="<?php echo base_url().'images/fengmian.png';?>" style=" position:absolute; top:0px;">';
	$(obj).parent().parent().find('.fengmian').html(html_img);
}

function del_pic(obj,type_id){
	var id = $("[name='id']", navTab.getCurrentPanel()).val();
	var folder = $("[name='folder']", navTab.getCurrentPanel()).val();
	var current_pic = $(obj).parent().parent().find('input[name="pic_short'+type_id+'[]"]').val();
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
</script>
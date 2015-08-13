// JavaScript Document
(function (window, $, d) {
		//表单提交对象
	 var idMap = { 
			projname: d.getElementById('input_projname'),//小区名称
			floornum: d.getElementById('input_floornum'),//楼栋号-幢
			roomnum: d.getElementById('input_roomnum'),//楼栋号-室
			hroomnum: d.getElementById('input_hroomnum'),//户型-室
			sittingroom: d.getElementById('input_sittingroom'),//户型-厅
			toiletnum: d.getElementById('input_toiletnum'),//户型-卫
			hnownum: d.getElementById('input_hnownum'),//所在楼层
			totalnum: d.getElementById('input_totalnum'),//总楼层
			housearea: d.getElementById('input_housearea'),//平米
			houseyear: d.getElementById('input_houseyear'),//建造年代
			selComarea: d.getElementById('selComarea'),//朝向
			expectprice: d.getElementById('input_expectprice'),//期望售价
			manage_fee: d.getElementById('input_manage_fee'),//物业费
			support_faci: d.getElementById('input_support_faci'),//配套设施
			housing_tit: d.getElementById('input_housing_tit'),//房源标题
			username: d.getElementById('input_username'),//姓名
			uertel: d.getElementById('input_uertel')//联系电话
		}
	//小区名称	
	idMap.projname.onfocus  = function(){
		$("#sp_projname_error").hide();
		$(this).removeClass('error-bor').addClass('focus');
		$('#sp_projname').show();
	}
	
	idMap.projname.onblur = function () {
		if(idMap.projname.value==''){
			$('#sp_projname').hide();
			$(this).removeClass('focus').addClass('error-bor');
			$("#sp_projname_error").show();
		}
		else{
			
			$(this).next('.sp_ok').css('display','inline-block');
			$(this).removeClass('focus');
			$('#sp_projname').hide();
		}
	};
	//楼栋号
	idMap.floornum.onfocus = function(){
		$(this).addClass('focus');
		document.getElementById('sp_floornum').style.display ='inline-block';
	}
	idMap.floornum.onblur = function(){
		$(this).removeClass('focus');
	}
	idMap.roomnum.onfocus = function(){
		$(this).addClass('focus');
		document.getElementById('sp_floornum').style.display ='inline-block';
	}
	idMap.roomnum.onblur = function(){
		$(this).removeClass('focus');
		document.getElementById('sp_floornum').style.display ='none';
	}
	//户型
	idMap.hroomnum.onfocus = function(){
		$(this).removeClass('error-bor').addClass('focus');
		$('#sp_sittingroom,#sp_sittingroom_error').hide();
		$('#sp_hroomnum').show();
	}
	idMap.hroomnum.onblur = function(){
		if(idMap.hroomnum.value==''){
			$(this).removeClass('focus').addClass('error-bor');
			$('#sp_hroomnum,#sp_sittingroom_error').hide();
		}
		else{
			//验证是否为数字
			
			$(this).removeClass('focus');
		}
	}
	idMap.sittingroom.onfocus = function(){
		$('#sp_hroomnum,#sp_sittingroom_error').hide();
		$(this).removeClass('error-bor').addClass('focus');
		$('#sp_sittingroom').show();
	}
	idMap.sittingroom.onblur = function(){
		if(idMap.sittingroom.value==''){
			$(this).removeClass('focus').addClass('error-bor');
		}
		else{
			//验证是否为数字
			
			$(this).removeClass('focus');
		}
	}
	idMap.toiletnum.onfocus = function(){
		$('#sp_hroomnum,#sp_sittingroom_error').hide();
		$(this).removeClass('error-bor').addClass('focus');
		$('#sp_sittingroom').show();
		
		//$(this).addClass('focus');
	}
	idMap.toiletnum.onblur = function(){
/*		if(idMap.toiletnum.value==''){
			$(this).removeClass('focus').addClass('error-bor');
		}*/
		if(idMap.hroomnum.value==''||idMap.sittingroom.value==''||idMap.toiletnum.value==''){
			$(this).removeClass('focus').addClass('error-bor');
			$('#sp_sittingroom').hide();
			$('#sp_sittingroom_error').show();
			return;
		}
		else if(idMap.toiletnum.value!=''){
			//验证是否为数字
			$(this).removeClass('focus').removeClass('error-bor');
			if(idMap.hroomnum.value!=''&idMap.sittingroom.value!=''){
				$('#sp_sittingroom').hide();
				$(this).next('.sp_ok').css('display','inline-block');
			}
			return;
		}
	}
	//所在楼层
	idMap.hnownum.onfocus = function(){
		$(this).addClass('focus');
	}
	idMap.hnownum.onblur = function(){
		$(this).removeClass('focus').addClass('error-bor');
		$('#sp_hnownum').hide();
		$('#sp_hnownum_error').show();
	}	
	//面积
	idMap.housearea.onfocus = function(){
		$(this).addClass('focus');
		$('#sp_housearea').show();
	}
}(window, jQuery, document))


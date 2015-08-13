// JavaScript Document


$(document).ready(function(){
	//加载地图
	var point = new BMap.Point(mapX, mapY);  
	initBigMap("bigmap", point, '公交');
	addmapresult('tab-traffic', '公交');
	addmapresult('tab-hospital','医疗');
	addmapresult('tab-school','学校');
	addmapresult('tab-trade','超市');
});

//初始化地图
function initBigMap(div, point, condition, housetitle) {
	var map = new BMap.Map(div);
	window.map = map;
	window.point = point;
	map.centerAndZoom(point, 15);
	map.enableScrollWheelZoom();
	//searchcondition(condition);
	$(".tab-traffic-menu").click();
}

//将地图查出的信息插入到页面中
function addmapresult(resultsite, condition) {
	var options = {
		onSearchComplete : function(results) {
			if (local.getStatus() == BMAP_STATUS_SUCCESS) {
				// 判断状态是否正确  
				var s = [];
				var title = '';
				var tags = '';
				for ( var i = 0; i < results.getCurrentNumPois(); i++) {
					var title = results.getPoi(i).title;
					s.push("<li class='" + resultsite + "'><em>"+String.fromCharCode(65 + (i - parseInt(i / 10) * 10))+"</em>——<b>" + title
							+ "</b>&nbsp;-&nbsp;" + results.getPoi(i).address
							+ "</li>");
				}
				document.getElementById(resultsite).innerHTML = s.join("");
			} else {
				document.getElementById(resultsite).innerHTML = "<li>该小区附近没有这种设施！</li>";
			}
			//document.getElementById(resultsite + '-num').innerHTML = results.getNumPois();
		}
	};
	var local = new BMap.LocalSearch(map, options);
	local.searchInBounds(condition, map.getBounds());
}

window.mapSearchResult = null;
function searchcondition(condition,obj) {
	//alert(condition);
	var searchComplete = function(items) {
		window.mapSearchResult = items;
		goToPage(condition,1);
	};
	local = new BMap.LocalSearch(map, {
		onSearchComplete : searchComplete,
		pageCapacity : 50
	});
	local.searchInBounds(condition, map.getBounds());
	$(obj).parent().find('li').removeClass('current');
	$(obj).addClass('current');
	index_eq = $(obj).parent().find('li').index($(obj));
	$('.tab_box_eq').removeClass('tab-main');
	$('.tab_box_eq').addClass('hide');
	$('.tab_box_eq').eq(index_eq).removeClass('hide');
	$('.tab_box_eq').eq(index_eq).addClass('tab-main');
}

function goToPage(condition,j) {
	
	map.clearOverlays(); //删除原本存在的标注
	//设置房源样式
	var myIcon = new BMap.Icon("/images/listicon.png", //图片地址
	new BMap.Size(38, 35), // 标注显示大小
	{
		imageOffset : new BMap.Size(-160, -258)
	// 这里相当于CSS sprites
	});
	var marker = new BMap.Marker(window.point, {
		icon : myIcon
	}); // 创建标注  
	var infoWindow = new BMap.InfoWindow(mapCommAddress, {
		offset : new BMap.Size(5, -13),
		title : '<strong style="font-size:14px;">' + mapComm + '</strong>',
		width : 250,
		enableMessage : false
	}); // 创建信息窗口对象
	
	var sContent = mapComm;
	var point = new BMap.Point(mapX, mapY);
	map.centerAndZoom(point, 15);
	var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
	map.openInfoWindow(infoWindow,point); //开启信息窗口);*/
	
	marker.addEventListener("click", function() {
		marker.openInfoWindow(infoWindow);
	});
	
	map.addOverlay(marker); // 将标注添加到地图中
	items = window.mapSearchResult;
	html = '';
	for ( var i = (j - 1) * 10; i < j * 10 && i < items.getCurrentNumPois(); i++) {
		addMarker(items.getPoi(i), i,condition);
	}
}
function addMarker(item, i,condition) {
	//设置房源样式
	if(condition=='公交'){
		var myIcon = new BMap.Icon(
			"/images/listicon.png", //图片地址
			new BMap.Size(25, 35), // 标注显示大小
			{
				anchor : new BMap.Size(0, 35), // 标注底部小尖尖的偏移量
				
				imageOffset : new BMap.Size(-162, -30), // 这里相当于CSS sprites
				imageSize : new BMap.Size(600, 500)
			});
	}
	if(condition=='医疗'){
		var myIcon = new BMap.Icon(
			"/images/listicon.png", //图片地址
			new BMap.Size(25, 35), // 标注显示大小
			{
				anchor : new BMap.Size(0, 35), // 标注底部小尖尖的偏移量
				
				imageOffset : new BMap.Size(-162, -86), // 这里相当于CSS sprites
				imageSize : new BMap.Size(600, 500)
			});
	}
	if(condition=='学校'){
		var myIcon = new BMap.Icon(
			"/images/listicon.png", //图片地址
			new BMap.Size(25, 35), // 标注显示大小
			{
				anchor : new BMap.Size(0, 35), // 标注底部小尖尖的偏移量
				
				imageOffset : new BMap.Size(-162, -143), // 这里相当于CSS sprites
				imageSize : new BMap.Size(600, 500)
			});
	}
	if(condition=='超市'){
		var myIcon = new BMap.Icon(
			"/images/listicon.png", //图片地址
			new BMap.Size(25, 35), // 标注显示大小
			{
				anchor : new BMap.Size(0, 35), // 标注底部小尖尖的偏移量			
				imageOffset : new BMap.Size(-162, -199), // 这里相当于CSS sprites
				imageSize : new BMap.Size(600, 500)
			});
	}
	var marker = new BMap.Marker(item.point, {
		icon : myIcon
	}); // 创建标注  
	marker.addEventListener("click", function() {
		marker.openInfoWindow(new BMap.InfoWindow(
				'<span style="font-size:12px;">' + item.address + '</span>', {
					offset : new BMap.Size(8, -35),
					title : '<strong style="font-size:14px;">' + item.title	+ '</strong>',
					width : 250,
					enableMessage : false
				}));
	});
	var label = new BMap.Label(String.fromCharCode(65 + (i - parseInt(i / 10) * 10)));
	label.setStyle( {
		border : '0',
		'background' : 'none',
		'color' : '#fff'
	});
	if ((i - parseInt(i / 10) * 10) == 8) {
		label.setOffset(new BMap.Size(8, 2));
	} else if (i == 9) {
		label.setOffset(new BMap.Size(6, 2));
	} else {
		label.setOffset(new BMap.Size(5, 2));
	}
	marker.setLabel(label);
	map.addOverlay(marker); // 将标注添加到地图中

}
// 自定义覆盖物
    function ComplexCustomOverlay(point, text, mouseoverText){
      this._point = point;
      this._text = text;
      this._overText = mouseoverText;
    }
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
      this._map = map;
      var div = this._div = document.createElement("div");
      div.style.position = "absolute";
      div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
      div.style.backgroundColor = "#EE5D5B";
      div.style.border = "1px solid #BC3B3A";
      div.style.color = "white";
      div.style.height = "18px";
      div.style.padding = "2px";
      div.style.lineHeight = "18px";
      div.style.whiteSpace = "nowrap";
      div.style.MozUserSelect = "none";
      div.style.fontSize = "12px"
      var span = this._span = document.createElement("span");
      div.appendChild(span);
      span.appendChild(document.createTextNode(this._text));      
      var that = this;

      var arrow = this._arrow = document.createElement("div");
      arrow.style.background = "url(http://map.baidu.com/fwmap/upload/r/map/fwmap/static/house/images/label.png) no-repeat";
      arrow.style.position = "absolute";
      arrow.style.width = "11px";
      arrow.style.height = "10px";
      arrow.style.top = "22px";
      arrow.style.left = "10px";
      arrow.style.overflow = "hidden";
      div.appendChild(arrow);
     
  

      mp.getPanes().labelPane.appendChild(div);
      
      return div;
    }
    ComplexCustomOverlay.prototype.draw = function(){
      var map = this._map;
      var pixel = map.pointToOverlayPixel(this._point);
      this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
      this._div.style.top  = pixel.y - 30 + "px";
    }
   // var txt = "银湖海岸城", mouseoverTxt = txt + " " + parseInt(Math.random() * 1000,10) + "套" ;
        
    //var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(116.407845,39.914101), "银湖海岸城",mouseoverTxt);

   // mp.addOverlay(myCompOverlay);

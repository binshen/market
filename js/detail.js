// JavaScript Document

$(function(){
	window.loop2 = window.loop3 ='';
	var maxW=Math.max(document.documentElement.clientWidth,window.innerWidth),
	maxH=Math.max(document.documentElement.clientHeight,window.innerHeight);
	var imgH =Math.floor(maxW*280/640);
	$('.swiper-container','.swiper-slide').height(imgH);
	window.loop= new Swiper('#Jm-slider',{
		mode:'horizontal',
		noSwiping:true,
		speed:500,
		followFinger:false
	});
	new Swiper('#Jm-slider-inner1',{
		mode:'horizontal',
		noSwiping:true,
		speed:500,
		followFinger:false,
		pagination: '.pagination-inner1',
		paginationClickable: true,
		loop:true,
		onInit: function(swiper){
		  $('#Jm-slider-inner1').height(imgH);
		}
	});
	
	$(".tabs span").on('touchstart mousedown',function(e){
		e.preventDefault();
		$(".tabs .active").removeClass('active');
		
		if($(this).index()==1){
			$("#Jm-slider .swiper-slide-outer").eq($(this).index()).show();
			if(!loop2){
				window.loop2 = new Swiper('#Jm-slider-inner2',{
					mode:'horizontal',
					noSwiping:true,
					speed:500,
					followFinger:false,
					pagination: '.pagination-inner2',
					paginationClickable: true,
					loop:true
				});	
			}
		}
		if($(this).index()==2){
			$("#Jm-slider .swiper-slide-outer").eq($(this).index()).show();
			if(!loop3){
				window.loop3 = new Swiper('#Jm-slider-inner3',{
					mode:'horizontal',
					noSwiping:true,
					speed:500,
					followFinger:false,
					pagination: '.pagination-inner3',
					paginationClickable: true,
					loop:true,
					onInit: function(swiper){
					  $('#Jm-slider-inner3').height(imgH);
					}
				});
			}
			
		}
		$(this).addClass('active');
		loop.swipeTo( $(this).index());
	})
	$(".tabs span").click(function(e){
		e.preventDefault();
	})
	
	
	var Lazy = {
    eCatch: {},
    eHandle: 0,
    isFunction: function(a) {
        return Object.prototype.toString.call(a) === "[object Function]";
    },
    addEvent: function(c, b, a) {
        if (c.addEventListener) {
            c.addEventListener(b, a, false);
        } else {
            c.attachEvent("on" + b, a);
        }
        this.eCatch[++this.eHandle] = {
            handler: a
        };
        return this.eHandle;
    },
    removeEvent: function(c, b, a) {
        if (c.addEventListener) {
            c.removeEventListener(b, this.eCatch[a].handler, false);
        } else {
            c.detachEvent("on" + b, this.eCatch[a].handler);
        }
    },
    converNodeToArray: function(b) {
        var f = [];
        try {
            f = Array.prototype.slice.call(b, 0);
        } catch(d) {
            for (var c = 0,
            a = b.length; c < a; c++) {
                f.push(b[c]);
            }
        }
        return f;
    },
    each: function(d, c) {
        for (var b = 0,
        a = d.length; b < a; b++) {
            c.call(d[b], b, d[b]);
        }
    },
    create: function(e) {
        e.loading = false;
        e.timmer = undefined;
        e.time_act = 0;
        e.imgList = [];
        this.imgLoad = e.imgLoad;
        var a = e.lazyId,
        c = this,
        d = [];
        a = (typeof a) == "string" ? [].concat(a) : a;
        c.each(a,
        function(g, f) {
            var h = document.getElementById(f);
            if (!h) {
                return;
            }
            var j;
            if (document.querySelectorAll) {
                j = document.querySelectorAll("#" + f + " img");
            } else {
                j = h.getElementsByTagName("img");
            }
            d = d.concat(j && c.converNodeToArray(j));
        });
        c.each(d,
        function(g, f) {
            if (f.getAttribute(e.trueSrc)) {
                e.imgList.push(f);
            }
        });
        e.imgCount = e.imgList.length;
        if (e.jsList) {
            e.jsCount = e.jsList.length;
            for (var b = 0; b < e.jsCount; b++) {
                e.jsList[b].oDom = (typeof(e.jsList[b].id) == "object") ? e.jsList[b].id: document.getElementById(e.jsList[b].id);
            }
        } else {
            e.jsList = [];
            e.jsCount = 0;
        }
        return e;
    },
    checkPhone: function(a) {
        if (a.indexOf("android") > -1 || a.indexOf("iphone") > -1 || a.indexOf("ipod") > -1 || a.indexOf("ipad") > -1) {
            this.isPhone = true;
        } else {
            this.isPhone = false;
        }
    },
    checkLazyLoad: function(a) {
        if (a.indexOf("opera mini") > -1) {
            return false;
        } else {
            return true;
        }
    },
    init: function(b) {
        if (b.imgCount < 1 && b.jsCount < 1) {
            return;
        }
        var a = navigator.userAgent.toLowerCase();
        if (this.checkLazyLoad(a)) {
            this.checkPhone(a);
            b.e1 = this.addEvent(window, "scroll", this.load(b));
            b.e2 = this.addEvent(window, "touchmove", this.load(b));
            b.e3 = this.addEvent(window, "touchend", this.load(b));
            this.loadTime(b);
        } else {
            this.loadOnce(b);
        }
    },
    getImgTop: function(b) {
        var a = 0;
        if (!b) {
            return;
        }
        while (b.offsetParent) {
            a += b.offsetTop;
            b = b.offsetParent;
        }
        return a;
    },
    load: function(a) {
        return function() {
            if (a.loading == true) {
                return;
            }
            a.loading = true;
            if (a.time_act && ((1 * new Date() - a.time_act) > a.delay_tot)) {
                a.timmer && clearTimeout(a.timmer);
                Lazy.loadTime(a);
            } else {
                a.timmer && clearTimeout(a.timmer);
                a.timmer = setTimeout(function() {
                    Lazy.loadTime(a);
                },
                a.delay);
            }
            a.loading = false;
        };
    },
    setSrc: function(e, a) {
        var b = this;
        var d = e.getAttribute(a),
        c = new Image();
        c.onload = function() {
            e.setAttribute("src", d);
            e.removeAttribute(a);
            if (b.imgLoad) {
                b.imgLoad.call(e, e, c.width, c.height);
            }
        };
        c.src = d;
    },
    setJs: function(js) {
        Lazy.isFunction(js) ? js.call(this, this) : eval(js);
    },
    loadTime: function(b) {
        b.time_act = 1 * new Date();
        var f, j, c;
        if (this.isPhone) {
            f = document.documentElement.clientHeight;
            j = window.scrollY;
            c = j + f;
        } else {
            f = document.documentElement.clientHeight || document.body.clientHeight;
            j = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
            c = f + j;
        }
        if (!b.offset) {
            b.offset = f / 2;
        }
        var q = j - b.offset,
        l = c + b.offset;
        var p = [];
        for (var h = 0; h < b.imgCount; h++) {
            var g = b.imgList[h],
            d = g.clientHeight,
            n,
            m;
            if (g.getBoundingClientRect) {
                n = g.getBoundingClientRect().top + j;
            } else {
                n = this.getImgTop(g);
            }
            m = n + d;
            if ((n > q && n < l) || (m > q && m < l)) {
                if (n > j && n < c) {
                    this.setSrc(g, b.trueSrc);
                } else {
                    p.push(g);
                }
                b.imgList.splice(h, 1);
                h--;
                b.imgCount--;
            }
        }
        var a = p.length;
        if (a) {
            for (var h = 0; h < a; h++) {
                var g = p[h];
                this.setSrc(g, b.trueSrc);
            }
        }
        if (b.jsList) {
            for (var h = 0; h < b.jsCount; h++) {
                var e = b.jsList[h];
                var k = this.getImgTop(e.oDom, j);
                if ((k > q && k < l)) {
                    this.setJs.call(e.oDom, e.js);
                    b.jsList.splice(h, 1);
                    h--;
                    b.jsCount--;
                }
            }
        }
        if (b.imgCount == 0 && b.jsCount == 0) {
            this.removeEvent(window, "scroll", b.e1);
            this.removeEvent(window, "touchmove", b.e2);
            this.removeEvent(window, "touchend", b.e3);
        }
    },
    loadOnce: function(d) {
        for (var b = 0; b < d.imgCount; b++) {
            var a = d.imgList[b];
            this.setSrc(a, d.trueSrc);
        }
        if (d.jsList) {
            for (var b = 0; b < d.jsCount; b++) {
                var c = d.jsList[b];
                this.setJs.call(c.oDom, c.js);
            }
        }
    }
};
	//焦点图片按需加载
	var xx = Lazy.create({
		lazyId: "Jm-slider",
		trueSrc: "src1",
		offset: 300,
		delay: 100,
		delay_tot: 5000
	});
	Lazy.init(xx);

	
}) ;		


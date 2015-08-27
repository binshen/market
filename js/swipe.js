
function Swipe(E, w) {
    var O = function() {};
    var k = function(P) {
        setTimeout(P || O, 0);
    };
    var i = {
        addEventListener: !!window.addEventListener,
        touch: ("ontouchstart" in window) || window.DocumentTouch && document instanceof DocumentTouch,
        transitions: (function(P) {
            var R = ["transformProperty", "WebkitTransform", "MozTransform", "OTransform", "msTransform"];
            for (var Q in R) {
                if (P.style[R[Q]] !== undefined) {
                    return true;
                }
            }
            return false;
        })(document.createElement("swipe"))
    };
    if (!E) {
        return;
    }
    var q = E.children[0],
    l = q.children,
    u = l.length;
    var C = parseInt(w.startSlide, 10) || 0,
    J = w.speed || 300,
    I = w.continuous,
    v = w.vertical || false;
    if (I) {
        var z = q.innerHTML;
        if (u == 2) {
            q.innerHTML = z + z;
        } else {
            if (u == 1) {
                q.innerHTML = z + z + z;
            }
        }
    }
    var j = C - 1,
    o = C + 1,
    c, L, K, a, e;
    var m = v ? "height": "width",
    G = v ? "top": "left",
    A = v ? "y": "x";
    function H() {
        L = new Array(l.length);
        E.style.overflow = "hidden";
        K = E.getBoundingClientRect()[m] || (v ? E.offsetHeight: E.offsetWidth);
        q.style[m] = (l.length * K) + "px";
        var R = l.length;
        while (R--) {
            var P = l[R];
            P.style[m] = K + "px";
            P.style.display = "inline";
            P.style.cssFloat = "left";
            P.style.position = "relative";
            P.style[G] = (R * -K) + "px";
            P.setAttribute("data-sindex", R);
            if (u > 2) {
                P.setAttribute("data-index", R);
            } else {
                if (u == 2) {
                    P.setAttribute("data-index", R % 2);
                } else {
                    if (u == 1) {
                        P.setAttribute("data-index", 0);
                    }
                }
            }
            if (i.transitions) {
                var Q = C > R ? -K: (C < R) ? K: 0;
                if (I) {
                    if (C == l.length - 1 && R == 0) {
                        Q = K;
                        o = 0;
                    }
                    if (!C && R == l.length - 1) {
                        Q = -K;
                        j = R;
                    }
                }
                if (R != C) {
                    s(R, Q, 0);
                } else {
                    L[C] = 0;
                }
            }
        }
        if (!i.transitions) {
            q.style[G] = (C * -K) + "px";
        }
    }
    function n() {
        q = E.children[0],
        l = q.children,
        u = l.length;
        H();
    }
    function N() {
        H();
        var P = parseInt(l[C].getAttribute("data-index"));
        k(w.callback && w.callback(P, l[C]));
        E.style.visibility = "visible";
    }
    function r() {
        var Q = l.length;
        while (Q--) {
            if (i.transitions) {
                var P = C > Q ? -K: (C < Q) ? K: 0;
                if (I) {
                    if (C == l.length - 1 && Q == 0) {
                        P = K;
                        o = 0;
                    }
                    if (!C && Q == l.length - 1) {
                        P = -K;
                        j = Q;
                    }
                }
                s(Q, P, 0);
            }
        }
    }
    function B() {
        if (C) {
            b(j, J, -1);
        } else {
            if (I) {
                b(j, J, -1);
            }
        }
    }
    function h() {
        if (C < l.length - 1) {
            b(o, J, 1);
        } else {
            if (I) {
                b(o, J, 1);
            }
        }
    }
    function b(S, P, Q) {
        if (C == S || S < 0 || S > l.length - 1) {
            return;
        }
        if (!c) {
            var R = parseInt(l[S].getAttribute("data-index"));
            k(w.transitionStart && w.transitionStart(R, l[S]));
        }
        if (i.transitions) {
            if (!Q) {
                Q = -Math.abs(C - S) / (C - S);
            }
            if (Q > 0) {
                s(j, -K, 0);
                s(C, L[C] - K, J);
                s(o, L[o] - K, J);
                C = o;
            } else {
                s(o, +K, 0);
                s(C, L[C] + K, J);
                s(j, L[j] + K, J);
                C = j;
            }
        } else {
            M(C * -K, S * -K, P || J);
        }
        j = S - 1;
        C = S;
        o = S + 1;
        var R = parseInt(l[C].getAttribute("data-index"));
        k(w.callback && w.callback(R, l[C]));
    }
    function s(P, R, Q) {
        g(P, R, Q);
        L[P] = R;
    }
    function g(S, V, U) {
        var Q = l[S];
        var T = Q && Q.style;
        if (!T) {
            return;
        }
        var R = v ? 0 : V,
        P = v ? V: 0;
        T.webkitTransitionDuration = T.MozTransitionDuration = T.msTransitionDuration = T.OTransitionDuration = T.transitionDuration = U + "ms";
        T.webkitTransform = "translate(" + R + "px," + P + "px)translateZ(0)";
        T.msTransform = T.MozTransform = T.OTransform = v ? "translateY(" + V + "px)": "translateX(" + V + "px)";
    }
    function M(T, S, P) {
        if (!P) {
            q.style[G] = S + "px";
            return;
        }
        var R = +new Date;
        var Q = setInterval(function() {
            var U = +new Date - R;
            if (U > P) {
                q.style[G] = S + "px";
                if (D) {
                    p();
                }
                var V = parseInt(l[C].getAttribute("data-index"));
                w.transitionEnd && w.transitionEnd.call(event, V, l[C]);
                clearInterval(Q);
                return;
            }
            q.style[G] = (((S - T) * (Math.floor((U / P) * 100) / 100)) + T) + "px";
        },
        4);
    }
    var D = w.auto || 0;
    var f;
    function p() {
        f = setTimeout(h, D);
    }
    function t() {
        clearTimeout(f);
    }
    var y = {};
    var F = {};
    var d;
    var x = {
        handleEvent: function(P) {
            switch (P.type) {
            case "touchstart":
                this.start(P);
                break;
            case "touchmove":
                this.move(P);
                break;
            case "touchend":
                k(this.end(P));
                break;
            case "webkitTransitionEnd":
            case "msTransitionEnd":
            case "oTransitionEnd":
            case "otransitionend":
            case "transitionend":
                k(this.transitionEnd(P));
                break;
            case "resize":
                k(H.call());
                break;
            }
            if (w.stopPropagation) {
                P.stopPropagation();
            }
        },
        start: function(P) {
            r();
            var Q = P.touches[0];
            y = {
                x: Q.pageX,
                y: Q.pageY,
                time: +new Date
            };
            d = undefined;
            F = {};
            c = false;
            q.addEventListener("touchmove", this, false);
            q.addEventListener("touchend", this, false);
        },
        move: function(P) {
            if (l[C].getAttribute("disableSlide") != null) {
                return;
            }
            if (P.touches.length > 1 || P.scale && P.scale !== 1) {
                return;
            }
            if (w.disableScroll) {
                P.preventDefault();
            }
            var Q = P.touches[0];
            F = {
                x: Q.pageX - y.x,
                y: Q.pageY - y.y
            };
            if (typeof d == "undefined") {
                d = !!(d || Math.abs(F[v ? "y": "x"]) < Math.abs(F[v ? "x": "y"]) * 1.2);
            }
            if (!d) {
                P.preventDefault();
                t();
                if (!I) {
                    F[A] = F[A] / ((!C && F[A] > 0 || C == l.length - 1 && F[A] < 0) ? (Math.abs(F[A]) / K + 1) : 1);
                }
                g(j, F[A] + L[j], 0);
                g(C, F[A] + L[C], 0);
                g(o, F[A] + L[o], 0);
                var S = F[A] > 0 ? j: o;
                if (!c && l[S]) {
                    var R = parseInt(l[S].getAttribute("data-index"));
                    k(w.transitionStart && w.transitionStart(R, l[S]));
                }
                c = true;
            }
        },
        end: function(S) {
            var V = +new Date - y.time;
            var R = Number(V) < 250 && Math.abs(F[A]) > 20 || Math.abs(F[A]) > K / 2;
            var U = (!C && F[A] > 0),
            Q = (C == l.length - 1 && F[A] < 0);
            var P = I ? false: U || Q;
            var T = F[A] < 0;
            if (!d) {
                if (R && !P) {
                    if (T) {
                        h();
                    } else {
                        B();
                    }
                } else {
                    s(j, -K, J);
                    s(C, 0, J);
                    s(o, K, J);
                    if (!I) {
                        if (U) {
                            k(w.pastStart && w.pastStart(C, l[C]));
                        }
                        if (Q) {
                            k(w.pastEnd && w.pastEnd(C, l[C]));
                        }
                    }
                }
            }
            q.removeEventListener("touchmove", x, false);
            q.removeEventListener("touchend", x, false);
        },
        transitionEnd: function(Q) {
            r();
            var P = parseInt(Q.target.getAttribute("data-sindex"), 10);
            if (P == C) {
                if (D) {
                    p();
                }
                w.transitionEnd && w.transitionEnd.call(Q, P, l[C]);
            }
        }
    };
    N();
    if (D) {
        p();
    }
    if (i.addEventListener) {
        if (i.touch) {
            q.addEventListener("touchstart", x, false);
        }
        if (i.transitions) {
            q.addEventListener("webkitTransitionEnd", x, false);
            q.addEventListener("msTransitionEnd", x, false);
            q.addEventListener("oTransitionEnd", x, false);
            q.addEventListener("otransitionend", x, false);
            q.addEventListener("transitionend", x, false);
        }
        window.addEventListener("resize", x, false);
    } else {
        window.onresize = function() {
            H();
        };
    }
    return {
        setup: function() {
            n();
        },
        slide: function(Q, P) {
            b(Q, P);
        },
        prev: function() {
            t();
            B();
        },
        next: function() {
            t();
            h();
        },
        getPos: function() {
            return C;
        },
        stop: function() {
            t();
        },
        start: function() {
            p();
        },
        getNumSlides: function() {
            return u;
        },
        kill: function() {
            t();
            q.style[m] = "auto";
            q.style[G] = 0;
            var Q = l.length;
            while (Q--) {
                var P = l[Q];
                P.style[m] = "100%";
                P.style[G] = 0;
                if (i.transitions) {
                    g(Q, 0, 0);
                }
            }
            if (i.addEventListener) {
                q.removeEventListener("touchstart", x, false);
                q.removeEventListener("webkitTransitionEnd", x, false);
                q.removeEventListener("msTransitionEnd", x, false);
                q.removeEventListener("oTransitionEnd", x, false);
                q.removeEventListener("otransitionend", x, false);
                q.removeEventListener("transitionend", x, false);
                window.removeEventListener("resize", x, false);
            } else {
                window.onresize = null;
            }
        }
    };
}
if (window.jQuery || window.Zepto) { (function(a) {
        a.fn.Swipe = function(b) {
            return this.each(function() {
                a(this).data("Swipe", new Swipe(a(this)[0], b));
            });
        };
    })(window.jQuery || window.Zepto);
}
function swipe(c, o) {
    var n = function() {};
    var o = o || {},
    h = parseInt(o.startSlide, 10) || 0,
    d = o.speed || 0,
    e = o.transitionStart || n,
    m = o.callback || n,
    a = o.nav || null,
    f = a && a.children;
    var g = c.children[0],
    b = g.children;
    if (a) {
        if (f.length > 0) {
            f[h].className = "current";
        } else {
            var l = "";
            k(b,
            function(q, p) {
                l += "<span class=" + (q == h ? "current": "") + ">" + (q + 1) + "</span>";
            });
            a.innerHTML = l;
            f = a.children;
        }
    }
    o.callback = function(p, q) {
        if (a) {
            f[h].className = "";
            f[p].className = "current";
            h = p;
        }
        m(p, q);
        j(q);
    };
    o.transitionStart = function(q, p) {
        j(p);
        e(q, p);
    };
    var i = new Swipe(c, o);
    f && k(f,
    function(q, p) {
        p.addEventListener("click",
        function() {
            i.stop();
            i.slide(q, d);
        },
        false);
    });
    function k(q, s) {
        for (var r = 0,
        p = q.length; r < p; r++) {
            s.call(this, r, q[r]);
        }
    }
    function j(p) {
        var q = p.querySelectorAll("img[src2]");
        if (!q) {
            return;
        }
        k(q,
        function(s, u) {
            var t = u.getAttribute("src2"),
            r = new Image();
            r.onload = function() {
                u.style.cssText = "filter:alpha(opacity=30);opacity:0.3;";
                u.setAttribute("src", t);
                u.removeAttribute("src2");
                setTimeout(function() {
                    u.style.cssText = "filter:alpha(opacity=100);opacity:1;-webkit-transition:250ms;-moz-transition:250ms;transition:250ms;";
                },
                5);
            };
            r.src = t;
        });
    }
    return i;
}
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
	
function lazyforslide(){
	//焦点图片按需加载
	var xx = Lazy.create({
	    lazyId: "J_slideWrap",
	    trueSrc: "src1",
	    offset: 300,
	    delay: 100,
	    delay_tot: 5000
	});
	Lazy.init(xx);
}

function lazyforselectbbs(){
	//精选图片按需加载
	var xx = Lazy.create({
	lazyId: "Jm-pic-list",
	trueSrc: 'src1',
	offset: 300,
	delay: 100,
	delay_tot: 1000                    
	});         
	Lazy.init(xx);
}
//lazyforselectbbs();
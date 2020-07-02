$(function () {
    $('.copy-code').click(function () {
        var urlbox = $(this).data('target');
        $("." + urlbox).select();
        document.execCommand('Copy');
        alert('복사되었습니다.');
    });

    $(".collapse").on('shown.bs.collapse', function () {
        autosize($(this).find('.code-view'));
    });
});

//토큰 생성
function _get_delete_token(f) {
    var token = "";

    $.ajax({
        type: "POST",
        url: g5_bbs_url + "/ajax.comment_token.php",
        cache: false,
        async: false,
        dataType: "json",
        success: function (data) {
            if (data.error) {
                alert(data.error);
                if (data.url)
                    document.location.href = data.url;

                return false;
            }

            token = data.token;
        }
    });

    return token;
}


/*!
    autosize 4.0.2
    license: MIT
    http://www.jacklmoore.com/autosize
*/
(function (global, factory) {
    if (typeof define === "function" && define.amd) {
        define(['module', 'exports'], factory);
    } else if (typeof exports !== "undefined") {
        factory(module, exports);
    } else {
        var mod = {
            exports: {}
        };
        factory(mod, mod.exports);
        global.autosize = mod.exports;
    }
})(this, function (module, exports) {
    'use strict';

    var map = typeof Map === "function" ? new Map() : function () {
        var keys = [];
        var values = [];

        return {
            has: function has(key) {
                return keys.indexOf(key) > -1;
            },
            get: function get(key) {
                return values[keys.indexOf(key)];
            },
            set: function set(key, value) {
                if (keys.indexOf(key) === -1) {
                    keys.push(key);
                    values.push(value);
                }
            },
            delete: function _delete(key) {
                var index = keys.indexOf(key);
                if (index > -1) {
                    keys.splice(index, 1);
                    values.splice(index, 1);
                }
            }
        };
    }();

    var createEvent = function createEvent(name) {
        return new Event(name, { bubbles: true });
    };
    try {
        new Event('test');
    } catch (e) {
        // IE does not support `new Event()`
        createEvent = function createEvent(name) {
            var evt = document.createEvent('Event');
            evt.initEvent(name, true, false);
            return evt;
        };
    }

    function assign(ta) {
        if (!ta || !ta.nodeName || ta.nodeName !== 'TEXTAREA' || map.has(ta)) return;

        var heightOffset = null;
        var clientWidth = null;
        var cachedHeight = null;

        function init() {
            var style = window.getComputedStyle(ta, null);

            if (style.resize === 'vertical') {
                ta.style.resize = 'none';
            } else if (style.resize === 'both') {
                ta.style.resize = 'horizontal';
            }

            if (style.boxSizing === 'content-box') {
                heightOffset = -(parseFloat(style.paddingTop) + parseFloat(style.paddingBottom));
            } else {
                heightOffset = parseFloat(style.borderTopWidth) + parseFloat(style.borderBottomWidth);
            }
            // Fix when a textarea is not on document body and heightOffset is Not a Number
            if (isNaN(heightOffset)) {
                heightOffset = 0;
            }

            update();
        }

        function changeOverflow(value) {
            {
                // Chrome/Safari-specific fix:
                // When the textarea y-overflow is hidden, Chrome/Safari do not reflow the text to account for the space
                // made available by removing the scrollbar. The following forces the necessary text reflow.
                var width = ta.style.width;
                ta.style.width = '0px';
                // Force reflow:
                /* jshint ignore:start */
                ta.offsetWidth;
                /* jshint ignore:end */
                ta.style.width = width;
            }

            ta.style.overflowY = value;
        }

        function getParentOverflows(el) {
            var arr = [];

            while (el && el.parentNode && el.parentNode instanceof Element) {
                if (el.parentNode.scrollTop) {
                    arr.push({
                        node: el.parentNode,
                        scrollTop: el.parentNode.scrollTop
                    });
                }
                el = el.parentNode;
            }

            return arr;
        }

        function resize() {
            if (ta.scrollHeight === 0) {
                // If the scrollHeight is 0, then the element probably has display:none or is detached from the DOM.
                return;
            }

            var overflows = getParentOverflows(ta);
            var docTop = document.documentElement && document.documentElement.scrollTop; // Needed for Mobile IE (ticket #240)

            ta.style.height = '';
            ta.style.height = ta.scrollHeight + heightOffset + 'px';

            // used to check if an update is actually necessary on window.resize
            clientWidth = ta.clientWidth;

            // prevents scroll-position jumping
            overflows.forEach(function (el) {
                el.node.scrollTop = el.scrollTop;
            });

            if (docTop) {
                document.documentElement.scrollTop = docTop;
            }
        }

        function update() {
            resize();

            var styleHeight = Math.round(parseFloat(ta.style.height));
            var computed = window.getComputedStyle(ta, null);

            // Using offsetHeight as a replacement for computed.height in IE, because IE does not account use of border-box
            var actualHeight = computed.boxSizing === 'content-box' ? Math.round(parseFloat(computed.height)) : ta.offsetHeight;

            // The actual height not matching the style height (set via the resize method) indicates that 
            // the max-height has been exceeded, in which case the overflow should be allowed.
            if (actualHeight < styleHeight) {
                if (computed.overflowY === 'hidden') {
                    changeOverflow('scroll');
                    resize();
                    actualHeight = computed.boxSizing === 'content-box' ? Math.round(parseFloat(window.getComputedStyle(ta, null).height)) : ta.offsetHeight;
                }
            } else {
                // Normally keep overflow set to hidden, to avoid flash of scrollbar as the textarea expands.
                if (computed.overflowY !== 'hidden') {
                    changeOverflow('hidden');
                    resize();
                    actualHeight = computed.boxSizing === 'content-box' ? Math.round(parseFloat(window.getComputedStyle(ta, null).height)) : ta.offsetHeight;
                }
            }

            if (cachedHeight !== actualHeight) {
                cachedHeight = actualHeight;
                var evt = createEvent('autosize:resized');
                try {
                    ta.dispatchEvent(evt);
                } catch (err) {
                    // Firefox will throw an error on dispatchEvent for a detached element
                    // https://bugzilla.mozilla.org/show_bug.cgi?id=889376
                }
            }
        }

        var pageResize = function pageResize() {
            if (ta.clientWidth !== clientWidth) {
                update();
            }
        };

        var destroy = function (style) {
            window.removeEventListener('resize', pageResize, false);
            ta.removeEventListener('input', update, false);
            ta.removeEventListener('keyup', update, false);
            ta.removeEventListener('autosize:destroy', destroy, false);
            ta.removeEventListener('autosize:update', update, false);

            Object.keys(style).forEach(function (key) {
                ta.style[key] = style[key];
            });

            map.delete(ta);
        }.bind(ta, {
            height: ta.style.height,
            resize: ta.style.resize,
            overflowY: ta.style.overflowY,
            overflowX: ta.style.overflowX,
            wordWrap: ta.style.wordWrap
        });

        ta.addEventListener('autosize:destroy', destroy, false);

        // IE9 does not fire onpropertychange or oninput for deletions,
        // so binding to onkeyup to catch most of those events.
        // There is no way that I know of to detect something like 'cut' in IE9.
        if ('onpropertychange' in ta && 'oninput' in ta) {
            ta.addEventListener('keyup', update, false);
        }

        window.addEventListener('resize', pageResize, false);
        ta.addEventListener('input', update, false);
        ta.addEventListener('autosize:update', update, false);
        ta.style.overflowX = 'hidden';
        ta.style.wordWrap = 'break-word';

        map.set(ta, {
            destroy: destroy,
            update: update
        });

        init();
    }

    function destroy(ta) {
        var methods = map.get(ta);
        if (methods) {
            methods.destroy();
        }
    }

    function update(ta) {
        var methods = map.get(ta);
        if (methods) {
            methods.update();
        }
    }

    var autosize = null;

    // Do nothing in Node.js environment and IE8 (or lower)
    if (typeof window === 'undefined' || typeof window.getComputedStyle !== 'function') {
        autosize = function autosize(el) {
            return el;
        };
        autosize.destroy = function (el) {
            return el;
        };
        autosize.update = function (el) {
            return el;
        };
    } else {
        autosize = function autosize(el, options) {
            if (el) {
                Array.prototype.forEach.call(el.length ? el : [el], function (x) {
                    return assign(x, options);
                });
            }
            return el;
        };
        autosize.destroy = function (el) {
            if (el) {
                Array.prototype.forEach.call(el.length ? el : [el], destroy);
            }
            return el;
        };
        autosize.update = function (el) {
            if (el) {
                Array.prototype.forEach.call(el.length ? el : [el], update);
            }
            return el;
        };
    }

    exports.default = autosize;
    module.exports = exports['default'];
});


$(function () {
    //부드럽게 스크롩
    $('#gotop').click(function () {
        $('html,body').animate({
            scrollTop: 0
        },
            'slow');
        return false;
    });
    //scroll top
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $('#gotop').fadeIn("slow", function () {
                $(this).css({
                    "top": $(window).height() - 100 + 'px'
                });
            });
        } else {
            $('#gotop').fadeOut("slow");
        }
    });
});

/**
 * Ace code editor
 * @param {*} id 
 */
function codeViewer(id) {
    var editor = ace.edit(id);
    editor.session.setMode("ace/mode/html");
    editor.setReadOnly(true); //읽기전용
    editor.resize(true);
    editor.setOptions({
        maxLines: Infinity,
        indentedSoftWrap: false
    });
}

/*!
* JavaScript Cookie v2.0.2
* https://github.com/js-cookie/js-cookie
*
* Copyright 2006, 2015 Klaus Hartl
* Released under the MIT license
*/
!function (e) { if ("function" == typeof define && define.amd) define(e); else if ("object" == typeof exports) module.exports = e(); else { var n = window.Cookies, o = window.Cookies = e(window.jQuery); o.noConflict = function () { return window.Cookies = n, o } } }(function () { function e() { for (var e = 0, n = {}; e < arguments.length; e++) { var o = arguments[e]; for (var t in o) n[t] = o[t] } return n } function n(o) { function t(n, r, i) { var c; if (arguments.length > 1) { if (i = e({ path: "/" }, t.defaults, i), "number" == typeof i.expires) { var s = new Date; s.setMilliseconds(s.getMilliseconds() + 864e5 * i.expires), i.expires = s } try { c = JSON.stringify(r), /^[\{\[]/.test(c) && (r = c) } catch (a) { } return r = encodeURIComponent(String(r)), r = r.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent), n = encodeURIComponent(String(n)), n = n.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent), n = n.replace(/[\(\)]/g, escape), document.cookie = [n, "=", r, i.expires && "; expires=" + i.expires.toUTCString(), i.path && "; path=" + i.path, i.domain && "; domain=" + i.domain, i.secure ? "; secure" : ""].join("") } n || (c = {}); for (var p = document.cookie ? document.cookie.split("; ") : [], u = /(%[0-9A-Z]{2})+/g, d = 0; d < p.length; d++) { var f = p[d].split("="), l = f[0].replace(u, decodeURIComponent), m = f.slice(1).join("="); if ('"' === m.charAt(0) && (m = m.slice(1, -1)), m = o && o(m, l) || m.replace(u, decodeURIComponent), this.json) try { m = JSON.parse(m) } catch (a) { } if (n === l) { c = m; break } n || (c[l] = m) } return c } return t.get = t.set = t, t.getJSON = function () { return t.apply({ json: !0 }, [].slice.call(arguments)) }, t.defaults = {}, t.remove = function (n, o) { t(n, "", e(o, { expires: -1 })) }, t.withConverter = n, t } return n() });


/**
 * lazyload
 * https://github.com/verlok/lazyload
 */
!function (t, e) { "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : (t = t || self).LazyLoad = e() }(this, (function () { "use strict"; function t() { return (t = Object.assign || function (t) { for (var e = 1; e < arguments.length; e++) { var n = arguments[e]; for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (t[r] = n[r]) } return t }).apply(this, arguments) } var e = "undefined" != typeof window, n = e && !("onscroll" in window) || "undefined" != typeof navigator && /(gle|ing|ro)bot|crawl|spider/i.test(navigator.userAgent), r = e && "IntersectionObserver" in window, a = e && "classList" in document.createElement("p"), o = { elements_selector: "img", container: n || e ? document : null, threshold: 300, thresholds: null, data_src: "src", data_srcset: "srcset", data_sizes: "sizes", data_bg: "bg", data_poster: "poster", class_loading: "loading", class_loaded: "loaded", class_error: "error", load_delay: 0, auto_unobserve: !0, callback_enter: null, callback_exit: null, callback_reveal: null, callback_loaded: null, callback_error: null, callback_finish: null, use_native: !1 }, i = function (t, e) { var n, r = new t(e); try { n = new CustomEvent("LazyLoad::Initialized", { detail: { instance: r } }) } catch (t) { (n = document.createEvent("CustomEvent")).initCustomEvent("LazyLoad::Initialized", !1, !1, { instance: r }) } window.dispatchEvent(n) }, s = function (t, e) { return t.getAttribute("data-" + e) }, c = function (t, e, n) { var r = "data-" + e; null !== n ? t.setAttribute(r, n) : t.removeAttribute(r) }, l = function (t) { return "true" === s(t, "was-processed") }, u = function (t, e) { return c(t, "ll-timeout", e) }, d = function (t) { return s(t, "ll-timeout") }, f = function (t) { for (var e, n = [], r = 0; e = t.children[r]; r += 1)"SOURCE" === e.tagName && n.push(e); return n }, _ = function (t, e, n) { n && t.setAttribute(e, n) }, v = function (t, e) { _(t, "sizes", s(t, e.data_sizes)), _(t, "srcset", s(t, e.data_srcset)), _(t, "src", s(t, e.data_src)) }, g = { IMG: function (t, e) { var n = t.parentNode; n && "PICTURE" === n.tagName && f(n).forEach((function (t) { v(t, e) })); v(t, e) }, IFRAME: function (t, e) { _(t, "src", s(t, e.data_src)) }, VIDEO: function (t, e) { f(t).forEach((function (t) { _(t, "src", s(t, e.data_src)) })), _(t, "poster", s(t, e.data_poster)), _(t, "src", s(t, e.data_src)), t.load() } }, h = function (t, e) { var n, r, a = e._settings, o = t.tagName, i = g[o]; if (i) return i(t, a), e.loadingCount += 1, void (e._elements = (n = e._elements, r = t, n.filter((function (t) { return t !== r })))); !function (t, e) { var n = s(t, e.data_src), r = s(t, e.data_bg); n && (t.style.backgroundImage = 'url("'.concat(n, '")')), r && (t.style.backgroundImage = r) }(t, a) }, m = function (t, e) { a ? t.classList.add(e) : t.className += (t.className ? " " : "") + e }, b = function (t, e) { a ? t.classList.remove(e) : t.className = t.className.replace(new RegExp("(^|\\s+)" + e + "(\\s+|$)"), " ").replace(/^\s+/, "").replace(/\s+$/, "") }, p = function (t, e, n, r) { t && (void 0 === r ? void 0 === n ? t(e) : t(e, n) : t(e, n, r)) }, y = function (t, e, n) { t.addEventListener(e, n) }, E = function (t, e, n) { t.removeEventListener(e, n) }, w = function (t, e, n) { E(t, "load", e), E(t, "loadeddata", e), E(t, "error", n) }, I = function (t, e, n) { var r = n._settings, a = e ? r.class_loaded : r.class_error, o = e ? r.callback_loaded : r.callback_error, i = t.target; b(i, r.class_loading), m(i, a), p(o, i, n), n.loadingCount -= 1, 0 === n._elements.length && 0 === n.loadingCount && p(r.callback_finish, n) }, k = function (t, e) { var n = function n(a) { I(a, !0, e), w(t, n, r) }, r = function r(a) { I(a, !1, e), w(t, n, r) }; !function (t, e, n) { y(t, "load", e), y(t, "loadeddata", e), y(t, "error", n) }(t, n, r) }, A = ["IMG", "IFRAME", "VIDEO"], L = function (t, e) { var n = e._observer; z(t, e), n && e._settings.auto_unobserve && n.unobserve(t) }, z = function (t, e, n) { var r = e._settings; !n && l(t) || (A.indexOf(t.tagName) > -1 && (k(t, e), m(t, r.class_loading)), h(t, e), function (t) { c(t, "was-processed", "true") }(t), p(r.callback_reveal, t, e)) }, O = function (t) { var e = d(t); e && (clearTimeout(e), u(t, null)) }, N = function (t, e, n) { var r = n._settings; p(r.callback_enter, t, e, n), r.load_delay ? function (t, e) { var n = e._settings.load_delay, r = d(t); r || (r = setTimeout((function () { L(t, e), O(t) }), n), u(t, r)) }(t, n) : L(t, n) }, C = function (t) { return !!r && (t._observer = new IntersectionObserver((function (e) { e.forEach((function (e) { return function (t) { return t.isIntersecting || t.intersectionRatio > 0 }(e) ? N(e.target, e, t) : function (t, e, n) { var r = n._settings; p(r.callback_exit, t, e, n), r.load_delay && O(t) }(e.target, e, t) })) }), { root: (e = t._settings).container === document ? null : e.container, rootMargin: e.thresholds || e.threshold + "px" }), !0); var e }, x = ["IMG", "IFRAME"], M = function (t) { return Array.prototype.slice.call(t) }, R = function (t, e) { return function (t) { return t.filter((function (t) { return !l(t) })) }(M(t || function (t) { return t.container.querySelectorAll(t.elements_selector) }(e))) }, T = function (t) { var e = t._settings, n = e.container.querySelectorAll("." + e.class_error); M(n).forEach((function (t) { b(t, e.class_error), function (t) { c(t, "was-processed", null) }(t) })), t.update() }, j = function (n, r) { var a; this._settings = function (e) { return t({}, o, e) }(n), this.loadingCount = 0, C(this), this.update(r), a = this, e && window.addEventListener("online", (function (t) { T(a) })) }; return j.prototype = { update: function (t) { var e, r = this, a = this._settings; (this._elements = R(t, a), !n && this._observer) ? (function (t) { return t.use_native && "loading" in HTMLImageElement.prototype }(a) && ((e = this)._elements.forEach((function (t) { -1 !== x.indexOf(t.tagName) && (t.setAttribute("loading", "lazy"), z(t, e)) })), this._elements = R(t, a)), this._elements.forEach((function (t) { r._observer.observe(t) }))) : this.loadAll() }, destroy: function () { var t = this; this._observer && (this._elements.forEach((function (e) { t._observer.unobserve(e) })), this._observer = null), this._elements = null, this._settings = null }, load: function (t, e) { z(t, this, e) }, loadAll: function () { var t = this; this._elements.forEach((function (e) { L(e, t) })) } }, e && function (t, e) { if (e) if (e.length) for (var n, r = 0; n = e[r]; r += 1)i(t, n); else i(t, e) }(j, window.lazyLoadOptions), j }));
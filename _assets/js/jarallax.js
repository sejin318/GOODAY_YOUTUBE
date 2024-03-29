/*!
 * Name    : Just Another Parallax [Jarallax]
 * Version : 1.10.4
 * Author  : nK <https://nkdev.info>
 * GitHub  : https://github.com/nk-o/jarallax
 */
/******/ (function (modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if (installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
      /******/
    }
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
      /******/
    };
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
    /******/
  }
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function (exports, name, getter) {
/******/ 		if (!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
      /******/
    }
    /******/
  };
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function (exports) {
/******/ 		if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
      /******/
    }
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
    /******/
  };
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function (value, mode) {
/******/ 		if (mode & 1) value = __webpack_require__(value);
/******/ 		if (mode & 8) return value;
/******/ 		if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
    /******/
  };
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function (module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
    /******/
  };
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function (object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
  /******/
})
/************************************************************************/
/******/([
/* 0 */,
/* 1 */,
/* 2 */
/***/ (function (module, exports, __webpack_require__) {

    "use strict";


    module.exports = function (callback) {

      if (document.readyState === 'complete' || document.readyState === 'interactive') {
        // Already ready or interactive, execute callback
        callback.call();
      } else if (document.attachEvent) {
        // Old browsers
        document.attachEvent('onreadystatechange', function () {
          if (document.readyState === 'interactive') callback.call();
        });
      } else if (document.addEventListener) {
        // Modern browsers
        document.addEventListener('DOMContentLoaded', callback);
      }
    };

    /***/
  }),
  /* 3 */,
  /* 4 */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
  /* WEBPACK VAR INJECTION */(function (global) {

      var win;

      if (typeof window !== "undefined") {
        win = window;
      } else if (typeof global !== "undefined") {
        win = global;
      } else if (typeof self !== "undefined") {
        win = self;
      } else {
        win = {};
      }

      module.exports = win;
      /* WEBPACK VAR INJECTION */
    }.call(this, __webpack_require__(5)))

    /***/
  }),
  /* 5 */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";


    var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

    var g;

    // This works in non-strict mode
    g = function () {
      return this;
    }();

    try {
      // This works if eval is allowed (see CSP)
      g = g || Function("return this")() || (1, eval)("this");
    } catch (e) {
      // This works if the window reference is available
      if ((typeof window === "undefined" ? "undefined" : _typeof(window)) === "object") g = window;
    }

    // g can still be undefined, but nothing to do about it...
    // We return undefined, instead of nothing here, so it's
    // easier to handle this case. if(!global) { ...}

    module.exports = g;

    /***/
  }),
  /* 6 */,
  /* 7 */,
  /* 8 */,
  /* 9 */,
  /* 10 */,
  /* 11 */
  /***/ (function (module, exports, __webpack_require__) {

    module.exports = __webpack_require__(12);


    /***/
  }),
  /* 12 */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";


    var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

    var _liteReady = __webpack_require__(2);

    var _liteReady2 = _interopRequireDefault(_liteReady);

    var _global = __webpack_require__(4);

    var _jarallax = __webpack_require__(13);

    var _jarallax2 = _interopRequireDefault(_jarallax);

    function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

    // no conflict
    var oldPlugin = _global.window.jarallax;
    _global.window.jarallax = _jarallax2.default;
    _global.window.jarallax.noConflict = function () {
      _global.window.jarallax = oldPlugin;
      return this;
    };

    // jQuery support
    if (typeof _global.jQuery !== 'undefined') {
      var jQueryPlugin = function jQueryPlugin() {
        var args = arguments || [];
        Array.prototype.unshift.call(args, this);
        var res = _jarallax2.default.apply(_global.window, args);
        return (typeof res === 'undefined' ? 'undefined' : _typeof(res)) !== 'object' ? res : this;
      };
      jQueryPlugin.constructor = _jarallax2.default.constructor;

      // no conflict
      var oldJqPlugin = _global.jQuery.fn.jarallax;
      _global.jQuery.fn.jarallax = jQueryPlugin;
      _global.jQuery.fn.jarallax.noConflict = function () {
        _global.jQuery.fn.jarallax = oldJqPlugin;
        return this;
      };
    }

    // data-jarallax initialization
    (0, _liteReady2.default)(function () {
      (0, _jarallax2.default)(document.querySelectorAll('[data-jarallax]'));
    });

    /***/
  }),
  /* 13 */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";
  /* WEBPACK VAR INJECTION */(function (global) {

      Object.defineProperty(exports, "__esModule", {
        value: true
      });

      var _slicedToArray = function () { function sliceIterator(arr, i) { var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"]) _i["return"](); } finally { if (_d) throw _e; } } return _arr; } return function (arr, i) { if (Array.isArray(arr)) { return arr; } else if (Symbol.iterator in Object(arr)) { return sliceIterator(arr, i); } else { throw new TypeError("Invalid attempt to destructure non-iterable instance"); } }; }();

      var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

      var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

      var _liteReady = __webpack_require__(2);

      var _liteReady2 = _interopRequireDefault(_liteReady);

      var _rafl = __webpack_require__(14);

      var _rafl2 = _interopRequireDefault(_rafl);

      var _global = __webpack_require__(4);

      function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

      function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

      var isIE = navigator.userAgent.indexOf('MSIE ') > -1 || navigator.userAgent.indexOf('Trident/') > -1 || navigator.userAgent.indexOf('Edge/') > -1;

      var supportTransform = function () {
        var prefixes = 'transform WebkitTransform MozTransform'.split(' ');
        var div = document.createElement('div');
        for (var i = 0; i < prefixes.length; i++) {
          if (div && div.style[prefixes[i]] !== undefined) {
            return prefixes[i];
          }
        }
        return false;
      }();

      // Window data
      var wndW = void 0;
      var wndH = void 0;
      var wndY = void 0;
      var forceResizeParallax = false;
      var forceScrollParallax = false;
      function updateWndVars(e) {
        wndW = _global.window.innerWidth || document.documentElement.clientWidth;
        wndH = _global.window.innerHeight || document.documentElement.clientHeight;
        if ((typeof e === 'undefined' ? 'undefined' : _typeof(e)) === 'object' && (e.type === 'load' || e.type === 'dom-loaded')) {
          forceResizeParallax = true;
        }
      }
      updateWndVars();
      _global.window.addEventListener('resize', updateWndVars);
      _global.window.addEventListener('orientationchange', updateWndVars);
      _global.window.addEventListener('load', updateWndVars);
      (0, _liteReady2.default)(function () {
        updateWndVars({
          type: 'dom-loaded'
        });
      });

      // list with all jarallax instances
      // need to render all in one scroll/resize event
      var jarallaxList = [];

      // Animate if changed window size or scrolled page
      var oldPageData = false;
      function updateParallax() {
        if (!jarallaxList.length) {
          return;
        }

        if (_global.window.pageYOffset !== undefined) {
          wndY = _global.window.pageYOffset;
        } else {
          wndY = (document.documentElement || document.body.parentNode || document.body).scrollTop;
        }

        var isResized = forceResizeParallax || !oldPageData || oldPageData.width !== wndW || oldPageData.height !== wndH;
        var isScrolled = forceScrollParallax || isResized || !oldPageData || oldPageData.y !== wndY;

        forceResizeParallax = false;
        forceScrollParallax = false;

        if (isResized || isScrolled) {
          jarallaxList.forEach(function (item) {
            if (isResized) {
              item.onResize();
            }
            if (isScrolled) {
              item.onScroll();
            }
          });

          oldPageData = {
            width: wndW,
            height: wndH,
            y: wndY
          };
        }

        (0, _rafl2.default)(updateParallax);
      }

      // ResizeObserver
      var resizeObserver = global.ResizeObserver ? new global.ResizeObserver(function (entry) {
        if (entry && entry.length) {
          (0, _rafl2.default)(function () {
            entry.forEach(function (item) {
              if (item.target && item.target.jarallax) {
                if (!forceResizeParallax) {
                  item.target.jarallax.onResize();
                }
                forceScrollParallax = true;
              }
            });
          });
        }
      }) : false;

      var instanceID = 0;

      // Jarallax class

      var Jarallax = function () {
        function Jarallax(item, userOptions) {
          _classCallCheck(this, Jarallax);

          var self = this;

          self.instanceID = instanceID++;

          self.$item = item;

          self.defaults = {
            type: 'scroll', // type of parallax: scroll, scale, opacity, scale-opacity, scroll-opacity
            speed: 0.5, // supported value from -1 to 2
            imgSrc: null,
            imgElement: '.jarallax-img',
            imgSize: 'cover',
            imgPosition: '50% 50%',
            imgRepeat: 'no-repeat', // supported only for background, not for <img> tag
            keepImg: false, // keep <img> tag in it's default place
            elementInViewport: null,
            zIndex: -100,
            disableParallax: false,
            disableVideo: false,
            automaticResize: true, // use ResizeObserver to recalculate position and size of parallax image

            // video
            videoSrc: null,
            videoStartTime: 0,
            videoEndTime: 0,
            videoVolume: 0,
            videoPlayOnlyVisible: true,

            // events
            onScroll: null, // function(calculations) {}
            onInit: null, // function() {}
            onDestroy: null, // function() {}
            onCoverImage: null // function() {}
          };

          // DEPRECATED: old data-options
          var deprecatedDataAttribute = self.$item.getAttribute('data-jarallax');
          var oldDataOptions = JSON.parse(deprecatedDataAttribute || '{}');
          if (deprecatedDataAttribute) {
            // eslint-disable-next-line no-console
            console.warn('Detected usage of deprecated data-jarallax JSON options, you should use pure data-attribute options. See info here - https://github.com/nk-o/jarallax/issues/53');
          }

          // prepare data-options
          var dataOptions = self.$item.dataset || {};
          var pureDataOptions = {};
          Object.keys(dataOptions).forEach(function (key) {
            var loweCaseOption = key.substr(0, 1).toLowerCase() + key.substr(1);
            if (loweCaseOption && typeof self.defaults[loweCaseOption] !== 'undefined') {
              pureDataOptions[loweCaseOption] = dataOptions[key];
            }
          });

          self.options = self.extend({}, self.defaults, oldDataOptions, pureDataOptions, userOptions);
          self.pureOptions = self.extend({}, self.options);

          // prepare 'true' and 'false' strings to boolean
          Object.keys(self.options).forEach(function (key) {
            if (self.options[key] === 'true') {
              self.options[key] = true;
            } else if (self.options[key] === 'false') {
              self.options[key] = false;
            }
          });

          // fix speed option [-1.0, 2.0]
          self.options.speed = Math.min(2, Math.max(-1, parseFloat(self.options.speed)));

          // deprecated noAndroid and noIos options
          if (self.options.noAndroid || self.options.noIos) {
            // eslint-disable-next-line no-console
            console.warn('Detected usage of deprecated noAndroid or noIos options, you should use disableParallax option. See info here - https://github.com/nk-o/jarallax/#disable-on-mobile-devices');

            // prepare fallback if disableParallax option is not used
            if (!self.options.disableParallax) {
              if (self.options.noIos && self.options.noAndroid) {
                self.options.disableParallax = /iPad|iPhone|iPod|Android/;
              } else if (self.options.noIos) {
                self.options.disableParallax = /iPad|iPhone|iPod/;
              } else if (self.options.noAndroid) {
                self.options.disableParallax = /Android/;
              }
            }
          }

          // prepare disableParallax callback
          if (typeof self.options.disableParallax === 'string') {
            self.options.disableParallax = new RegExp(self.options.disableParallax);
          }
          if (self.options.disableParallax instanceof RegExp) {
            var disableParallaxRegexp = self.options.disableParallax;
            self.options.disableParallax = function () {
              return disableParallaxRegexp.test(navigator.userAgent);
            };
          }
          if (typeof self.options.disableParallax !== 'function') {
            self.options.disableParallax = function () {
              return false;
            };
          }

          // prepare disableVideo callback
          if (typeof self.options.disableVideo === 'string') {
            self.options.disableVideo = new RegExp(self.options.disableVideo);
          }
          if (self.options.disableVideo instanceof RegExp) {
            var disableVideoRegexp = self.options.disableVideo;
            self.options.disableVideo = function () {
              return disableVideoRegexp.test(navigator.userAgent);
            };
          }
          if (typeof self.options.disableVideo !== 'function') {
            self.options.disableVideo = function () {
              return false;
            };
          }

          // custom element to check if parallax in viewport
          var elementInVP = self.options.elementInViewport;
          // get first item from array
          if (elementInVP && (typeof elementInVP === 'undefined' ? 'undefined' : _typeof(elementInVP)) === 'object' && typeof elementInVP.length !== 'undefined') {
            var _elementInVP = elementInVP;

            var _elementInVP2 = _slicedToArray(_elementInVP, 1);

            elementInVP = _elementInVP2[0];
          }
          // check if dom element
          if (!(elementInVP instanceof Element)) {
            elementInVP = null;
          }
          self.options.elementInViewport = elementInVP;

          self.image = {
            src: self.options.imgSrc || null,
            $container: null,
            useImgTag: false,

            // position fixed is needed for the most of browsers because absolute position have glitches
            // on MacOS with smooth scroll there is a huge lags with absolute position - https://github.com/nk-o/jarallax/issues/75
            // on mobile devices better scrolled with absolute position
            position: /iPad|iPhone|iPod|Android/.test(navigator.userAgent) ? 'absolute' : 'fixed'
          };

          if (self.initImg() && self.canInitParallax()) {
            self.init();
          }
        }

        // add styles to element


        _createClass(Jarallax, [{
          key: 'css',
          value: function css(el, styles) {
            if (typeof styles === 'string') {
              return _global.window.getComputedStyle(el).getPropertyValue(styles);
            }

            // add transform property with vendor prefix
            if (styles.transform && supportTransform) {
              styles[supportTransform] = styles.transform;
            }

            Object.keys(styles).forEach(function (key) {
              el.style[key] = styles[key];
            });
            return el;
          }

          // Extend like jQuery.extend

        }, {
          key: 'extend',
          value: function extend(out) {
            var _arguments = arguments;

            out = out || {};
            Object.keys(arguments).forEach(function (i) {
              if (!_arguments[i]) {
                return;
              }
              Object.keys(_arguments[i]).forEach(function (key) {
                out[key] = _arguments[i][key];
              });
            });
            return out;
          }

          // get window size and scroll position. Useful for extensions

        }, {
          key: 'getWindowData',
          value: function getWindowData() {
            return {
              width: wndW,
              height: wndH,
              y: wndY
            };
          }

          // Jarallax functions

        }, {
          key: 'initImg',
          value: function initImg() {
            var self = this;

            // find image element
            var $imgElement = self.options.imgElement;
            if ($imgElement && typeof $imgElement === 'string') {
              $imgElement = self.$item.querySelector($imgElement);
            }
            // check if dom element
            if (!($imgElement instanceof Element)) {
              $imgElement = null;
            }

            if ($imgElement) {
              if (self.options.keepImg) {
                self.image.$item = $imgElement.cloneNode(true);
              } else {
                self.image.$item = $imgElement;
                self.image.$itemParent = $imgElement.parentNode;
              }
              self.image.useImgTag = true;
            }

            // true if there is img tag
            if (self.image.$item) {
              return true;
            }

            // get image src
            if (self.image.src === null) {
              self.image.src = self.css(self.$item, 'background-image').replace(/^url\(['"]?/g, '').replace(/['"]?\)$/g, '');
            }
            return !(!self.image.src || self.image.src === 'none');
          }
        }, {
          key: 'canInitParallax',
          value: function canInitParallax() {
            return supportTransform && !this.options.disableParallax();
          }
        }, {
          key: 'init',
          value: function init() {
            var self = this;
            var containerStyles = {
              position: 'absolute',
              top: 0,
              left: 0,
              width: '100%',
              height: '100%',
              overflow: 'hidden',
              pointerEvents: 'none'
            };
            var imageStyles = {};

            if (!self.options.keepImg) {
              // save default user styles
              var curStyle = self.$item.getAttribute('style');
              if (curStyle) {
                self.$item.setAttribute('data-jarallax-original-styles', curStyle);
              }
              if (self.image.useImgTag) {
                var curImgStyle = self.image.$item.getAttribute('style');
                if (curImgStyle) {
                  self.image.$item.setAttribute('data-jarallax-original-styles', curImgStyle);
                }
              }
            }

            // set relative position and z-index to the parent
            if (self.css(self.$item, 'position') === 'static') {
              self.css(self.$item, {
                position: 'relative'
              });
            }
            if (self.css(self.$item, 'z-index') === 'auto') {
              self.css(self.$item, {
                zIndex: 0
              });
            }

            // container for parallax image
            self.image.$container = document.createElement('div');
            self.css(self.image.$container, containerStyles);
            self.css(self.image.$container, {
              'z-index': self.options.zIndex
            });

            // fix for IE https://github.com/nk-o/jarallax/issues/110
            if (isIE) {
              self.css(self.image.$container, {
                opacity: 0.9999
              });
            }

            self.image.$container.setAttribute('id', 'jarallax-container-' + self.instanceID);
            self.$item.appendChild(self.image.$container);

            // use img tag
            if (self.image.useImgTag) {
              imageStyles = self.extend({
                'object-fit': self.options.imgSize,
                'object-position': self.options.imgPosition,
                // support for plugin https://github.com/bfred-it/object-fit-images
                'font-family': 'object-fit: ' + self.options.imgSize + '; object-position: ' + self.options.imgPosition + ';',
                'max-width': 'none'
              }, containerStyles, imageStyles);

              // use div with background image
            } else {
              self.image.$item = document.createElement('div');
              if (self.image.src) {
                imageStyles = self.extend({
                  'background-position': self.options.imgPosition,
                  'background-size': self.options.imgSize,
                  'background-repeat': self.options.imgRepeat,
                  'background-image': 'url("' + self.image.src + '")'
                }, containerStyles, imageStyles);
              }
            }

            if (self.options.type === 'opacity' || self.options.type === 'scale' || self.options.type === 'scale-opacity' || self.options.speed === 1) {
              self.image.position = 'absolute';
            }

            // check if one of parents have transform style (without this check, scroll transform will be inverted if used parallax with position fixed)
            // discussion - https://github.com/nk-o/jarallax/issues/9
            if (self.image.position === 'fixed') {
              var parentWithTransform = 0;
              var $itemParents = self.$item;
              while ($itemParents !== null && $itemParents !== document && parentWithTransform === 0) {
                var parentTransform = self.css($itemParents, '-webkit-transform') || self.css($itemParents, '-moz-transform') || self.css($itemParents, 'transform');
                if (parentTransform && parentTransform !== 'none') {
                  parentWithTransform = 1;
                  self.image.position = 'absolute';
                }
                $itemParents = $itemParents.parentNode;
              }
            }

            // add position to parallax block
            imageStyles.position = self.image.position;

            // insert parallax image
            self.css(self.image.$item, imageStyles);
            self.image.$container.appendChild(self.image.$item);

            // set initial position and size
            self.onResize();
            self.onScroll(true);

            // ResizeObserver
            if (self.options.automaticResize && resizeObserver) {
              resizeObserver.observe(self.$item);
            }

            // call onInit event
            if (self.options.onInit) {
              self.options.onInit.call(self);
            }

            // remove default user background
            if (self.css(self.$item, 'background-image') !== 'none') {
              self.css(self.$item, {
                'background-image': 'none'
              });
            }

            self.addToParallaxList();
          }

          // add to parallax instances list

        }, {
          key: 'addToParallaxList',
          value: function addToParallaxList() {
            jarallaxList.push(this);

            if (jarallaxList.length === 1) {
              updateParallax();
            }
          }

          // remove from parallax instances list

        }, {
          key: 'removeFromParallaxList',
          value: function removeFromParallaxList() {
            var self = this;

            jarallaxList.forEach(function (item, key) {
              if (item.instanceID === self.instanceID) {
                jarallaxList.splice(key, 1);
              }
            });
          }
        }, {
          key: 'destroy',
          value: function destroy() {
            var self = this;

            self.removeFromParallaxList();

            // return styles on container as before jarallax init
            var originalStylesTag = self.$item.getAttribute('data-jarallax-original-styles');
            self.$item.removeAttribute('data-jarallax-original-styles');
            // null occurs if there is no style tag before jarallax init
            if (!originalStylesTag) {
              self.$item.removeAttribute('style');
            } else {
              self.$item.setAttribute('style', originalStylesTag);
            }

            if (self.image.useImgTag) {
              // return styles on img tag as before jarallax init
              var originalStylesImgTag = self.image.$item.getAttribute('data-jarallax-original-styles');
              self.image.$item.removeAttribute('data-jarallax-original-styles');
              // null occurs if there is no style tag before jarallax init
              if (!originalStylesImgTag) {
                self.image.$item.removeAttribute('style');
              } else {
                self.image.$item.setAttribute('style', originalStylesTag);
              }

              // move img tag to its default position
              if (self.image.$itemParent) {
                self.image.$itemParent.appendChild(self.image.$item);
              }
            }

            // remove additional dom elements
            if (self.$clipStyles) {
              self.$clipStyles.parentNode.removeChild(self.$clipStyles);
            }
            if (self.image.$container) {
              self.image.$container.parentNode.removeChild(self.image.$container);
            }

            // call onDestroy event
            if (self.options.onDestroy) {
              self.options.onDestroy.call(self);
            }

            // delete jarallax from item
            delete self.$item.jarallax;
          }

          // it will remove some image overlapping
          // overlapping occur due to an image position fixed inside absolute position element

        }, {
          key: 'clipContainer',
          value: function clipContainer() {
            // needed only when background in fixed position
            if (this.image.position !== 'fixed') {
              return;
            }

            var self = this;
            var rect = self.image.$container.getBoundingClientRect();
            var width = rect.width,
              height = rect.height;


            if (!self.$clipStyles) {
              self.$clipStyles = document.createElement('style');
              self.$clipStyles.setAttribute('type', 'text/css');
              self.$clipStyles.setAttribute('id', 'jarallax-clip-' + self.instanceID);
              var head = document.head || document.getElementsByTagName('head')[0];
              head.appendChild(self.$clipStyles);
            }

            var styles = '#jarallax-container-' + self.instanceID + ' {\n           clip: rect(0 ' + width + 'px ' + height + 'px 0);\n           clip: rect(0, ' + width + 'px, ' + height + 'px, 0);\n        }';

            // add clip styles inline (this method need for support IE8 and less browsers)
            if (self.$clipStyles.styleSheet) {
              self.$clipStyles.styleSheet.cssText = styles;
            } else {
              self.$clipStyles.innerHTML = styles;
            }
          }
        }, {
          key: 'coverImage',
          value: function coverImage() {
            var self = this;

            var rect = self.image.$container.getBoundingClientRect();
            var contH = rect.height;
            var speed = self.options.speed;

            var isScroll = self.options.type === 'scroll' || self.options.type === 'scroll-opacity';
            var scrollDist = 0;
            var resultH = contH;
            var resultMT = 0;

            // scroll parallax
            if (isScroll) {
              // scroll distance and height for image
              if (speed < 0) {
                scrollDist = speed * Math.max(contH, wndH);
              } else {
                scrollDist = speed * (contH + wndH);
              }

              // size for scroll parallax
              if (speed > 1) {
                resultH = Math.abs(scrollDist - wndH);
              } else if (speed < 0) {
                resultH = scrollDist / speed + Math.abs(scrollDist);
              } else {
                resultH += Math.abs(wndH - contH) * (1 - speed);
              }

              scrollDist /= 2;
            }

            // store scroll distance
            self.parallaxScrollDistance = scrollDist;

            // vertical center
            if (isScroll) {
              resultMT = (wndH - resultH) / 2;
            } else {
              resultMT = (contH - resultH) / 2;
            }

            // apply result to item
            self.css(self.image.$item, {
              height: resultH + 'px',
              marginTop: resultMT + 'px',
              left: self.image.position === 'fixed' ? rect.left + 'px' : '0',
              width: rect.width + 'px'
            });

            // call onCoverImage event
            if (self.options.onCoverImage) {
              self.options.onCoverImage.call(self);
            }

            // return some useful data. Used in the video cover function
            return {
              image: {
                height: resultH,
                marginTop: resultMT
              },
              container: rect
            };
          }
        }, {
          key: 'isVisible',
          value: function isVisible() {
            return this.isElementInViewport || false;
          }
        }, {
          key: 'onScroll',
          value: function onScroll(force) {
            var self = this;

            var rect = self.$item.getBoundingClientRect();
            var contT = rect.top;
            var contH = rect.height;
            var styles = {};

            // check if in viewport
            var viewportRect = rect;
            if (self.options.elementInViewport) {
              viewportRect = self.options.elementInViewport.getBoundingClientRect();
            }
            self.isElementInViewport = viewportRect.bottom >= 0 && viewportRect.right >= 0 && viewportRect.top <= wndH && viewportRect.left <= wndW;

            // stop calculations if item is not in viewport
            if (force ? false : !self.isElementInViewport) {
              return;
            }

            // calculate parallax helping variables
            var beforeTop = Math.max(0, contT);
            var beforeTopEnd = Math.max(0, contH + contT);
            var afterTop = Math.max(0, -contT);
            var beforeBottom = Math.max(0, contT + contH - wndH);
            var beforeBottomEnd = Math.max(0, contH - (contT + contH - wndH));
            var afterBottom = Math.max(0, -contT + wndH - contH);
            var fromViewportCenter = 1 - 2 * (wndH - contT) / (wndH + contH);

            // calculate on how percent of section is visible
            var visiblePercent = 1;
            if (contH < wndH) {
              visiblePercent = 1 - (afterTop || beforeBottom) / contH;
            } else if (beforeTopEnd <= wndH) {
              visiblePercent = beforeTopEnd / wndH;
            } else if (beforeBottomEnd <= wndH) {
              visiblePercent = beforeBottomEnd / wndH;
            }

            // opacity
            if (self.options.type === 'opacity' || self.options.type === 'scale-opacity' || self.options.type === 'scroll-opacity') {
              styles.transform = 'translate3d(0,0,0)';
              styles.opacity = visiblePercent;
            }

            // scale
            if (self.options.type === 'scale' || self.options.type === 'scale-opacity') {
              var scale = 1;
              if (self.options.speed < 0) {
                scale -= self.options.speed * visiblePercent;
              } else {
                scale += self.options.speed * (1 - visiblePercent);
              }
              styles.transform = 'scale(' + scale + ') translate3d(0,0,0)';
            }

            // scroll
            if (self.options.type === 'scroll' || self.options.type === 'scroll-opacity') {
              var positionY = self.parallaxScrollDistance * fromViewportCenter;

              // fix if parallax block in absolute position
              if (self.image.position === 'absolute') {
                positionY -= contT;
              }

              styles.transform = 'translate3d(0,' + positionY + 'px,0)';
            }

            self.css(self.image.$item, styles);

            // call onScroll event
            if (self.options.onScroll) {
              self.options.onScroll.call(self, {
                section: rect,

                beforeTop: beforeTop,
                beforeTopEnd: beforeTopEnd,
                afterTop: afterTop,
                beforeBottom: beforeBottom,
                beforeBottomEnd: beforeBottomEnd,
                afterBottom: afterBottom,

                visiblePercent: visiblePercent,
                fromViewportCenter: fromViewportCenter
              });
            }
          }
        }, {
          key: 'onResize',
          value: function onResize() {
            this.coverImage();
            this.clipContainer();
          }
        }]);

        return Jarallax;
      }();

      // global definition


      var plugin = function plugin(items) {
        // check for dom element
        // thanks: http://stackoverflow.com/questions/384286/javascript-isdom-how-do-you-check-if-a-javascript-object-is-a-dom-object
        if ((typeof HTMLElement === 'undefined' ? 'undefined' : _typeof(HTMLElement)) === 'object' ? items instanceof HTMLElement : items && (typeof items === 'undefined' ? 'undefined' : _typeof(items)) === 'object' && items !== null && items.nodeType === 1 && typeof items.nodeName === 'string') {
          items = [items];
        }

        var options = arguments[1];
        var args = Array.prototype.slice.call(arguments, 2);
        var len = items.length;
        var k = 0;
        var ret = void 0;

        for (k; k < len; k++) {
          if ((typeof options === 'undefined' ? 'undefined' : _typeof(options)) === 'object' || typeof options === 'undefined') {
            if (!items[k].jarallax) {
              items[k].jarallax = new Jarallax(items[k], options);
            }
          } else if (items[k].jarallax) {
            // eslint-disable-next-line prefer-spread
            ret = items[k].jarallax[options].apply(items[k].jarallax, args);
          }
          if (typeof ret !== 'undefined') {
            return ret;
          }
        }

        return items;
      };
      plugin.constructor = Jarallax;

      exports.default = plugin;
      /* WEBPACK VAR INJECTION */
    }.call(this, __webpack_require__(5)))

    /***/
  }),
  /* 14 */
  /***/ (function (module, exports, __webpack_require__) {

    "use strict";


    var global = __webpack_require__(4);

    /**
     * `requestAnimationFrame()`
     */

    var request = global.requestAnimationFrame || global.webkitRequestAnimationFrame || global.mozRequestAnimationFrame || fallback;

    var prev = +new Date();
    function fallback(fn) {
      var curr = +new Date();
      var ms = Math.max(0, 16 - (curr - prev));
      var req = setTimeout(fn, ms);
      return prev = curr, req;
    }

    /**
     * `cancelAnimationFrame()`
     */

    var cancel = global.cancelAnimationFrame || global.webkitCancelAnimationFrame || global.mozCancelAnimationFrame || clearTimeout;

    if (Function.prototype.bind) {
      request = request.bind(global);
      cancel = cancel.bind(global);
    }

    exports = module.exports = request;
    exports.cancel = cancel;

    /***/
  })
  /******/]);


  /*!
 * Name    : Video Background Extension for Jarallax
 * Version : 1.0.1
 * Author  : nK <https://nkdev.info>
 * GitHub  : https://github.com/nk-o/jarallax
 */
/******/ (function (modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if (installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
      /******/
}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
      /******/
};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
    /******/
}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function (exports, name, getter) {
/******/ 		if (!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
      /******/
}
    /******/
};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function (exports) {
/******/ 		if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
      /******/
}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
    /******/
};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function (value, mode) {
/******/ 		if (mode & 1) value = __webpack_require__(value);
/******/ 		if (mode & 8) return value;
/******/ 		if ((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if (mode & 2 && typeof value != 'string') for (var key in value) __webpack_require__.d(ns, key, function (key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
    /******/
};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function (module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
    /******/
};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function (object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
  /******/
})
/************************************************************************/
/******/([
/* 0 */,
/* 1 */,
/* 2 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";


      module.exports = function (callback) {

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
          // Already ready or interactive, execute callback
          callback.call();
        } else if (document.attachEvent) {
          // Old browsers
          document.attachEvent('onreadystatechange', function () {
            if (document.readyState === 'interactive') callback.call();
          });
        } else if (document.addEventListener) {
          // Modern browsers
          document.addEventListener('DOMContentLoaded', callback);
        }
      };

      /***/
}),
/* 3 */,
/* 4 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";
/* WEBPACK VAR INJECTION */(function (global) {

        var win;

        if (typeof window !== "undefined") {
          win = window;
        } else if (typeof global !== "undefined") {
          win = global;
        } else if (typeof self !== "undefined") {
          win = self;
        } else {
          win = {};
        }

        module.exports = win;
        /* WEBPACK VAR INJECTION */
}.call(this, __webpack_require__(5)))

      /***/
}),
/* 5 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";


      var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

      var g;

      // This works in non-strict mode
      g = function () {
        return this;
      }();

      try {
        // This works if eval is allowed (see CSP)
        g = g || Function("return this")() || (1, eval)("this");
      } catch (e) {
        // This works if the window reference is available
        if ((typeof window === "undefined" ? "undefined" : _typeof(window)) === "object") g = window;
      }

      // g can still be undefined, but nothing to do about it...
      // We return undefined, instead of nothing here, so it's
      // easier to handle this case. if(!global) { ...}

      module.exports = g;

      /***/
}),
/* 6 */
/***/ (function (module, exports, __webpack_require__) {

      module.exports = __webpack_require__(7);


      /***/
}),
/* 7 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";


      var _videoWorker = __webpack_require__(8);

      var _videoWorker2 = _interopRequireDefault(_videoWorker);

      var _global = __webpack_require__(4);

      var _global2 = _interopRequireDefault(_global);

      var _liteReady = __webpack_require__(2);

      var _liteReady2 = _interopRequireDefault(_liteReady);

      var _jarallaxVideo = __webpack_require__(10);

      var _jarallaxVideo2 = _interopRequireDefault(_jarallaxVideo);

      function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

      // add video worker globally to fallback jarallax < 1.10 versions
      _global2.default.VideoWorker = _global2.default.VideoWorker || _videoWorker2.default;

      (0, _jarallaxVideo2.default)();

      // data-jarallax-video initialization
      (0, _liteReady2.default)(function () {
        if (typeof jarallax !== 'undefined') {
          jarallax(document.querySelectorAll('[data-jarallax-video]'));
        }
      });

      /***/
}),
/* 8 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";


      module.exports = __webpack_require__(9);

      /***/
}),
/* 9 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";


      Object.defineProperty(exports, "__esModule", {
        value: true
      });

      var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

      var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

      function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

      // Deferred
      // thanks http://stackoverflow.com/questions/18096715/implement-deferred-object-without-using-jquery
      function Deferred() {
        this._done = [];
        this._fail = [];
      }
      Deferred.prototype = {
        execute: function execute(list, args) {
          var i = list.length;
          args = Array.prototype.slice.call(args);
          while (i--) {
            list[i].apply(null, args);
          }
        },
        resolve: function resolve() {
          this.execute(this._done, arguments);
        },
        reject: function reject() {
          this.execute(this._fail, arguments);
        },
        done: function done(callback) {
          this._done.push(callback);
        },
        fail: function fail(callback) {
          this._fail.push(callback);
        }
      };

      var ID = 0;
      var YoutubeAPIadded = 0;
      var VimeoAPIadded = 0;
      var loadingYoutubePlayer = 0;
      var loadingVimeoPlayer = 0;
      var loadingYoutubeDefer = new Deferred();
      var loadingVimeoDefer = new Deferred();

      var VideoWorker = function () {
        function VideoWorker(url, options) {
          _classCallCheck(this, VideoWorker);

          var self = this;

          self.url = url;

          self.options_default = {
            autoplay: false,
            loop: false,
            mute: false,
            volume: 100,
            showContols: true,

            // start / end video time in seconds
            startTime: 0,
            endTime: 0
          };

          self.options = self.extend({}, self.options_default, options);

          // check URL
          self.videoID = self.parseURL(url);

          // init
          if (self.videoID) {
            self.ID = ID++;
            self.loadAPI();
            self.init();
          }
        }

        // Extend like jQuery.extend


        _createClass(VideoWorker, [{
          key: 'extend',
          value: function extend(out) {
            var _arguments = arguments;

            out = out || {};
            Object.keys(arguments).forEach(function (i) {
              if (!_arguments[i]) {
                return;
              }
              Object.keys(_arguments[i]).forEach(function (key) {
                out[key] = _arguments[i][key];
              });
            });
            return out;
          }
        }, {
          key: 'parseURL',
          value: function parseURL(url) {
            // parse youtube ID
            function getYoutubeID(ytUrl) {
              // eslint-disable-next-line no-useless-escape
              var regExp = /.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
              var match = ytUrl.match(regExp);
              return match && match[1].length === 11 ? match[1] : false;
            }

            // parse vimeo ID
            function getVimeoID(vmUrl) {
              // eslint-disable-next-line no-useless-escape
              var regExp = /https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/;
              var match = vmUrl.match(regExp);
              return match && match[3] ? match[3] : false;
            }

            // parse local string
            function getLocalVideos(locUrl) {
              // eslint-disable-next-line no-useless-escape
              var videoFormats = locUrl.split(/,(?=mp4\:|webm\:|ogv\:|ogg\:)/);
              var result = {};
              var ready = 0;
              videoFormats.forEach(function (val) {
                // eslint-disable-next-line no-useless-escape
                var match = val.match(/^(mp4|webm|ogv|ogg)\:(.*)/);
                if (match && match[1] && match[2]) {
                  // eslint-disable-next-line prefer-destructuring
                  result[match[1] === 'ogv' ? 'ogg' : match[1]] = match[2];
                  ready = 1;
                }
              });
              return ready ? result : false;
            }

            var Youtube = getYoutubeID(url);
            var Vimeo = getVimeoID(url);
            var Local = getLocalVideos(url);

            if (Youtube) {
              this.type = 'youtube';
              return Youtube;
            } else if (Vimeo) {
              this.type = 'vimeo';
              return Vimeo;
            } else if (Local) {
              this.type = 'local';
              return Local;
            }

            return false;
          }
        }, {
          key: 'isValid',
          value: function isValid() {
            return !!this.videoID;
          }

          // events

        }, {
          key: 'on',
          value: function on(name, callback) {
            this.userEventsList = this.userEventsList || [];

            // add new callback in events list
            (this.userEventsList[name] || (this.userEventsList[name] = [])).push(callback);
          }
        }, {
          key: 'off',
          value: function off(name, callback) {
            var _this = this;

            if (!this.userEventsList || !this.userEventsList[name]) {
              return;
            }

            if (!callback) {
              delete this.userEventsList[name];
            } else {
              this.userEventsList[name].forEach(function (val, key) {
                if (val === callback) {
                  _this.userEventsList[name][key] = false;
                }
              });
            }
          }
        }, {
          key: 'fire',
          value: function fire(name) {
            var _this2 = this;

            var args = [].slice.call(arguments, 1);
            if (this.userEventsList && typeof this.userEventsList[name] !== 'undefined') {
              this.userEventsList[name].forEach(function (val) {
                // call with all arguments
                if (val) {
                  val.apply(_this2, args);
                }
              });
            }
          }
        }, {
          key: 'play',
          value: function play(start) {
            var self = this;
            if (!self.player) {
              return;
            }

            if (self.type === 'youtube' && self.player.playVideo) {
              if (typeof start !== 'undefined') {
                self.player.seekTo(start || 0);
              }
              if (YT.PlayerState.PLAYING !== self.player.getPlayerState()) {
                self.player.playVideo();
              }
            }

            if (self.type === 'vimeo') {
              if (typeof start !== 'undefined') {
                self.player.setCurrentTime(start);
              }
              self.player.getPaused().then(function (paused) {
                if (paused) {
                  self.player.play();
                }
              });
            }

            if (self.type === 'local') {
              if (typeof start !== 'undefined') {
                self.player.currentTime = start;
              }
              if (self.player.paused) {
                self.player.play();
              }
            }
          }
        }, {
          key: 'pause',
          value: function pause() {
            var self = this;
            if (!self.player) {
              return;
            }

            if (self.type === 'youtube' && self.player.pauseVideo) {
              if (YT.PlayerState.PLAYING === self.player.getPlayerState()) {
                self.player.pauseVideo();
              }
            }

            if (self.type === 'vimeo') {
              self.player.getPaused().then(function (paused) {
                if (!paused) {
                  self.player.pause();
                }
              });
            }

            if (self.type === 'local') {
              if (!self.player.paused) {
                self.player.pause();
              }
            }
          }
        }, {
          key: 'mute',
          value: function mute() {
            var self = this;
            if (!self.player) {
              return;
            }

            if (self.type === 'youtube' && self.player.mute) {
              self.player.mute();
            }

            if (self.type === 'vimeo' && self.player.setVolume) {
              self.player.setVolume(0);
            }

            if (self.type === 'local') {
              self.$video.muted = true;
            }
          }
        }, {
          key: 'unmute',
          value: function unmute() {
            var self = this;
            if (!self.player) {
              return;
            }

            if (self.type === 'youtube' && self.player.mute) {
              self.player.unMute();
            }

            if (self.type === 'vimeo' && self.player.setVolume) {
              self.player.setVolume(self.options.volume);
            }

            if (self.type === 'local') {
              self.$video.muted = false;
            }
          }
        }, {
          key: 'setVolume',
          value: function setVolume() {
            var volume = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

            var self = this;
            if (!self.player || !volume) {
              return;
            }

            if (self.type === 'youtube' && self.player.setVolume) {
              self.player.setVolume(volume);
            }

            if (self.type === 'vimeo' && self.player.setVolume) {
              self.player.setVolume(volume);
            }

            if (self.type === 'local') {
              self.$video.volume = volume / 100;
            }
          }
        }, {
          key: 'getVolume',
          value: function getVolume(callback) {
            var self = this;
            if (!self.player) {
              callback(false);
              return;
            }

            if (self.type === 'youtube' && self.player.getVolume) {
              callback(self.player.getVolume());
            }

            if (self.type === 'vimeo' && self.player.getVolume) {
              self.player.getVolume().then(function (volume) {
                callback(volume);
              });
            }

            if (self.type === 'local') {
              callback(self.$video.volume * 100);
            }
          }
        }, {
          key: 'getMuted',
          value: function getMuted(callback) {
            var self = this;
            if (!self.player) {
              callback(null);
              return;
            }

            if (self.type === 'youtube' && self.player.isMuted) {
              callback(self.player.isMuted());
            }

            if (self.type === 'vimeo' && self.player.getVolume) {
              self.player.getVolume().then(function (volume) {
                callback(!!volume);
              });
            }

            if (self.type === 'local') {
              callback(self.$video.muted);
            }
          }
        }, {
          key: 'getImageURL',
          value: function getImageURL(callback) {
            var self = this;

            if (self.videoImage) {
              callback(self.videoImage);
              return;
            }

            if (self.type === 'youtube') {
              var availableSizes = ['maxresdefault', 'sddefault', 'hqdefault', '0'];
              var step = 0;

              var tempImg = new Image();
              tempImg.onload = function () {
                // if no thumbnail, youtube add their own image with width = 120px
                if ((this.naturalWidth || this.width) !== 120 || step === availableSizes.length - 1) {
                  // ok
                  self.videoImage = 'https://img.youtube.com/vi/' + self.videoID + '/' + availableSizes[step] + '.jpg';
                  callback(self.videoImage);
                } else {
                  // try another size
                  step++;
                  this.src = 'https://img.youtube.com/vi/' + self.videoID + '/' + availableSizes[step] + '.jpg';
                }
              };
              tempImg.src = 'https://img.youtube.com/vi/' + self.videoID + '/' + availableSizes[step] + '.jpg';
            }

            if (self.type === 'vimeo') {
              var request = new XMLHttpRequest();
              request.open('GET', 'https://vimeo.com/api/v2/video/' + self.videoID + '.json', true);
              request.onreadystatechange = function () {
                if (this.readyState === 4) {
                  if (this.status >= 200 && this.status < 400) {
                    // Success!
                    var response = JSON.parse(this.responseText);
                    self.videoImage = response[0].thumbnail_large;
                    callback(self.videoImage);
                  } else {
                    // Error :(
                  }
                }
              };
              request.send();
              request = null;
            }
          }

          // fallback to the old version.

        }, {
          key: 'getIframe',
          value: function getIframe(callback) {
            this.getVideo(callback);
          }
        }, {
          key: 'getVideo',
          value: function getVideo(callback) {
            var self = this;

            // return generated video block
            if (self.$video) {
              callback(self.$video);
              return;
            }

            // generate new video block
            self.onAPIready(function () {
              var hiddenDiv = void 0;
              if (!self.$video) {
                hiddenDiv = document.createElement('div');
                hiddenDiv.style.display = 'none';
              }

              // Youtube
              if (self.type === 'youtube') {
                self.playerOptions = {};
                self.playerOptions.videoId = self.videoID;
                self.playerOptions.playerVars = {
                  autohide: 1,
                  rel: 0,
                  autoplay: 0,
                  // autoplay enable on mobile devices
                  playsinline: 1
                };

                // hide controls
                if (!self.options.showContols) {
                  self.playerOptions.playerVars.iv_load_policy = 3;
                  self.playerOptions.playerVars.modestbranding = 1;
                  self.playerOptions.playerVars.controls = 0;
                  self.playerOptions.playerVars.showinfo = 0;
                  self.playerOptions.playerVars.disablekb = 1;
                }

                // events
                var ytStarted = void 0;
                var ytProgressInterval = void 0;
                self.playerOptions.events = {
                  onReady: function onReady(e) {
                    // mute
                    if (self.options.mute) {
                      e.target.mute();
                    } else if (self.options.volume) {
                      e.target.setVolume(self.options.volume);
                    }

                    // autoplay
                    if (self.options.autoplay) {
                      self.play(self.options.startTime);
                    }
                    self.fire('ready', e);

                    // volumechange
                    setInterval(function () {
                      self.getVolume(function (volume) {
                        if (self.options.volume !== volume) {
                          self.options.volume = volume;
                          self.fire('volumechange', e);
                        }
                      });
                    }, 150);
                  },
                  onStateChange: function onStateChange(e) {
                    // loop
                    if (self.options.loop && e.data === YT.PlayerState.ENDED) {
                      self.play(self.options.startTime);
                    }
                    if (!ytStarted && e.data === YT.PlayerState.PLAYING) {
                      ytStarted = 1;
                      self.fire('started', e);
                    }
                    if (e.data === YT.PlayerState.PLAYING) {
                      self.fire('play', e);
                    }
                    if (e.data === YT.PlayerState.PAUSED) {
                      self.fire('pause', e);
                    }
                    if (e.data === YT.PlayerState.ENDED) {
                      self.fire('ended', e);
                    }

                    // progress check
                    if (e.data === YT.PlayerState.PLAYING) {
                      ytProgressInterval = setInterval(function () {
                        self.fire('timeupdate', e);

                        // check for end of video and play again or stop
                        if (self.options.endTime && self.player.getCurrentTime() >= self.options.endTime) {
                          if (self.options.loop) {
                            self.play(self.options.startTime);
                          } else {
                            self.pause();
                          }
                        }
                      }, 150);
                    } else {
                      clearInterval(ytProgressInterval);
                    }
                  }
                };

                var firstInit = !self.$video;
                if (firstInit) {
                  var div = document.createElement('div');
                  div.setAttribute('id', self.playerID);
                  hiddenDiv.appendChild(div);
                  document.body.appendChild(hiddenDiv);
                }
                self.player = self.player || new window.YT.Player(self.playerID, self.playerOptions);
                if (firstInit) {
                  self.$video = document.getElementById(self.playerID);

                  // get video width and height
                  self.videoWidth = parseInt(self.$video.getAttribute('width'), 10) || 1280;
                  self.videoHeight = parseInt(self.$video.getAttribute('height'), 10) || 720;
                }
              }

              // Vimeo
              if (self.type === 'vimeo') {
                self.playerOptions = '';

                self.playerOptions += 'player_id=' + self.playerID;
                self.playerOptions += '&autopause=0';
                self.playerOptions += '&transparent=0';

                // hide controls
                if (!self.options.showContols) {
                  self.playerOptions += '&badge=0&byline=0&portrait=0&title=0';
                }

                // autoplay
                self.playerOptions += '&autoplay=' + (self.options.autoplay ? '1' : '0');

                // loop
                self.playerOptions += '&loop=' + (self.options.loop ? 1 : 0);

                if (!self.$video) {
                  self.$video = document.createElement('iframe');
                  self.$video.setAttribute('id', self.playerID);
                  self.$video.setAttribute('src', 'https://player.vimeo.com/video/' + self.videoID + '?' + self.playerOptions);
                  self.$video.setAttribute('frameborder', '0');
                  hiddenDiv.appendChild(self.$video);
                  document.body.appendChild(hiddenDiv);
                }

                self.player = self.player || new Vimeo.Player(self.$video);

                // get video width and height
                self.player.getVideoWidth().then(function (width) {
                  self.videoWidth = width || 1280;
                });
                self.player.getVideoHeight().then(function (height) {
                  self.videoHeight = height || 720;
                });

                // set current time for autoplay
                if (self.options.startTime && self.options.autoplay) {
                  self.player.setCurrentTime(self.options.startTime);
                }

                // mute
                if (self.options.mute) {
                  self.player.setVolume(0);
                } else if (self.options.volume) {
                  self.player.setVolume(self.options.volume);
                }

                var vmStarted = void 0;
                self.player.on('timeupdate', function (e) {
                  if (!vmStarted) {
                    self.fire('started', e);
                    vmStarted = 1;
                  }

                  self.fire('timeupdate', e);

                  // check for end of video and play again or stop
                  if (self.options.endTime) {
                    if (self.options.endTime && e.seconds >= self.options.endTime) {
                      if (self.options.loop) {
                        self.play(self.options.startTime);
                      } else {
                        self.pause();
                      }
                    }
                  }
                });
                self.player.on('play', function (e) {
                  self.fire('play', e);

                  // check for the start time and start with it
                  if (self.options.startTime && e.seconds === 0) {
                    self.play(self.options.startTime);
                  }
                });
                self.player.on('pause', function (e) {
                  self.fire('pause', e);
                });
                self.player.on('ended', function (e) {
                  self.fire('ended', e);
                });
                self.player.on('loaded', function (e) {
                  self.fire('ready', e);
                });
                self.player.on('volumechange', function (e) {
                  self.fire('volumechange', e);
                });
              }

              // Local
              function addSourceToLocal(element, src, type) {
                var source = document.createElement('source');
                source.src = src;
                source.type = type;
                element.appendChild(source);
              }
              if (self.type === 'local') {
                if (!self.$video) {
                  self.$video = document.createElement('video');

                  // show controls
                  if (self.options.showContols) {
                    self.$video.controls = true;
                  }

                  // mute
                  if (self.options.mute) {
                    self.$video.muted = true;
                  } else if (self.$video.volume) {
                    self.$video.volume = self.options.volume / 100;
                  }

                  // loop
                  if (self.options.loop) {
                    self.$video.loop = true;
                  }

                  // autoplay enable on mobile devices
                  self.$video.setAttribute('playsinline', '');
                  self.$video.setAttribute('webkit-playsinline', '');

                  self.$video.setAttribute('id', self.playerID);
                  hiddenDiv.appendChild(self.$video);
                  document.body.appendChild(hiddenDiv);

                  Object.keys(self.videoID).forEach(function (key) {
                    addSourceToLocal(self.$video, self.videoID[key], 'video/' + key);
                  });
                }

                self.player = self.player || self.$video;

                var locStarted = void 0;
                self.player.addEventListener('playing', function (e) {
                  if (!locStarted) {
                    self.fire('started', e);
                  }
                  locStarted = 1;
                });
                self.player.addEventListener('timeupdate', function (e) {
                  self.fire('timeupdate', e);

                  // check for end of video and play again or stop
                  if (self.options.endTime) {
                    if (self.options.endTime && this.currentTime >= self.options.endTime) {
                      if (self.options.loop) {
                        self.play(self.options.startTime);
                      } else {
                        self.pause();
                      }
                    }
                  }
                });
                self.player.addEventListener('play', function (e) {
                  self.fire('play', e);
                });
                self.player.addEventListener('pause', function (e) {
                  self.fire('pause', e);
                });
                self.player.addEventListener('ended', function (e) {
                  self.fire('ended', e);
                });
                self.player.addEventListener('loadedmetadata', function () {
                  // get video width and height
                  self.videoWidth = this.videoWidth || 1280;
                  self.videoHeight = this.videoHeight || 720;

                  self.fire('ready');

                  // autoplay
                  if (self.options.autoplay) {
                    self.play(self.options.startTime);
                  }
                });
                self.player.addEventListener('volumechange', function (e) {
                  self.getVolume(function (volume) {
                    self.options.volume = volume;
                  });
                  self.fire('volumechange', e);
                });
              }

              callback(self.$video);
            });
          }
        }, {
          key: 'init',
          value: function init() {
            var self = this;

            self.playerID = 'VideoWorker-' + self.ID;
          }
        }, {
          key: 'loadAPI',
          value: function loadAPI() {
            var self = this;

            if (YoutubeAPIadded && VimeoAPIadded) {
              return;
            }

            var src = '';

            // load Youtube API
            if (self.type === 'youtube' && !YoutubeAPIadded) {
              YoutubeAPIadded = 1;
              src = 'https://www.youtube.com/iframe_api';
            }

            // load Vimeo API
            if (self.type === 'vimeo' && !VimeoAPIadded) {
              VimeoAPIadded = 1;
              src = 'https://player.vimeo.com/api/player.js';
            }

            if (!src) {
              return;
            }

            // add script in head section
            var tag = document.createElement('script');
            var head = document.getElementsByTagName('head')[0];
            tag.src = src;

            head.appendChild(tag);

            head = null;
            tag = null;
          }
        }, {
          key: 'onAPIready',
          value: function onAPIready(callback) {
            var self = this;

            // Youtube
            if (self.type === 'youtube') {
              // Listen for global YT player callback
              if ((typeof YT === 'undefined' || YT.loaded === 0) && !loadingYoutubePlayer) {
                // Prevents Ready event from being called twice
                loadingYoutubePlayer = 1;

                // Creates deferred so, other players know when to wait.
                window.onYouTubeIframeAPIReady = function () {
                  window.onYouTubeIframeAPIReady = null;
                  loadingYoutubeDefer.resolve('done');
                  callback();
                };
              } else if ((typeof YT === 'undefined' ? 'undefined' : _typeof(YT)) === 'object' && YT.loaded === 1) {
                callback();
              } else {
                loadingYoutubeDefer.done(function () {
                  callback();
                });
              }
            }

            // Vimeo
            if (self.type === 'vimeo') {
              if (typeof Vimeo === 'undefined' && !loadingVimeoPlayer) {
                loadingVimeoPlayer = 1;
                var vimeoInterval = setInterval(function () {
                  if (typeof Vimeo !== 'undefined') {
                    clearInterval(vimeoInterval);
                    loadingVimeoDefer.resolve('done');
                    callback();
                  }
                }, 20);
              } else if (typeof Vimeo !== 'undefined') {
                callback();
              } else {
                loadingVimeoDefer.done(function () {
                  callback();
                });
              }
            }

            // Local
            if (self.type === 'local') {
              callback();
            }
          }
        }]);

        return VideoWorker;
      }();

      exports.default = VideoWorker;

      /***/
}),
/* 10 */
/***/ (function (module, exports, __webpack_require__) {

      "use strict";


      Object.defineProperty(exports, "__esModule", {
        value: true
      });
      exports.default = jarallaxVideo;

      var _videoWorker = __webpack_require__(8);

      var _videoWorker2 = _interopRequireDefault(_videoWorker);

      var _global = __webpack_require__(4);

      var _global2 = _interopRequireDefault(_global);

      function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

      function jarallaxVideo() {
        var jarallax = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : _global2.default.jarallax;

        if (typeof jarallax === 'undefined') {
          return;
        }

        var Jarallax = jarallax.constructor;

        // append video after init Jarallax
        var defInit = Jarallax.prototype.init;
        Jarallax.prototype.init = function () {
          var self = this;

          defInit.apply(self);

          if (self.video && !self.options.disableVideo()) {
            self.video.getVideo(function (video) {
              var $parent = video.parentNode;
              self.css(video, {
                position: self.image.position,
                top: '0px',
                left: '0px',
                right: '0px',
                bottom: '0px',
                width: '100%',
                height: '100%',
                maxWidth: 'none',
                maxHeight: 'none',
                margin: 0,
                zIndex: -1
              });
              self.$video = video;
              self.image.$container.appendChild(video);

              // remove parent video element (created by VideoWorker)
              $parent.parentNode.removeChild($parent);
            });
          }
        };

        // cover video
        var defCoverImage = Jarallax.prototype.coverImage;
        Jarallax.prototype.coverImage = function () {
          var self = this;
          var imageData = defCoverImage.apply(self);
          var node = self.image.$item ? self.image.$item.nodeName : false;

          if (imageData && self.video && node && (node === 'IFRAME' || node === 'VIDEO')) {
            var h = imageData.image.height;
            var w = h * self.image.width / self.image.height;
            var ml = (imageData.container.width - w) / 2;
            var mt = imageData.image.marginTop;

            if (imageData.container.width > w) {
              w = imageData.container.width;
              h = w * self.image.height / self.image.width;
              ml = 0;
              mt += (imageData.image.height - h) / 2;
            }

            // add video height over than need to hide controls
            if (node === 'IFRAME') {
              h += 400;
              mt -= 200;
            }

            self.css(self.$video, {
              width: w + 'px',
              marginLeft: ml + 'px',
              height: h + 'px',
              marginTop: mt + 'px'
            });
          }

          return imageData;
        };

        // init video
        var defInitImg = Jarallax.prototype.initImg;
        Jarallax.prototype.initImg = function () {
          var self = this;
          var defaultResult = defInitImg.apply(self);

          if (!self.options.videoSrc) {
            self.options.videoSrc = self.$item.getAttribute('data-jarallax-video') || null;
          }

          if (self.options.videoSrc) {
            self.defaultInitImgResult = defaultResult;
            return true;
          }

          return defaultResult;
        };

        var defCanInitParallax = Jarallax.prototype.canInitParallax;
        Jarallax.prototype.canInitParallax = function () {
          var self = this;
          var defaultResult = defCanInitParallax.apply(self);

          if (!self.options.videoSrc) {
            return defaultResult;
          }

          var video = new _videoWorker2.default(self.options.videoSrc, {
            autoplay: true,
            loop: true,
            showContols: false,
            startTime: self.options.videoStartTime || 0,
            endTime: self.options.videoEndTime || 0,
            mute: self.options.videoVolume ? 0 : 1,
            volume: self.options.videoVolume || 0
          });

          if (video.isValid()) {
            // if parallax will not be inited, we can add thumbnail on background.
            if (!defaultResult) {
              if (!self.defaultInitImgResult) {
                video.getImageURL(function (url) {
                  // save default user styles
                  var curStyle = self.$item.getAttribute('style');
                  if (curStyle) {
                    self.$item.setAttribute('data-jarallax-original-styles', curStyle);
                  }

                  // set new background
                  self.css(self.$item, {
                    'background-image': 'url("' + url + '")',
                    'background-position': 'center',
                    'background-size': 'cover'
                  });
                });
              }

              // init video
            } else {
              video.on('ready', function () {
                if (self.options.videoPlayOnlyVisible) {
                  var oldOnScroll = self.onScroll;
                  self.onScroll = function () {
                    oldOnScroll.apply(self);
                    if (self.isVisible()) {
                      video.play();
                    } else {
                      video.pause();
                    }
                  };
                } else {
                  video.play();
                }
              });

              video.on('started', function () {
                self.image.$default_item = self.image.$item;
                self.image.$item = self.$video;

                // set video width and height
                self.image.width = self.video.videoWidth || 1280;
                self.image.height = self.video.videoHeight || 720;
                self.options.imgWidth = self.image.width;
                self.options.imgHeight = self.image.height;
                self.coverImage();
                self.clipContainer();
                self.onScroll();

                // hide image
                if (self.image.$default_item) {
                  self.image.$default_item.style.display = 'none';
                }
              });

              self.video = video;

              // set image if not exists
              if (!self.defaultInitImgResult) {
                if (video.type !== 'local') {
                  video.getImageURL(function (url) {
                    self.image.src = url;
                    self.init();
                  });

                  return false;
                }

                // set empty image on local video if not defined
                self.image.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
                return true;
              }
            }
          }

          return defaultResult;
        };

        // Destroy video parallax
        var defDestroy = Jarallax.prototype.destroy;
        Jarallax.prototype.destroy = function () {
          var self = this;

          if (self.image.$default_item) {
            self.image.$item = self.image.$default_item;
            delete self.image.$default_item;
          }

          defDestroy.apply(self);
        };
      }

      /***/
})
/******/]);
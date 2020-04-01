//ブラウザ判定用
var ua = window.navigator.userAgent.toLowerCase();
var isMobile = false;
if(ua.indexOf('iphone') > -1 || ua.indexOf('ipod') > -1 || ua.indexOf('ipad') > -1 || ua.indexOf('android') > -1 || ua.indexOf('phone') > -1){
  isMobile = true;
}
var isIE = false;
if(ua.indexOf('msie') > -1 || ua.indexOf('trident') > -1){
  isIE = true;
}

//グローバル変数
var $header = $('#header');
var $headerInner = $('#headerInner');
var $navMenu = $('#navMenu');
var $footer = $('#footer');
var $navIcon = $('#navIcon');

var windowWidth = $('.wrp').outerWidth();
var windowWidthWithScrollbar = $('.wbx').outerWidth();
var windowHeight = $(window).height();
var spHeaderHeight = 73;
var tbHeaderHeight = 81;
var pcHeaderHeight = 180;
var headerCurrentHeight = $header.outerHeight(true);
var headerInnerHeight = $headerInner.outerHeight();
var navHeight = $navMenu.outerHeight();
var ul1MaxHeight = windowHeight-headerInnerHeight;
var leftContentsHeight;
var leftContentsWidth;
var rightNavHeight;
var rightNavOffset;
var footerHeight = $footer.outerHeight();
var topPerView = 1;
// var mainVisSwiper;
var tbBreakPoint1 = 769;
// var tbBreakPoint2 = 900;
var pcBreakPoint1 = 1050;
var pcBreakPoint2 = 1160;

function getGlobalVariable(){
  windowWidth = $('.wrp').outerWidth();
  windowWidthWithScrollbar = $('.wbx').outerWidth();
  windowHeight = $(window).height();
  headerCurrentHeight = $header.outerHeight(true);
  headerInnerHeight = $headerInner.outerHeight();
  navHeight = $navMenu.outerHeight();
  ul1MaxHeight = windowHeight-headerInnerHeight;
  footerHeight = $footer.outerHeight();
  if(windowWidthWithScrollbar>768){
    pcHeaderHeight = $header.outerHeight(true);
  }
}


//画面ロード時
$(window).on('load',function(){
  $('a').bind('touchstart', function(){});
  getGlobalVariable();

  setBtnToTop();
  slideMenu();
  slideSubmenu();
  smoothScroll();
  floatMenu();
  showSubMenu();

  new WOW({
    animateClass: 'animated',
    boxClass: 'fadeInUp',
    offset: 0
  }).init();

});


//index.html用
function indexInitialSetting(){

  new WOW({
    animateClass: 'animated',
    boxClass: 'fadeInUpBig',
    offset: 0
  }).init();

  if(windowWidth<1100){
    topPerView = 1;
  } else {
    topPerView = windowWidth/1100;
  }

  // mainVisSwiper = new Swiper ('#mainVis', {
  //   slidesPerView: topPerView,
  //   loop: true,
  //   loopedSlides: 4,
  //   centeredSlides: true,
  //   spaceBetween: 0,
  //   speed: 5000,
  //   autoplay: {
  //     delay: 5000,
  //     disableOnInteraction: false,
  //   }
  // });

  ellipsisText('top-diary-body', 30);
}

function indexResized(){
  if(windowWidth<1100){
    topPerView = 1;
  } else {
    topPerView = windowWidth/1100;
  }
  // mainVisSwiper.params.slidesPerView = topPerView;
}


//画面サイズ変更時
$(window).on('resize orientationchange',function(){
  getGlobalVariable();
  if($('body').attr('id')=='home'){
    indexResized();
  }

  if(windowWidthWithScrollbar>=pcBreakPoint1){
    $navMenu.removeClass('nav-1-open').removeAttr('style');
    if($navIcon.hasClass('nav-toggle-close')){
      $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
      $header.removeClass('header-open');
    }

    if($('.nav-ul-2').hasClass('nav-2-open')){
      $('.nav-toggle-2').removeClass('nav-toggle-2-close');
      $('.nav-ul-2').removeClass('nav-2-open');
    }
    $('.nav-ul-2').attr('style','');
  } else {
    $header.css('transform', 'scale(1)');
    $navMenu.removeClass('nav-1-open').removeAttr('style');
    if($navIcon.hasClass('nav-toggle-close')){
      $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
      $header.removeClass('header-open');
    }

    if($('.nav-ul-2').hasClass('nav-2-open')){
      $('.nav-ul-2').removeClass('nav-2-open');
    }
    $('.nav-toggle-2').removeClass('nav-toggle-2-close').addClass('nav-toggle-2-open');

    $('#main').css('margin-top', 0);
    // if(windowWidthWithScrollbar<tbBreakPoint2){
    //   if($header.hasClass('header-float')){
    //     $header.removeClass('header-float');
    //   }
    // }
  }
});


//exScroll
(function($j){
    $j.ex = $j.ex || {};
    $j.ex.scrollEvent = function( target , config ){
        var o = this;
        if( typeof config == 'function') config = {
            callback : config
        }
        var c = o.config = $j.extend({},$j.ex.scrollEvent.defaults,config,{
            target : target
        });
        c.status = 0;
        c.scroll = o.getPos();
        c.target.scroll(function( evt ){
            if (o.isMove()) {
                c.status = (c.status == 0 ? 1 : (c.status == 1 ? 2 : c.status) );
                c.callback( evt , c );
            }
            if(c.tm) clearTimeout(c.tm);
            c.tm = setTimeout(function(){
                o.isMove();
                c.status = 0;
                c.callback( evt , c );
            },c.delay);
        });
    }
    $j.extend($j.ex.scrollEvent.prototype,{
        isMove : function(){
            var o = this, c = o.config;
            var pos = o.getPos();
            var scrollY = (pos.top != c.scroll.top);
            var scrollX = (pos.left != c.scroll.left);
            if(scrollY || scrollX){
                c.scrollY = scrollY;
                c.scrollX = scrollX;
                c.prevScroll = c.scroll;
                c.scroll = pos;
                return true;
            }
            return false;

        },
        getPos : function(){
            var o = this, c = o.config;
            return {
                top : c.target.scrollTop(),
                left : c.target.scrollLeft()
            }       
        }
    });
    $j.ex.scrollEvent.defaults = {
        delay : 100
    }
    $j.fn.exScrollEvent = function( config ){
        new $j.ex.scrollEvent(this , config);
        return this;
    };
})(jQuery);

function floatMenu(){
  $(window).on('scroll', function(){
    //グローバルナビ
    if(windowWidthWithScrollbar>=pcBreakPoint1){
      if(windowWidthWithScrollbar<pcBreakPoint2){
        $header.css('left', -$(window).scrollLeft()+'px');
      } else {
        $header.css('left',0);
      }

      if($(this).scrollTop() > 100){
        $header.addClass('header-float');
      } else {
        $header.removeClass('header-float header-open');
        $navMenu.css('margin-top', 0);
        if($navIcon.hasClass('nav-toggle-close')){
          $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          $navMenu.removeClass('nav-1-open').attr('style','');
          $header.removeClass('header-open');
        }
      }
    } else {
      if($(this).scrollTop() > spHeaderHeight){
        if($navIcon.hasClass('nav-toggle-close')){
          $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          $navMenu.removeClass('nav-1-open').attr('style','');
          $header.removeClass('header-open');
        }
      } else {
        $navMenu.css('margin-top', 0);
        if($navIcon.hasClass('nav-toggle-close')){
          $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          $navMenu.removeClass('nav-1-open').attr('style','');
          $header.removeClass('header-open');
        }
      }
    }

  });
}

//メニューの開閉用設定
function slideMenu(){
  $navIcon.on('click', function(e){
    if(windowWidthWithScrollbar<pcBreakPoint1){
      if($navMenu.hasClass('nav-1-open')){
        if($('#navMenu:not(:animated)')){
          $navMenu.animate(
            {marginTop:'-'+ul1MaxHeight+'px'},
            {duration: '500',
             easing: 'swing',
             complete: function(){$(this).removeClass('nav-1-open');}
             }
          );
          $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          $header.removeClass('header-open');
        }
      } else {
        if($('#navMenu:not(:animated)')){
          $navMenu.css('max-height', ul1MaxHeight+'px');
          $navMenu.css('margin-top', '-'+ul1MaxHeight+'px');
          $navMenu.addClass('nav-1-open').animate(
            {marginTop:'0'},
            {duration: '500',
             easing: 'swing'}
          );
          $navIcon.removeClass('nav-toggle-open').addClass('nav-toggle-close');
          $header.addClass('header-open');
        }
      }
    } else {
      if($header.hasClass('header-float')){
        if($navMenu.hasClass('nav-1-open')){
          if($('#navMenu:not(:animated)')){
            $navMenu.animate(
              {marginTop:'-'+navHeight+'px'},
              {duration: '100',
               easing: 'swing',
               complete: function(){$(this).removeClass('nav-1-open');}
               }
            );
            $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
            $header.removeClass('header-open');
          }
        } else {
          if($('#navMenu:not(:animated)')){
            $navMenu.css('margin-top', '-'+navHeight+'px');
            $navMenu.addClass('nav-1-open').animate(
              {marginTop:'0'},
              {duration: '100', easing: 'swing'}
            );
            $navIcon.removeClass('nav-toggle-open').addClass('nav-toggle-close');
            $header.addClass('header-open');
          }
        }
      }
    }
  });
}

//メニューの開閉用設定
function slideSubmenu(){
  $('.nav-toggle-2').on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    var submenu = $(this).closest('.nav-ul-1-li').find('.nav-ul-2');
    var submenuNotAnimated = $(this).closest('.nav-ul-1-li').find('.nav-ul-2:not(:animated)');
    if(submenu.hasClass('nav-2-open')){
      $(this).removeClass('nav-2-open');
      submenuNotAnimated.slideUp('300').removeClass('nav-2-open');
      $(this).removeClass('nav-toggle-2-close').addClass('nav-toggle-2-open');
    } else {
      $(this).addClass('nav-2-open');
      submenuNotAnimated.slideDown('300').addClass('nav-2-open');
      $(this).addClass('nav-toggle-2-close').removeClass('nav-toggle-2-open');
    }
  });
}

function showSubMenu(){
  if(windowWidthWithScrollbar>pcBreakPoint1){
    if(isMobile){
      $('.has-submenu').off('mouseenter').off('mouseleave');
      $('.has-submenu').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();

        if($(this).find('.nav-ul-2:not(:animated)').hasClass('nav-2-open')){
          $(this).find('.nav-ul-2').removeClass('nav-2-open');
        } else {
          $('.has-submenu').find('.nav-ul-2.nav-2-open').removeClass('nav-2-open');
          $(this).find('.nav-ul-2:not(:animated)').addClass('nav-2-open');
        }
      });
    } else {

    }
  }
}


//画面トップへのボタンの位置設定
function setBtnToTop(){
  $('#btnToTop').click(function(){scrollToTop()});

  $(window).scroll(function(){
    if($(this).scrollTop() >= windowHeight){
      $('#btnToTop').addClass('btn-to-top-visible');
    } else {
      $('#btnToTop').removeClass('btn-to-top-visible');
    }
  });
}

//画面トップへ戻るボタンの動作設定
function scrollToTop(){
  var scrDistance = $('#btnToTop').offset().top ? $('#btnToTop').offset().top : $('#btnToTop').getBoundingClientRect().top;
  var scrDuration = Math.abs(0 - scrDistance) * 100 / 500;
  $('html, body').animate({scrollTop: 0},{duration: scrDuration, easing:'linear'});
}

//ページ内リンクのスムーズなスクロール
function smoothScroll(){
  var currentUrlArr = window.location.href.split('/', -1);
  var currentUrl = currentUrlArr[currentUrlArr.length-1].split('#')[0];
  // aタグのクリック
  $('a[href*="#"]').click(function(){
    var nextUrl = $(this).attr('href');
    nextUrl = nextUrl.split('#')[0];
    if(nextUrl==currentUrl){
      if(windowWidthWithScrollbar<pcBreakPoint1){
        if($('#navMenu:not(:animated)')){
          $navMenu.animate(
            {marginTop:'-'+ul1MaxHeight+'px'},
            {duration: '500',
             easing: 'swing',
             complete: function(){$(this).removeClass('nav-1-open');}
             }
          );
          $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          $header.removeClass('header-open');
        }
      } else {
        if($('#navMenu:not(:animated)')){
          // $navMenu.animate(
          //   {marginTop:'-'+navHeight+'px'},
          //   {duration: '100',
          //    easing: 'swing',
          //    complete: function(){$(this).removeClass('nav-1-open');}
          //    }
          // );
          // $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          $header.removeClass('header-open');
        }
      }
      var target = $(this.hash);
      if (target) {
        var targetOffset = target.offset().top ? target.offset().top : target.getBoundingClientRect().top;
        $('html,body').animate({scrollTop: targetOffset},500,"swing");
        if(windowWidthWithScrollbar>=pcBreakPoint1){

        } else {
          if(!$('#navMenu ul.nav-ul-1').is(':animated')){
            $navIcon.removeClass('nav-toggle-close').addClass('nav-toggle-open');
          }
          $navMenu.css('max-height', '100%').removeClass('open');
        }
        return false;
      }
    }
  });

}

//高い方に合わせる高さ調整
function numberSort(a,b){
  var na= new Number(a);
  var nb= new Number(b);
  return (nb-na);
}

function equalizeHeight(className){
  var itemsHeight = [];
  $('.'+className).each(function(){
    $(this).css('height','auto');
    itemsHeight.push($(this).outerHeight());
  });
  itemsHeight.sort(numberSort);
  $('.'+className).outerHeight(itemsHeight[0]);
}

//文章の文字数制限
function ellipsisText(classNm, num){
  $('.'+classNm).each(function(){
    var txt = $(this).html();
    $(this).html(txt.substr(0,num)+'...');
});
}


/*! WOW - v1.1.1 - 2015-04-07
* Copyright (c) 2015 Matthieu Aussaguel; Licensed MIT */(function(){var a,b,c,d,e,f=function(a,b){return function(){return a.apply(b,arguments)}},g=[].indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(b in this&&this[b]===a)return b;return-1};b=function(){function a(){}return a.prototype.extend=function(a,b){var c,d;for(c in b)d=b[c],null==a[c]&&(a[c]=d);return a},a.prototype.isMobile=function(a){return/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(a)},a.prototype.createEvent=function(a,b,c,d){var e;return null==b&&(b=!1),null==c&&(c=!1),null==d&&(d=null),null!=document.createEvent?(e=document.createEvent("CustomEvent"),e.initCustomEvent(a,b,c,d)):null!=document.createEventObject?(e=document.createEventObject(),e.eventType=a):e.eventName=a,e},a.prototype.emitEvent=function(a,b){return null!=a.dispatchEvent?a.dispatchEvent(b):b in(null!=a)?a[b]():"on"+b in(null!=a)?a["on"+b]():void 0},a.prototype.addEvent=function(a,b,c){return null!=a.addEventListener?a.addEventListener(b,c,!1):null!=a.attachEvent?a.attachEvent("on"+b,c):a[b]=c},a.prototype.removeEvent=function(a,b,c){return null!=a.removeEventListener?a.removeEventListener(b,c,!1):null!=a.detachEvent?a.detachEvent("on"+b,c):delete a[b]},a.prototype.innerHeight=function(){return"innerHeight"in window?window.innerHeight:document.documentElement.clientHeight},a}(),c=this.WeakMap||this.MozWeakMap||(c=function(){function a(){this.keys=[],this.values=[]}return a.prototype.get=function(a){var b,c,d,e,f;for(f=this.keys,b=d=0,e=f.length;e>d;b=++d)if(c=f[b],c===a)return this.values[b]},a.prototype.set=function(a,b){var c,d,e,f,g;for(g=this.keys,c=e=0,f=g.length;f>e;c=++e)if(d=g[c],d===a)return void(this.values[c]=b);return this.keys.push(a),this.values.push(b)},a}()),a=this.MutationObserver||this.WebkitMutationObserver||this.MozMutationObserver||(a=function(){function a(){"undefined"!=typeof console&&null!==console&&console.warn("MutationObserver is not supported by your browser."),"undefined"!=typeof console&&null!==console&&console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")}return a.notSupported=!0,a.prototype.observe=function(){},a}()),d=this.getComputedStyle||function(a){return this.getPropertyValue=function(b){var c;return"float"===b&&(b="styleFloat"),e.test(b)&&b.replace(e,function(a,b){return b.toUpperCase()}),(null!=(c=a.currentStyle)?c[b]:void 0)||null},this},e=/(\-([a-z]){1})/g,this.WOW=function(){function e(a){null==a&&(a={}),this.scrollCallback=f(this.scrollCallback,this),this.scrollHandler=f(this.scrollHandler,this),this.start=f(this.start,this),this.resetAnimation=f(this.resetAnimation,this),this.scrolled=!0,this.config=this.util().extend(a,this.defaults),this.animationNameCache=new c,this.wowEvent=this.util().createEvent(this.config.boxClass)}return e.prototype.defaults={boxClass:"wow",animateClass:"animated",offset:0,mobile:!0,live:!0,callback:null},e.prototype.init=function(){var a;return this.element=window.document.documentElement,"interactive"===(a=document.readyState)||"complete"===a?this.start():this.util().addEvent(document,"DOMContentLoaded",this.start),this.finished=[]},e.prototype.start=function(){var b,c,d,e;if(this.stopped=!1,this.boxes=function(){var a,c,d,e;for(d=this.element.querySelectorAll("."+this.config.boxClass),e=[],a=0,c=d.length;c>a;a++)b=d[a],e.push(b);return e}.call(this),this.all=function(){var a,c,d,e;for(d=this.boxes,e=[],a=0,c=d.length;c>a;a++)b=d[a],e.push(b);return e}.call(this),this.boxes.length)if(this.disabled())this.resetStyle();else for(e=this.boxes,c=0,d=e.length;d>c;c++)b=e[c],this.applyStyle(b,!0);return this.disabled()||(this.util().addEvent(window,"scroll",this.scrollHandler),this.util().addEvent(window,"resize",this.scrollHandler),this.interval=setInterval(this.scrollCallback,50)),this.config.live?new a(function(a){return function(b){var c,d,e,f,g;for(g=[],c=0,d=b.length;d>c;c++)f=b[c],g.push(function(){var a,b,c,d;for(c=f.addedNodes||[],d=[],a=0,b=c.length;b>a;a++)e=c[a],d.push(this.doSync(e));return d}.call(a));return g}}(this)).observe(document.body,{childList:!0,subtree:!0}):void 0},e.prototype.stop=function(){return this.stopped=!0,this.util().removeEvent(window,"scroll",this.scrollHandler),this.util().removeEvent(window,"resize",this.scrollHandler),null!=this.interval?clearInterval(this.interval):void 0},e.prototype.sync=function(){return a.notSupported?this.doSync(this.element):void 0},e.prototype.doSync=function(a){var b,c,d,e,f;if(null==a&&(a=this.element),1===a.nodeType){for(a=a.parentNode||a,e=a.querySelectorAll("."+this.config.boxClass),f=[],c=0,d=e.length;d>c;c++)b=e[c],g.call(this.all,b)<0?(this.boxes.push(b),this.all.push(b),this.stopped||this.disabled()?this.resetStyle():this.applyStyle(b,!0),f.push(this.scrolled=!0)):f.push(void 0);return f}},e.prototype.show=function(a){return this.applyStyle(a),a.className=a.className+" "+this.config.animateClass,null!=this.config.callback&&this.config.callback(a),this.util().emitEvent(a,this.wowEvent),this.util().addEvent(a,"animationend",this.resetAnimation),this.util().addEvent(a,"oanimationend",this.resetAnimation),this.util().addEvent(a,"webkitAnimationEnd",this.resetAnimation),this.util().addEvent(a,"MSAnimationEnd",this.resetAnimation),a},e.prototype.applyStyle=function(a,b){var c,d,e;return d=a.getAttribute("data-wow-duration"),c=a.getAttribute("data-wow-delay"),e=a.getAttribute("data-wow-iteration"),this.animate(function(f){return function(){return f.customStyle(a,b,d,c,e)}}(this))},e.prototype.animate=function(){return"requestAnimationFrame"in window?function(a){return window.requestAnimationFrame(a)}:function(a){return a()}}(),e.prototype.resetStyle=function(){var a,b,c,d,e;for(d=this.boxes,e=[],b=0,c=d.length;c>b;b++)a=d[b],e.push(a.style.visibility="visible");return e},e.prototype.resetAnimation=function(a){var b;return a.type.toLowerCase().indexOf("animationend")>=0?(b=a.target||a.srcElement,b.className=b.className.replace(this.config.animateClass,"").trim()):void 0},e.prototype.customStyle=function(a,b,c,d,e){return b&&this.cacheAnimationName(a),a.style.visibility=b?"hidden":"visible",c&&this.vendorSet(a.style,{animationDuration:c}),d&&this.vendorSet(a.style,{animationDelay:d}),e&&this.vendorSet(a.style,{animationIterationCount:e}),this.vendorSet(a.style,{animationName:b?"none":this.cachedAnimationName(a)}),a},e.prototype.vendors=["moz","webkit"],e.prototype.vendorSet=function(a,b){var c,d,e,f;d=[];for(c in b)e=b[c],a[""+c]=e,d.push(function(){var b,d,g,h;for(g=this.vendors,h=[],b=0,d=g.length;d>b;b++)f=g[b],h.push(a[""+f+c.charAt(0).toUpperCase()+c.substr(1)]=e);return h}.call(this));return d},e.prototype.vendorCSS=function(a,b){var c,e,f,g,h,i;for(h=d(a),g=h.getPropertyCSSValue(b),f=this.vendors,c=0,e=f.length;e>c;c++)i=f[c],g=g||h.getPropertyCSSValue("-"+i+"-"+b);return g},e.prototype.animationName=function(a){var b;try{b=this.vendorCSS(a,"animation-name").cssText}catch(c){b=d(a).getPropertyValue("animation-name")}return"none"===b?"":b},e.prototype.cacheAnimationName=function(a){return this.animationNameCache.set(a,this.animationName(a))},e.prototype.cachedAnimationName=function(a){return this.animationNameCache.get(a)},e.prototype.scrollHandler=function(){return this.scrolled=!0},e.prototype.scrollCallback=function(){var a;return!this.scrolled||(this.scrolled=!1,this.boxes=function(){var b,c,d,e;for(d=this.boxes,e=[],b=0,c=d.length;c>b;b++)a=d[b],a&&(this.isVisible(a)?this.show(a):e.push(a));return e}.call(this),this.boxes.length||this.config.live)?void 0:this.stop()},e.prototype.offsetTop=function(a){for(var b;void 0===a.offsetTop;)a=a.parentNode;for(b=a.offsetTop;a=a.offsetParent;)b+=a.offsetTop;return b},e.prototype.isVisible=function(a){var b,c,d,e,f;return c=a.getAttribute("data-wow-offset")||this.config.offset,f=window.pageYOffset,e=f+Math.min(this.element.clientHeight,this.util().innerHeight())-c,d=this.offsetTop(a),b=d+a.clientHeight,e>=d&&b>=f},e.prototype.util=function(){return null!=this._util?this._util:this._util=new b},e.prototype.disabled=function(){return!this.config.mobile&&this.util().isMobile(navigator.userAgent)},e}()}).call(this);
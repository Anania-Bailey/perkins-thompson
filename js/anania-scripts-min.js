jQuery((function($){function e(){var e=$(".superheader").outerHeight(),t=$(".site-header").outerHeight();null==e&&(e=0),$(window).scrollTop()>e?($(".site-header").addClass("site-header--sticky"),$(".site-inner").css("margin-top",t)):($(".site-header").removeClass("site-header--sticky"),$(".site-inner").css("margin-top",0))}function t(){var e=document.querySelector(".mobile-nav");$(".menu-toggle").on("click",(function(){var t,i,n,o,a=$(window).scrollTop(),s=$(".site-header").outerHeight();if($(".site-container").addClass("fixed"),a>0){$(".site-container").addClass("fixed--scroll");var r=a-s;$(".site-container").css("margin-top",-r)}$(".site-container").attr("aria-hidden","true"),$(".site-container").attr("data-position",a),$(".mobile-nav").addClass("mobile-nav--visible"),$(".mobile-nav").attr({"aria-hidden":"false",open:"true",tabindex:0}),$(".menu-close").focus(),i=(t=e).querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])'),n=i[0],o=i[i.length-1],t.addEventListener("keydown",(function(e){("Tab"===e.key||9===e.keyCode)&&(e.shiftKey?document.activeElement===n&&(o.focus(),e.preventDefault()):document.activeElement===o&&(n.focus(),e.preventDefault()))}))})),$(".menu-close").click((function(){var e=$(".site-container").attr("data-position");$(".site-container").removeClass("fixed"),e>0?($(".site-container").removeClass("fixed--scroll"),$(".site-container").css("padding-top","0"),$(".site-container").css("margin-top","0")):e=0,$(".site-container").attr("aria-hidden","false"),$(".mobile-nav").attr("aria-hidden","true"),$(".mobile-nav").removeAttr("open tabindex"),$(".menu-toggle").focus(),$(window).scrollTop(e),$(".mobile-nav").removeClass("mobile-nav--visible")})),$(".menu-anchor").click((function(){var e=$(".site-container").attr("data-position");$(".site-container").removeClass("fixed"),e>0?($(".site-container").removeClass("fixed--scroll"),$(".site-container").css("padding-top","0"),$(".site-container").css("margin-top","0")):e=0,$(".site-container").attr("aria-hidden","false"),$(".mobile-nav").attr("aria-hidden","true"),$(".mobile-nav").removeAttr("open tabindex"),$(".menu-toggle").focus(),$(window).scrollTop(e),$(".mobile-nav").removeClass("mobile-nav--visible")})),$(".submenu-toggle").click((function(e){let t=$(this).parent().parent(".menu-item-has-children");$(this).hasClass("rotated")?($(this).removeClass("rotated"),t.children(".sub-menu").slideUp(),$(this).focus(),e.stopPropagation()):($(this).addClass("rotated"),t.children(".sub-menu").slideDown(),t.children(".sub-menu > li:first-of-type a").focus(),e.stopPropagation())}))}$.fn.isOnScreen=function(){var e=$(window),t={top:e.scrollTop(),left:e.scrollLeft()};t.right=t.left+e.width(),t.bottom=t.top+e.height();var i=this.offset();return i.right=i.left+this.outerWidth(),i.bottom=i.top+this.outerHeight(),!(t.right<i.left||t.left>i.right||t.bottom<i.top||t.top>i.bottom)},$(document).ready((function(){t(),e()}));var i=$(window).width();$(window).resize((function(){$(window).width()!=i&&($(window).width()<1100&&$(".mobile-nav").hasClass("mobile-nav--visible")?$(".site-container").addClass("fixed"):($(".site-container").removeClass("fixed"),$(".site-container").removeClass("fixed--scroll")))})),$(window).scroll((function(){e()})),$(window).on("resize scroll load",(function(){$(".fade-in").each((function(){$(this).isOnScreen()&&$(this).addClass("fade-in--visible")}))}))}));
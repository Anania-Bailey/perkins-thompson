jQuery(function($) {

    $.fn.isOnScreen = function() {

        var win = $(window);

        var viewport = {
            top: win.scrollTop(),
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

    };

    function trapFocus(element) {
        var focusableEls = element.querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])');
        var firstFocusableEl = focusableEls[0];
        var lastFocusableEl = focusableEls[focusableEls.length - 1];
        var KEYCODE_TAB = 9;

        element.addEventListener('keydown', function(e) {
            var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

            if (!isTabPressed) {
                return;
            }

            if (e.shiftKey) /* shift + tab */ {
                if (document.activeElement === firstFocusableEl) {
                    lastFocusableEl.focus();
                    e.preventDefault();
                }
            } else /* tab */ {
                if (document.activeElement === lastFocusableEl) {
                    firstFocusableEl.focus();
                    e.preventDefault();
                }
            }
        });
    }

    var secondNav;
    
    function stickyHeader() {
        var scrollHeight = 0;

        if ($('body').hasClass('home') && $(window).width() > 1024) {
            var scrollPos = $(window).scrollTop() + $('.site-header').outerHeight();
            
            if (!$('.nav-secondary').hasClass('nav-secondary--processed')) {
                secondNav = $('.nav-secondary').offset().top;
                $('.nav-secondary').addClass('nav-secondary--processed');
            }

            if (scrollPos <= secondNav) {
                $('.header-wrap').removeClass('header-wrap--sticky');
            } else {
                    $('.header-wrap').addClass('header-wrap--sticky');
            }
            
        } else {

            if ($(window).scrollTop() > scrollHeight) {
                $('.header-wrap').addClass('header-wrap--sticky');
            } else {
                $('.header-wrap').removeClass('header-wrap--sticky');
            }

        }

    }
    
    function accordionStuff() {
        
        if ($(window).width() > 780) {
        
            $('.is-style-accordion-parent').each(function() {
                var introHeight = $(this).find('.is-style-accordion-intro').outerHeight();
                var collapsedHeight = $(this).find('.is-style-accordion-container').outerHeight() + parseInt($(this).find('.is-style-accordion-container').css('margin-block-start'), 10);
                var maxChild = 0;
                var accordions = $(this).find('.pt-accordion');
                
                accordions.each(function() {
                    var childHeight = 0;
                    
                    $(this).find('.accordion-content-inner').children().each(function() {
                        childHeight += $(this).outerHeight();
                        childHeight += parseInt($(this).css('margin-bottom'), 10);
                    });
                    
                    childHeight += 20;
                    
                    if (childHeight > maxChild) {
                        maxChild = childHeight;
                    }
                    
                });
                            
                var maxAccordion = collapsedHeight + maxChild;
                
                $(this).find('.is-style-accordion-container').css('min-height', maxAccordion);
                
                $(this).find('.pt-accordion:first-of-type').find('input').prop('checked', true);
                
                var colHeight = introHeight + maxAccordion;
                var nextHeight = $(this).next().outerHeight();
                
                if (colHeight < nextHeight) {
                    $(this).next().css('max-height', colHeight);
                }
    
            });
        
        }
        
    }


    function mobileToggle() {

        var navContainer = document.querySelector('.mobile-nav');


        $('.menu-toggle').on('click', function() {
            var scrollPos = $(window).scrollTop();
            var headerHeight = $('.site-header').outerHeight();

            $('.site-container').addClass('fixed');
            if (scrollPos > 0) {
                $('.site-container').addClass('fixed--scroll');
                var siteOffset = scrollPos - headerHeight;
                $('.site-container').css('margin-top', -siteOffset);
                //$('.site-header').css('top', scrollPos);
            }
            $('.site-container').attr('aria-hidden', 'true');
            $('.site-container').attr('data-position', scrollPos);
            $('.mobile-nav').addClass('mobile-nav--visible');
            $('.mobile-nav').attr({
                'aria-hidden': 'false',
                'open': 'true',
                'tabindex': 0
            });
            $('.menu-close').focus();
            trapFocus(navContainer);
        });

        $('.menu-close').click(function() {
            var sitePos = $('.site-container').attr('data-position');

            $('.site-container').removeClass('fixed');
            if (sitePos > 0) {
                $('.site-container').removeClass('fixed--scroll');
                $('.site-container').css('padding-top', '0');
                $('.site-container').css('margin-top', '0');
            } else {
                sitePos = 0;
            }
            $('.site-container').attr('aria-hidden', 'false');
            //$('.site-header').css('top', '0');
            $('.mobile-nav').attr('aria-hidden', 'true');
            $('.mobile-nav').removeAttr('open tabindex');
            $('.menu-toggle').focus();
            $(window).scrollTop(sitePos);
            $('.mobile-nav').removeClass('mobile-nav--visible');
        });

        $('.menu-anchor').click(function() {
            var sitePos = $('.site-container').attr('data-position');

            $('.site-container').removeClass('fixed');
            if (sitePos > 0) {
                $('.site-container').removeClass('fixed--scroll');
                $('.site-container').css('padding-top', '0');
                $('.site-container').css('margin-top', '0');
            } else {
                sitePos = 0;
            }
            $('.site-container').attr('aria-hidden', 'false');
            //$('.site-header').css('top', '0');
            $('.mobile-nav').attr('aria-hidden', 'true');
            $('.mobile-nav').removeAttr('open tabindex');
            $('.menu-toggle').focus();
            $(window).scrollTop(sitePos);
            $('.mobile-nav').removeClass('mobile-nav--visible');
        });

        $('.submenu-toggle').click(function(e) {
            let parent = $(this).parent().parent('.menu-item-has-children');
            if ($(this).hasClass('rotated')) {
                $(this).removeClass('rotated');
                parent.children('.sub-menu').slideUp();
                $(this).focus();
                e.stopPropagation();
            } else {
                $(this).addClass('rotated');
                parent.children('.sub-menu').slideDown();
                parent.children('.sub-menu > li:first-of-type a').focus();
                e.stopPropagation();
            }
        });

    }


    function windowFix() {

        if ($(window).width() < 1100 && $('.mobile-nav').hasClass('mobile-nav--visible')) {
            $('.site-container').addClass('fixed');
        } else {
            $('.site-container').removeClass('fixed');
            $('.site-container').removeClass('fixed--scroll');
        }

    }

    $(document).ready(function() {
        mobileToggle();
        stickyHeader();
        accordionStuff();
    });

    var windowWidth = $(window).width();

    $(window).resize(function() {
        if ($(window).width() != windowWidth) {
            windowFix();
        }
        stickyHeader();
    });

    $(window).scroll(function() {
        stickyHeader();
    });

    $(window).on('resize scroll load', function() {
        $('.fade-in').each(function() {
            if ($(this).isOnScreen()) {
                $(this).addClass('fade-in--visible');
            }
        });
    });

});
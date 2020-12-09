
(function($) {

    $.fn.extend({

        jScroll: function(UserSettings) {

            var DefaultSettings = {
                ScrollDirection:'left',     // Scroll-Richtung (left,top)
                ScrollSpeed:500,            // Animationsgeschwindigkeit
                ScrollEndless:false,        // Animationsgeschwindigkeit
                PanelClass:'jScroll-Panel', // Panel CSS Class
                ArrowImage:'{{asset("img/arrows.png")}}',    // Spritepfad
                ArrowBGCol:'transparent',   // arrowbg
                ArrowWidth:20,              // Breite der Pfeile
                ArrowHeight:20,             // Höhe der Pfeile
                ArrowOpacity:.5,            // Opazität der Pfeile
                ArrowTop:'50%',             // Position mit Einheit (bri Pixel auch negative Werte möglich)
                ArrowLeft:0,                // Position (Pixel auch negative Werte möglich)
                ArrowRight:0,               // Position (Pixel auch negative Werte möglich)
                ArrowBottom:false,          // Position mit Einheit (bri Pixel auch negative Werte möglich)
                Moving:true,                // Settings.Moving aktivieren/deaktivieren
                MovingSize:20,              // Settings.Moving Pixelangabe
                CustomArrows:false,         // Eigene Klickflächen (Pfeile) benutzen
                CustomPrevId:false,         // Prev ID überschreiben
                CustomNextId:false          // Next ID überschreiben
            } /*! END DefaultSettings */

            var AnimateState = false,
                    ScrollEnd = 0,
                    ScrollSize = 0,
                    PanelSize = 0,
                    WrapperSize = 0;

            var Settings = $.extend(DefaultSettings,UserSettings);

            return $(this).each(function() {

                var obj = $(this),
                        Prefix = $(this).attr('id')+'-',
                        ScrollerWidth = $(this).width(),
                        ScrollerHeight = $(this).height();

                obj.methods = {

                    init: function() {

                        var CountPanels = $(obj).find('.'+Settings.PanelClass).length;

                        if(Settings.ScrollDirection == 'left') {

                            PanelSize = $(obj).find('.'+Settings.PanelClass).first().outerWidth();

                            WrapperSize = CountPanels * PanelSize;

                            ScrollSize = $(obj).width();

                            ScrollEnd = (WrapperSize - ScrollerWidth);
                        }
                        else {

                            PanelSize = $(obj).find('.'+Settings.PanelClass).first().outerHeight();

                            WrapperSize = CountPanels * PanelSize;

                            ScrollSize = $(obj).height();

                            ScrollEnd = (WrapperSize - ScrollerHeight);
                        }

                        var ScrollerCss = {
                            position:'relative',
                            left:0,
                            top:0,
                            overflow:'hidden',
                            width:ScrollerWidth,
                            height:ScrollerHeight
                        };

                        var ObjectWrapperCss = {
                            position:'relative',
                            left:0,
                            top:0,
                            overflow:'visible',
                            width:ScrollerWidth,
                            height:ScrollerHeight
                        };

                        if(Settings.ScrollDirection == 'left') {

                            var WrapperCss = {
                                position:'absolute',
                                left:0,
                                top:0,
                                width:WrapperSize,
                                height:ScrollerHeight
                            }

                            var ArrowPrevCss = {
                                position:'absolute',
                                cursor:'pointer',
                                display:'none',
                                zIndex:'5000',
                                left:Settings.ArrowLeft+'px',
                                top:Settings.ArrowTop,
                                bottom:Settings.ArrowBottom,
                                opacity:Settings.ArrowOpacity,
                                width:Settings.ArrowWidth+'px',
                                height:Settings.ArrowHeight+'px',
                                backgroundImage:'url('+Settings.ArrowImage+')',
                                backgroundPosition:'left top',
                                backgroundColor:Settings.ArrowBGCol,
                                marginTop:'-'+(Settings.ArrowHeight/2)+'px'
                            }

                            var ArrowNextCss = {
                                position:'absolute',
                                cursor:'pointer',
                                zIndex:'5000',
                                right:Settings.ArrowRight+'px',
                                top:Settings.ArrowTop,
                                bottom:Settings.ArrowBottom,
                                opacity:Settings.ArrowOpacity,
                                width:Settings.ArrowWidth+'px',
                                height:Settings.ArrowHeight+'px',
                                backgroundImage:'url('+Settings.ArrowImage+')',
                                backgroundPosition:'right top',
                                backgroundColor:Settings.ArrowBGCol,
                                marginTop:'-'+(Settings.ArrowHeight/2)+'px'
                            }
                        }
                        else {

                            var WrapperCss = {
                                position:'absolute',
                                left:0,
                                top:0,
                                width:ScrollerWidth,
                                height:WrapperSize
                            }

                            var ArrowPrevCss = {
                                position:'absolute',
                                cursor:'pointer',
                                display:'none',
                                zIndex:'5000',
                                top:Settings.ArrowTop,
                                bottom:Settings.ArrowBottom,
                                left:'50%',
                                opacity:Settings.ArrowOpacity,
                                width:Settings.ArrowWidth+'px',
                                height:Settings.ArrowHeight+'px',
                                backgroundImage:'url('+Settings.ArrowImage+')',
                                backgroundPosition:'left top',
                                backgroundColor:Settings.ArrowBGCol,
                                marginLeft:'-'+(Settings.ArrowWidth/2)+'px'
                            }

                            var ArrowNextCss = {
                                position:'absolute',
                                cursor:'pointer',
                                zIndex:'5000',
                                top:Settings.ArrowTop,
                                bottom:Settings.ArrowBottom,
                                left:'50%',
                                opacity:Settings.ArrowOpacity,
                                width:Settings.ArrowWidth+'px',
                                height:Settings.ArrowHeight+'px',
                                backgroundImage:'url('+Settings.ArrowImage+')',
                                backgroundPosition:'left bottom',
                                backgroundColor:Settings.ArrowBGCol,
                                marginLeft:'-'+(Settings.ArrowWidth/2)+'px'
                            }
                        }

                        if($(obj).css('position') == 'static') {

                            var ObjectCss = {
                                position:'relative',
                                top:0,
                                left:0
                            }
                        }
                        else {

                            var ObjectCss = {
                                position:$(obj).css('position'),
                                top:$(obj).css('top'),
                                left:$(obj).css('left'),
                                right:$(obj).css('right'),
                                bottom:$(obj).css('bottom')
                            }
                        }

                        var ObjectWrapperId = Prefix+'jScroll-Object-Wrapper';
                        var ScrollerId = Prefix+'jScroll';
                        var WrapperId = Prefix+'jScroll-Wrapper';
                        var ArrowPrevId = Prefix+'Scroll-Arrow-Prev';
                        var ArrowNextId = Prefix+'jScroll-Arrow-Next';

                        var ObjectWrapper = $('<div />',{id:ObjectWrapperId,css:ObjectWrapperCss});
                        var Scroller = $('<div />',{id:ScrollerId,css:ScrollerCss});
                        var Wrapper = $('<div />',{id:WrapperId,css:WrapperCss});
                        var ArrowPrev = $('<div />',{id:ArrowPrevId,css:ArrowPrevCss}).addClass('jScroll-Arrow');
                        var ArrowNext = $('<div />',{id:ArrowNextId,css:ArrowNextCss}).addClass('jScroll-Arrow');

                        $(obj).css(ObjectCss).wrapInner(Wrapper).wrapInner(Scroller);

                        if(Settings.ScrollDirection == 'left') {

                            if(WrapperSize > ScrollerWidth) {

                                if(Settings.CustomArrows == false) {

                                    $(obj).prepend(ArrowPrev).append(ArrowNext);
                                }
                            }
                        }
                        else {

                            if(WrapperSize > ScrollerHeight) {

                                if(Settings.CustomArrows == false) {

                                    $(obj).prepend(ArrowPrev).append(ArrowNext);
                                }
                            }
                        } /*! END adding arrows */

                        $(obj).wrapInner(ObjectWrapper);

                        var ObjectWrapper = document.getElementById(ObjectWrapperId);
                        var Scroller = document.getElementById(ScrollerId);
                        var Wrapper = document.getElementById(WrapperId);

                        if(Settings.CustomArrows == false) {

                            var ArrowPrev = document.getElementById(ArrowPrevId);
                        }
                        else {

                            var ArrowPrev = document.getElementById(Settings.CustomPrevId);
                        }

                        if(Settings.CustomArrows == false) {

                            var ArrowNext = document.getElementById(ArrowNextId);
                        }
                        else {

                            var ArrowNext = document.getElementById(Settings.CustomNextId);
                        }

                        $('.jScroll-Arrow').on('mouseenter mouseleave', function(e) {

                            if(e.type == 'mouseenter') {

                                $(this).css('opacity',1);
                            }
                            else {

                                $(this).css('opacity',Settings.ArrowOpacity);
                            }
                        });
                        /*! END arrow hover */

                        $(ArrowNext).on('click mouseenter', function(e) {

                            if(e.type == 'click') {

                                if(AnimateState == false) {

                                    if(Settings.ScrollDirection == 'left') {

                                        AnimateState = true;

                                        var PosXY = $(Wrapper).position();
                                        var Position = PosXY.left;

                                        if(Position < 0) Position = Position * -1;

                                        var Scrolling = WrapperSize-Position-ScrollSize;

                                        if(Scrolling > ScrollSize) Scrolling = ScrollSize;

                                        if(Settings.ScrollDirection == 'left') {

                                            if(Settings.ScrollEndless == true && $(Wrapper).css('left') == '-'+ScrollEnd+'px') {

                                                $(Wrapper).fadeOut((Settings.ScrollSpeed/2), function() {

                                                    $(this).css('left',ScrollSize).show().animate({'left':0}, Settings.ScrollSpeed, function() {

                                                        AnimateState = false;
                                                    });
                                                });
                                            }
                                            else {

                                                $(Wrapper).stop(true,true).animate({'left':'-='+Scrolling}, Settings.ScrollSpeed, function() {

                                                    $(ArrowPrev).fadeIn(300);

                                                    if($(Wrapper).css('left') == '-'+ScrollEnd+'px') {

                                                        if(Settings.ScrollEndless == false) $(ArrowNext).fadeOut(300);
                                                    }

                                                    AnimateState = false;
                                                });
                                            }
                                        }
                                    }
                                    else if(Settings.ScrollDirection == 'top') {

                                        AnimateState = true;

                                        var PosXY = $(Wrapper).position();
                                        var Position = PosXY.top;

                                        if(Position < 0) Position = Position * -1;

                                        var Scrolling = WrapperSize-Position-ScrollSize;

                                        if(Scrolling > ScrollSize) Scrolling = ScrollSize;

                                        if(Settings.ScrollDirection == 'top') {

                                            if(Settings.ScrollEndless == true && $(Wrapper).css('top') == '-'+ScrollEnd+'px') {

                                                $(Wrapper).fadeOut((Settings.ScrollSpeed/2), function() {

                                                    $(this).css('top',ScrollSize).show().animate({'top':0}, Settings.ScrollSpeed, function() {

                                                        AnimateState = false;
                                                    });
                                                });
                                            }
                                            else {

                                                $(Wrapper).stop(true,true).animate({'top':'-='+Scrolling}, Settings.ScrollSpeed, function() {

                                                    $(ArrowPrev).fadeIn(300);

                                                    if($(Wrapper).css('top') == '-'+ScrollEnd+'px') {

                                                        if(Settings.ScrollEndless == false) $(ArrowNext).fadeOut(300);
                                                    }

                                                    AnimateState = false;
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                            else {

                                if(Settings.Moving == true) {

                                    if(AnimateState == false) {

                                        AnimateState = true;

                                        if(Settings.ScrollDirection == 'left') {

                                            $(Wrapper).stop(true,true).animate({'left':'-='+Settings.MovingSize+'px'}, 200, function() {

                                                $(Wrapper).animate({'left':'+='+Settings.MovingSize+'px'}, 200, function() {

                                                    AnimateState = false;
                                                });
                                            });
                                        }
                                        else {

                                            $(Wrapper).stop(true,true).animate({'top':'-='+Settings.MovingSize+'px'}, 200, function() {

                                                $(Wrapper).animate({'top':'+='+Settings.MovingSize+'px'}, 200, function() {

                                                    AnimateState = false;
                                                });
                                            });
                                        }
                                    }
                                } /*! END Settings.Moving */
                            }
                        }); /*! END ArrowNext click mouseenter */

                        $(ArrowPrev).on('click mouseenter', function(e) {

                            if(e.type == 'click') {

                                if(AnimateState == false) {

                                    AnimateState = true;

                                    if(Settings.ScrollDirection == 'left') {

                                        var PosXY = $(Wrapper).position();
                                        var Position = PosXY.left;

                                        if(Position < 0) Position = Position * -1;

                                        var Scrolling = Position;

                                        if(Scrolling > ScrollSize) Scrolling = ScrollSize;

                                        if(Settings.ScrollDirection == 'left') {

                                            if(Settings.ScrollEndless == true && $(Wrapper).css('left') == '0px') {

                                                $(Wrapper).fadeOut((Settings.ScrollSpeed/2), function() {

                                                    $(this).css('left','-'+WrapperSize+'px').show().animate({'left':'+='+ScrollSize}, Settings.ScrollSpeed, function() {

                                                        AnimateState = false;
                                                    });
                                                });
                                            }
                                            else {

                                                $(Wrapper).stop(true,true).animate({'left':'+='+Scrolling}, Settings.ScrollSpeed, function() {

                                                    $(ArrowNext).fadeIn(300);

                                                    if($(Wrapper).css('left') == '0px') {

                                                        if(Settings.ScrollEndless == false) $(ArrowPrev).fadeOut(300);
                                                    }

                                                    AnimateState = false;
                                                });
                                            }
                                        }
                                    }
                                    else if(Settings.ScrollDirection == 'top') {

                                        var PosXY = $(Wrapper).position();
                                        var Position = PosXY.top;

                                        if(Position < 0) Position = Position * -1;

                                        var Scrolling = Position;

                                        if(Scrolling > ScrollSize) Scrolling = ScrollSize;

                                        if(Settings.ScrollDirection == 'top') {

                                            if(Settings.ScrollEndless == true && $(Wrapper).css('top') == '0px') {

                                                $(Wrapper).fadeOut((Settings.ScrollSpeed/2), function() {

                                                    $(this).css('top','-'+WrapperSize+'px').show().animate({'top':'+='+ScrollSize}, Settings.ScrollSpeed, function() {

                                                        AnimateState = false;
                                                    });
                                                });
                                            }
                                            else {

                                                $(Wrapper).stop(true,true).animate({'top':'+='+Scrolling}, Settings.ScrollSpeed, function() {

                                                    $(ArrowNext).fadeIn(300);

                                                        if($(Wrapper).css('top') == '0px') {

                                                            if(Settings.ScrollEndless == false) $(ArrowPrev).fadeOut(300);
                                                        }

                                                        AnimateState = false;
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                            else {

                                if(Settings.Moving == true) {

                                    if(AnimateState == false) {

                                        AnimateState = true;

                                        if(Settings.ScrollDirection == 'left') {

                                            $(Wrapper).stop(true,true).animate({'left':'+='+Settings.MovingSize+'px'}, 200, function() {

                                                $(Wrapper).animate({'left':'-='+Settings.MovingSize+'px'}, 200, function() {

                                                    AnimateState = false;
                                                });
                                            });
                                        }
                                        else {

                                            $(Wrapper).stop(true,true).animate({'top':'+='+Settings.MovingSize+'px'}, 200, function() {

                                                $(Wrapper).animate({'top':'-='+Settings.MovingSize+'px'}, 200, function() {

                                                    AnimateState = false;
                                                });
                                            });
                                        }
                                    }
                                } /*! END Settings.Moving */
                            }
                        }); /*! END ArrowPrev click mouseenter */
                    } /*! END init */
                } /*! END obj.methods */

                obj.methods.init();

            }); /*! END return function */
        } /*! END jScroll function */
    })
})(jQuery);
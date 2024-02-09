
( function( $ ) {
    "use strict";

    var CL_FRONT = window.CL_FRONT || {};
    window.CL_FRONT = CL_FRONT;


    CL_FRONT.components = CL_FRONT.components || {};
    CL_FRONT.helpers = CL_FRONT.helpers || {};

    /**
     * Main Site Init
     * 
     * @since 1.0.0
     */
    CL_FRONT.siteInit = function() {
        "use strict";

        this.defaultConfig();
        this.bindEvents();
    };

    /**
     * Init Default Variables
     * 
     * @since 1.0.0
     */
    CL_FRONT.defaultConfig = function() {
        "use strict";
        this.loader = false;
        this.config = {

            // Load dynamic scripts
            _loadedDependencies: [],
            _inQueue: {},

            // Default Config
            $window: $( window ),
            $document: $( document ),
            $windowWidth: $( window ).width(),
            $windowHeight: $( window ).height(),
            $windowTop:  typeof window.pageYOffset != 'undefined' ? window.pageYOffset: document.documentElement.scrollTop? document.documentElement.scrollTop: document.body.scrollTop? document.body.scrollTop:0,
            $containerWidth: 0,
            $containerOffsetLeft: 0,

            $html: $( 'html' ),
            $body: $( 'body' ),
            $viewport: $( '#viewport' ),
            $header: $( '.header_container' ),
            $headerTools: $('.header_container .extra_tools_wrapper'),
            $initSliders : {},
            $navigation: $( '.cl-header-default .menu-wrapper' ),
            $responsiveMenu: null,
            $content: $( '#content' ),
            $aside: $( '#secondary' ),
            $main: $( '#main' ),

            $pageLayout: 'fullwidth',
            $headerHeight: 0,
            $layoutModern: false,
            $asideTop: 0,
            $asideHeight: 0,
            $asideStickyOffset: 0,

            $isMobileScreen: false,
            $isTabletScreen: false,
            $isDesktopScreen: false,

            $isMobileDevice: false,
            $isMobileOrTabletDevice: false,

            $isSmoothScroll: false,
            $isCustomizer: false,

            $headerToolsInit: false,
            $headerToolsList: [],

            $cssInQueue: {},
        }


    };

    /**
     * Bind Events of site
     * 
     * @since 1.0.0
     * @version 1.0.2
     */
    CL_FRONT.bindEvents = function() {
        "use strict";

        var self = this;

        // Document Ready
        self.config.$document.ready( function() {
            self.updateConfig();
            console.log(window.elementorFrontend );
            if( typeof Loader !== "undefined" && codeless_global.preloader && codeless_global.preloader_type == 'heavy' && typeof window.elementorFrontend !== "undefined" && !window.elementorFrontend.config.environmentMode.edit )
                self.loader = new Loader(System);

            if( codeless_global.preloader && codeless_global.preloader_type == 'lighter' && typeof window.elementorFrontend !== "undefined" && !window.elementorFrontend.config.environmentMode.edit )
                Pace.on('change', progress => {
                    $('.pace').attr('data-progress-text', parseInt(progress) + '%');
                    if( progress < 70 )
                        $('.pace-activity').text('Preparing your experience..');
                    else
                        $('.pace-activity').text('Almost done..');
                });
                
                
            // Menu
            self.initMenuDropdown();
            self.initToolsDropdown();
            self.initMenuResponsive();
            self.initToolsResponsive();
            self.initHeaderStyles();
            self.initHeaderSticky();

            // Initialize Post Functionalities
            self.postInit();

            // Infinite Pagination
            self.paginationInfinite();

            self.isotopeBlogGrid();
            self.isotopePortfolioGrid();
 
            // Various sizes and positions fixes
            self.fixModernLayoutWidth();
            self.fixPostVideoHeight();
            self.fixCompatibilities();
            self.fixMegaMenuPosition();
            self.instaFeed();


           
            self.contactForm();
            self.shopInit();
            self.shopBtnClasses();

            

            self.scrollToTopButton();
            
            self.animations();
            
            self.wooQuantity();

            self.servicesToggles();

            self.scrollIndicator();
            self.remakeSearchHeader();

            if( window.matchMedia( '( min-width: 992px )' ).matches )
                self.customMouseCursor();

                

        } );

        // Window load
        self.config.$window.on( 'load', function() {
            self.postInstagram();
            self.livePhoto();
            self.shopBtnClasses();

            if( self.loader ){
                setTimeout(function(){
                    self.loader.complete();
                }, 0);
            }

            
            

        } );

        // Window Resize
        self.config.$window.resize( function() {
            self.updateDimensions();
            self.initMenuResponsive();
            self.initToolsResponsive();
            self.fixModernLayoutWidth();
            self.fixPostVideoHeight();
            self.stickySidebar();
            //self.stickyColumn();
            self.fixPageHeaderCenter();
            self.initHeaderSticky();

        } );

        // Window Scroll
        self.config.$window.scroll( function() {
            self.config.$windowTop =  typeof window.pageYOffset != 'undefined' ? window.pageYOffset: document.documentElement.scrollTop? document.documentElement.scrollTop: document.body.scrollTop? document.body.scrollTop:0;;
            self.stickySidebar();
            //self.stickyColumn();
        } );

        // Window on Orientation Change Tablets
        self.config.$window.on( 'orientationchange', function() {
            self.updateDimensions();
            self.initMenuResponsive();
            self.initToolsResponsive();
            self.fixPageHeaderCenter();
        } );



    };

    /**
     * Update Config Dom
     * 
     * @since 1.0.0
     */
    CL_FRONT.updateConfig = function() {
        this.config.$html = $( 'html' );
        this.config.$body = $( 'body' );
        this.config.$viewport = $( '#viewport' );
        this.config.$header = $( '.cl-header-default' );
        this.config.$navigation = $( '.cl-header-default .menu-wrapper' );
        this.config.$headerTools = $('.header_container .extra_tools_wrapper');
        this.config.$content = $( '#content' );
        this.config.$aside = $( '#secondary' );
        this.config.$main = $( '#main' );

        this.config.$pageLayout = this.config.$content.hasClass( 'cl-layout-left_sidebar' ) ? 'left_sidebar' :
            this.config.$content.hasClass( 'cl-layout-right_sidebar' ) ? 'right_sidebar' :
            this.config.$content.hasClass( 'cl-layout-dual' ) ? 'dual_sidebar' : 'fullwidth';

        if ( this.config.$content.hasClass( 'cl-layout-modern' ) )
            this.config.$layoutModern = true;

        this.config.$isMobileDevice = this.mobileDeviceCheck();
        this.config.$isMobileOrTabletDevice = this.mobileOrTabletDeviceCheck();

        this.config.$isSmoothScroll = this.config.$body.hasClass( 'cl-smoothscroll' ) ? true : false;

        if( $('.cl_counter').length > 0 )
            this.preloadOdometer();

        this.updateDimensions();
    };

    /**
     * Check if page is loaded from mobile
     * 
     * @since 1.0.0
     */
    CL_FRONT.mobileDeviceCheck = function() {
        var check = false;
        ( function( a ) {
            if ( /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test( a ) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test( a.substr( 0, 4 ) ) ) check = true;
        } )( navigator.userAgent || navigator.vendor || window.opera );
        return check;
    }


    CL_FRONT.remakeSearchHeader = function(){
        "use strict";

        if( $( '.search_field_2' ).length ){
            $( '.search_field_2' ).on( 'click', function(){
                if( !$( this ).hasClass('open-field') )
                    $(this).addClass('open-field');
            } );

            $( '.search_field_2 i' ).on( 'click', function(){
                if( $( '.search_field_2' ).hasClass('open-field') ){
                    $( '.search_field_2 form' )[0].submit();
                }
            } );

            $( 'body' ).on( 'click', function(e){

                if( $(e.target).is( $( '.search_field_2' ) ) || $(e.target).closest( '.search_field_2' ).length )
                    return;

                if( $( '.search_field_2' ).hasClass('open-field') )
                    $( '.search_field_2' ).removeClass( 'open-field' );
            } );

        }

        if( $('.search_field_circle').length ){
            $( '.search_field_circle' ).on( 'click', function(){
                if( !$( this ).hasClass('open-field') )
                    $(this).addClass('open-field');
            } );

            $( '.search_field_circle i' ).on( 'click', function(){
                if( $( '.search_field_circle' ).hasClass('open-field') ){
                    $( '.search_field_circle form' )[0].submit();
                }
            } );

            $( 'body' ).on( 'click', function(e){

                if( $(e.target).is( $( '.search_field_circle' ) ) || $(e.target).closest( '.search_field_circle' ).length )
                    return;

                if( $( '.search_field_circle' ).hasClass('open-field') )
                    $( '.search_field_circle' ).removeClass( 'open-field' );
            } );
        }
    }

    /**
     * Check if page is loaded from mobile or tablet
     * 
     * @since 1.0.0
     */
    CL_FRONT.mobileOrTabletDeviceCheck = function() {
        var check = false;
        ( function( a ) {
            if ( /(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test( a ) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test( a.substr( 0, 4 ) ) ) check = true;
        } )( navigator.userAgent || navigator.vendor || window.opera );
        return check;
    }


    /**
     * Update Dimension of page, used on screen resize
     * 
     * @since 1.0.0
     */
    CL_FRONT.updateDimensions = function() {
        this.config.$windowWidth = $( window ).width();
        this.config.$windowHeight = $( window ).height();

        if ( window.matchMedia ) {
            this.config.$isMobileScreen = window.matchMedia( '( max-width: 767px )' ).matches;
            this.config.$isTabletScreen = window.matchMedia( '( min-width: 768px ) and (max-width: 991px)' ).matches;
            this.config.$isDesktopScreen = window.matchMedia( '( min-width: 992px )' ).matches;
        } else {
            this.config.$isMobileScreen = this.config.$windowWidth <= 768;
            this.config.$isTabletScreen = this.config.$windowWidth > 768 && this.config.$windowWidth <= 991;
            this.config.$isDesktopScreen = this.config.$windowWidth > 992;
        }

        this.config.$containerWidth =  this.config.$header.hasClass('header-top') ? this.config.$header.find( '.header-row-inner' ).width() : this.config.$content.find( '.container' ).width();
        if( this.config.$header.hasClass('header-top') ){
            this.config.$containerOffsetLeft = this.config.$header.find( '.c-left.header-col' ).length > 0 ? this.config.$header.find( '.c-left.header-col' ).offset().left : this.config.$content.find( '.container' ).offset().left - 15;
        }else
            this.config.$containerOffsetLeft = 0;

        
        var container_offset = this.config.$content.find( '.container' ).length > 0 ?  this.config.$content.find( '.container' ).offset().left : 0
        this.config.$containerOffsetLeft = this.config.$header.hasClass('header-top') ? this.config.$header.find( '.c-left.header-col' ).offset().left : container_offset - 15;
        this.config.$headerHeight = this.config.$header.height();
      
        
        
    }


    CL_FRONT.fixCompatibilities = function(){
        if( bowser.msie && bowser.version <= 9 ){
            CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'jquery.requestAnimationFrame.js'], function(){

            });

            CL_FRONT.config.$html.addClass('no-cssanimations');
        }
    }

    /**
     * Initialize Menu in Responsive
     * 
     * @since 1.0.0
     */

    CL_FRONT.initMenuResponsive = function() {
        "use strict";
        var self = this;

        if( this.config.$windowWidth <= 991 && this.config.$responsiveMenu === null ){

            

            if( this.config.$navigation.closest('.cl-fullscreen-overlay-menu').length == 0 )
                this.config.$navigation.addClass('cl-hide-on-mobile');
            else{
                this.config.$navigation.addClass('vertical-menu').addClass('cl-mobile-menu');
                return;
            }

            this.config.$responsiveMenu = this.config.$navigation.clone().appendTo(this.config.$header);
            this.config.$responsiveMenu.removeClass( 'cl-hide-on-mobile' ).addClass( 'cl-mobile-menu' ).css('display', 'none');

            $( '.cl-mobile-menu-button' ).on( 'click', function( ){
                var button = $(this);
                button.toggleClass( 'open' );
                self.config.$responsiveMenu.slideToggle('200');         
                //CL_FRONT.animations( self.config.$responsiveMenu , true );

            } );

            $( '.menu li.hasSubMenu > a', this.config.$responsiveMenu ).on( 'click', function( e ){
                var li = $(this).parent();
                e.preventDefault();
                li.toggleClass('open');
                li.parent().find('li').not(li).removeClass('open');             
                li.children( '.sub-menu, .codeless_custom_menu_mega_menu' ).slideToggle('300');

            } );

            

        }else{

            if( this.config.$responsiveMenu != null )
                this.config.$responsiveMenu.addClass('cl-hide-not-mobile');

            if( this.config.$navigation.closest('.cl-fullscreen-overlay-menu').length > 0 ){
                this.config.$navigation.removeClass('cl-mobile-menu');
                return;
            }

        }

        if( this.config.$windowWidth > 991 )
            this.config.$header.removeClass('cl-responsive-header');
        else
            this.config.$header.addClass('cl-responsive-header');
    }

    CL_FRONT.verticalMenuInit = function(){
        "use strict";
        const nav_items = this.config.$navigation[0].querySelectorAll('li > a');
        nav_items.forEach( function(item){ 
            const parentLI = item.parentElement;
            const parentUL = parentLI.parentElement;
          
            if( parentLI.querySelector(':scope > ul') ){
                item.addEventListener('click', function(event){
                    event.preventDefault();

                    if( parentLI.classList.contains( 'showDropdown' ) ){
                        slideUp(parentLI);  
                    }else{
                        parentUL.querySelectorAll( ':scope > li' ).forEach(function(i){
                            if( ! i.isEqualNode( parentLI ) )
                                slideUp(i);
                        });
                        slideDown(parentLI);
                    }
                });
            }

        });

        const slideDown = function( li ){
            let height = 0;
            li.classList.add('showDropdown');

            li.querySelectorAll(':scope > ul > li').forEach( function(i){
                height += i.offsetHeight;
            } );

            li.querySelector('ul').style.height = height + 'px';
            setTimeout(function(){
                li.querySelector('ul').style.height = 'auto';
            }, 300);
        };

        const slideUp = function( li ){
            if( ! li.querySelector('ul') )
                return;

            let height = li.querySelector('ul').offsetHeight;
            li.querySelector('ul').style.height = height + 'px';

            setTimeout( function(){
                li.querySelector('ul').style.height = 0;
            }, 10);

            setTimeout(function(){
                li.classList.remove('showDropdown');
            }, 300);

            const inner = li.querySelectorAll('ul > li');
            if( inner ){
                inner.forEach(slideUp);
            }
        }
    }


    CL_FRONT.scrollToTopButton = function(){
        "use strict";

        $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });
        
        //Click event to scroll to top
        $('.scrollToTop').on('click',function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });
    }


    /**
     * This function init all related functions of a specific header or menu style 
     *
     * @since 1.0.0
     */
    CL_FRONT.initHeaderStyles = CL_FRONT.init_cl_header_menu =  function(){
        "use strict";

        // Hamburger - overlay
        if( $('.cl-overlay-menu').length > 0 ){
            CL_FRONT.overlayMenu();
        }else if( this.config.$header.hasClass('header-left') || this.config.$header.hasClass('header-right') ) {
            CL_FRONT.initHeaderSide();
        }

        if( $('.cl-overlay-menu').length == 0 )
            setTimeout(function(){
                CL_FRONT.animations( $('#navigation'), true );
            }, 300);
    },


    CL_FRONT.initHeaderSide = function(){
        
        
    },


    /**
     * Init Header Sticky
     *
     * @since 1.0.0
     * @version 1.0.8
     */
    CL_FRONT.initHeaderSticky = function(){
        "use strict";

        if( ! this.config.$header.hasClass( 'cl-header-sticky' ) )
            return;

        var is_active = false;
        

        if( !CL_FRONT.config.$header.hasClass('cl-transparent') && CL_FRONT.config.$isDesktopScreen ){

            var header_height = CL_FRONT.config.$header.height();
            

        }else{

            CL_FRONT.config.$main.css({

                 marginTop: '0px',

            });
        }

        var onScroll = function(){

            if( ! CL_FRONT.config.$header.hasClass( 'cl-header-sticky' ) )
                return;

            var stickyContentColor = CL_FRONT.helpers.parseData( CL_FRONT.config.$header.attr('data-sticky-content-color'), 'dark' );
            var site_header = CL_FRONT.config.$body.hasClass('cl-header-light') ? 'light' : 'dark';

            if( CL_FRONT.config.$windowTop > 500 && ! is_active ){
                
                

                setTimeout(function(){
                    CL_FRONT.config.$header.addClass('cl-header-sticky-prepare');
                }, 100);
                

                if( stickyContentColor == 'dark' )
                    CL_FRONT.config.$header.removeClass('cl-header-light');
                if( stickyContentColor == 'light' && site_header == 'dark' )
                    CL_FRONT.config.$header.addClass('cl-header-light');

                
                setTimeout( function(){

                   CL_FRONT.config.$header.addClass('cl-header-sticky-ready');  

                }, 400);
                
                setTimeout( function(){

                   CL_FRONT.config.$header.addClass('cl-header-sticky-active');  
                   is_active = true;  

                }, 600); 

            }else if( CL_FRONT.config.$windowTop <= 500 && is_active ) {

                CL_FRONT.config.$header.removeClass('cl-header-sticky-active');

                if( site_header == 'dark' ){
                    CL_FRONT.config.$header.removeClass('cl-header-light');

                }
                else if( site_header == 'light' && ! CL_FRONT.config.$header.hasClass('cl-header-light') )
                    CL_FRONT.config.$header.addClass('cl-header-light');

                setTimeout( function(){

                   CL_FRONT.config.$header.removeClass('cl-header-sticky-ready'); 

                }, 100);

                setTimeout( function(){
                    CL_FRONT.config.$header.removeClass('cl-header-sticky-prepare');    
                   is_active = false;
               }, 100);
            }
        }

        window.addEventListener('scroll', onScroll, false);
    },


    /**
     * Bind hamburger click and open overlay
     *
     * @since 1.0.0
     * @version 1.0.6
     */
    CL_FRONT.overlayMenu = function(){
        "use strict";

        

        $('.cl-hamburger-menu').on( 'click', function(e){
            e.preventDefault();


            CL_FRONT.config.$body.addClass('cl-prepare-fullscreen-header');

            if( $('.cl-hamburger-menu').hasClass( 'open' ) ){
                setTimeout( function(){
                    $('.cl-hamburger-menu').removeClass( 'open' );
                    CL_FRONT.config.$body.removeClass('cl-actived-fullscreen-header');
                    CL_FRONT.config.$body.removeClass('cl-prepare-fullscreen-header');
                }, 500);
            }else{
                setTimeout(function(){
                    $('.cl-hamburger-menu').addClass( 'open' );
                    CL_FRONT.config.$body.addClass('cl-actived-fullscreen-header');
                }, 50);
            }

            setTimeout(function(){
                $('.cl-overlay-menu').toggleClass( 'open' );
            }, 50);

            if( $('#navigation .animate_on_visible').length > 0 && $('.cl-overlay-menu').hasClass( 'open' ) ){
                setTimeout(function(){
                    CL_FRONT.animations( $('#navigation'), true );
                }, 500);
            }
            
            if( $('#navigation .animate_on_visible').length > 0 && ! $('.cl-overlay-menu').hasClass( 'open' ) ){
                setTimeout(function(){
                    $('#navigation .animate_on_visible').removeClass('start_animation');
                }, 500); 
            }

        } );
        
    },  


    CL_FRONT.offCanvasMenu = function(){

        CL_FRONT.config.$body.addClass('cl-offcanvas-menu-style');

        $('.cl-hamburger-menu').on( 'click', function(e){
            e.preventDefault();



            if( $('.cl-hamburger-menu').hasClass( 'open' ) ){
                setTimeout( function(){
                    $('.cl-hamburger-menu').removeClass( 'open' );
                    CL_FRONT.config.$body.removeClass('cl-show-offcanvas-menu');
                }, 500);
            }else{
                $('.cl-hamburger-menu').addClass( 'open' );
                CL_FRONT.config.$body.addClass('cl-show-offcanvas-menu');
            }

            if( $('#navigation .animate_on_visible').length > 0 && $('.cl-offcanvas-menu').hasClass( 'open' ) ){
                setTimeout(function(){
                    CL_FRONT.animations( $('#navigation'), true );
                }, 500);
            }
            
            if( $('#navigation .animate_on_visible').length > 0 && ! $('.cl-offcanvas-menu').hasClass( 'open' ) ){
                setTimeout(function(){
                    $('#navigation .animate_on_visible').removeClass('start_animation');
                }, 500); 
            }

        } );
    },




     /**
     * Insta Feed
     * 
     * @since 1.0.0
     */
    CL_FRONT.instaFeed = function(){
        "use strict";
       $('.cl-instafeed.cl-carousel').each(function(){
            var $instafeed = $(this);
            CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'instafeed.min.js' ], function() {

                var $token = $instafeed.data('token'),
                    $userid = $instafeed.data('userid');

                var userFeed = new Instafeed({
                    get: 'user',
                    userId: $userid,
                    accessToken: $token,
                    target: $instafeed[0],
                    template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>',
                    resolution: 'low_resolution',
                    after: function() {
                        var $data = {

                            responsive: {
                                0: {
                                    items: 1
                                },
                                480: {
                                    items: 2
                                },
                                768: {
                                    items: 3 
                                },
                                992: {
                                    items: 6
                                }
                            },

                            items: 6,
                            slideBy: 1,
                            smartSpeed: 600,
                            center: true,
                            loop:true,
                            margin:10,
                            

                        };

                        CL_FRONT.components.Carousel( $instafeed, $data, function(owl, el){
                            owl.on('resized.owl.carousel', function(event){
                                CL_FRONT.animations( el.find( '.owl-item.active' ), true ); 
                            });          
                        }); 
                    }
                });
                userFeed.run();

                

            });
        });


        $('.widget .cl-instafeed').each(function(){
            var $instafeed = $(this);

            CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'instafeed.min.js' ], function() {

                var $token = $instafeed.data('token'),
                $userid = $instafeed.data('userid');

                var userFeed = new Instafeed({
                        get: 'user',
                        userId: $userid,
                        accessToken: $token,
                        limit: 6,
                        target: $instafeed[0],
                        template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>',
                        resolution: 'low_resolution',
                        
                    });

                userFeed.run();

            });
        });


        $('.cl_instagram .cl-instafeed').each(function(){
            var $instafeed = $(this);

            CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'instafeed.min.js' ], function() {

                var $token = $instafeed.data('token'),
                $userid = $instafeed.data('userid');

                var userFeed = new Instafeed({
                        get: 'user',
                        userId: $userid,
                        accessToken: $token,
                        limit: 8,
                        target: $instafeed[0],
                        template: '<a href="{{link}}" target="_blank"><img src="{{image}}" /></a>',
                        resolution: 'low_resolution',
                        
                    });
                
                userFeed.run();


            });
        });
    };


    /**
     * Initialize Post
     * 
     * @since 1.0.0
     */
    CL_FRONT.postInit = function( $el ) {
        "use strict";

        this.postSwiper();
        this.postShareButtons( $el );
    };

    CL_FRONT.livePhoto = function(){
        "use strict";
        if($('#live_photo').length > 0){

            var myNewPlayer = LivePhotosKit.Player();
            // A Player built from a pre-existing element:
            LivePhotosKit.Player(document.getElementById('live_photo'));

        }
    }

    CL_FRONT.postInstagram = function() {
        $( '.entry-video .instagram-media' ).contents().find( '.EmbedCaption' ).remove();
        $( '.entry-video .instagram-media' ).contents().find( '.EmbedFooter' ).remove();
    }

    /**
     * Fix sidebar background Width
     * 
     * @since 1.0.0
     */
    CL_FRONT.fixModernLayoutWidth = function() {
        "use strict";

        if ( this.config.$layoutModern ) {

            if ( this.config.$pageLayout == 'right_sidebar' ) {
                var distance = this.config.$windowWidth - ( this.config.$aside.offset().left );
                $( '.cl-layout-modern-bg' ).width( ( distance + 10 ) + 'px' );
            }

            if ( this.config.$pageLayout == 'left_sidebar' ) {
                var distance = this.config.$aside.offset().left + this.config.$aside.width();
                $( '.cl-layout-modern-bg' ).width( ( distance + 35 ) + 'px' );
            }
        }
    }


    /**
     * Fix Height of custom Masonry Size
     * 
     * @since 1.0.0
     */
    CL_FRONT.fixPostMasonryHeight = function( $element ){
        "use strict";

        if( $( $element ).length > 0 ){
            var $wide = $( '.cl-msn-size-wide', $element ),
                $height = $( '.cl-msn-size-small', $element ).height() - 20; 

            $wide.css( { height: $height + 'px' } );
            $( 'img', $wide ).css( { height: $height + 'px' } );

        }
    }

    /**
     * Fix Height of custom Masonry Size
     * 
     * @since 1.0.0
     */
    CL_FRONT.fixPortfolioMasonryHeight = function( $element ){
        "use strict";

        if( $( $element ).length > 0 ){

            var $wide = $( '.cl-msn-size-wide', $element),
                $height = $( '.grid-holder', $wide ).height(),
                padd = typeof $wide.css('padding') !== 'undefined' ? $wide.css('padding') : '0px',

                padding = parseInt(padd.replace("px", "")) * 2;

            $wide.css( { height: $height + padding + 'px' } );

        }
    }




   

    /**
     * Post Share Buttons SHOW/HIDE
     * 
     * @since 1.0.0
     */
    CL_FRONT.postShareButtons = function( $el ) {
        "use strict";

        var $elements = $( '.entry-tool-share' );

        if ( typeof $el !== "undefined" )
            $elements = $( '.entry-tool-share', $el );

        if ( $elements.length ) {

            // Open share-buttons on button click
            $elements.each( function( i ) {
                var $element = $( this );
                $( '.show-share-buttons', $element ).on( 'click', function( e ) {

                    e.stopPropagation();
                    e.preventDefault();

                    if ( $( '.share-buttons', $element ).hasClass( 'hidden' ) ) {
                        $( '.share-buttons', $element ).removeClass( 'hidden' );
                        setTimeout( function() {
                            $( '.share-buttons', $element ).addClass( 'show' );
                        }, 150 );
                    } else {
                        $( '.share-buttons', $element ).removeClass( 'show' );
                        setTimeout( function() {
                            $( '.share-buttons', $element ).addClass( 'hidden' );
                        }, 150 );
                    }

                } );
            } );
        }
    };



    /**
     * Post Slider Configuration and load
     * Used only for post slider
     * 
     * @since 1.0.0
     */
    CL_FRONT.postSwiper = function( $el ) {
        "use strict";

        var $elements = $el || $( '.cl-post-swiper-slider' );
        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
                var name = 'swiper.min.js';
                if( bowser.msie && bowser.version <= 9 )
                    name = 'swiper.old.min.js';

                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + name ], function() {
                    var slider = new Swiper( '.cl-post-swiper-slider', codeless_global.postSwiperOptions )

                } );

            } );
        }

    };


    CL_FRONT.servicesToggles = function(){
        "use strict";

        $( '.services_toggles' ).each(function(){
            var $row = $(this);
            $('.elementor-column', $row).on('mouseenter', function(e){
                e.preventDefault();
                var $column = $(this);
                $row.find('.elementor-column').removeClass('service_toggle_active');
                $column.addClass('service_toggle_active');
            });
        });
    };


    /**
     * Slider Configuration and load
     *
     * 
     * @since 1.0.0
     */
    CL_FRONT.codelessSlider = function( $el ) {
        "use strict";

        var $elements = $el || $( '.cl_slider' );
        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
                var name = 'swiper.min.js';
                if( bowser.msie && bowser.version <= 9 )
                    name = 'swiper.old.min.js';

                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + name ], function() {
                    
                    var animateSlide = function( $slide ){

                        if( $slide.hasClass('cl-slide-animation') && ! $slide.hasClass('animation--none') )
                            $slide.addClass('start_animation');
                    };

                    var opts = {

                        on: {
                            init: function(){
                                if( CL_FRONT.config.$header.hasClass('cl-transparent') ){
                                    if( ! CL_FRONT.config.$header.hasClass('cl-header-light') ){
                                        $('.cl-slider-nav', $element).removeClass('swiper-button-white');
                                        $('.swiper-pagination', $element).addClass('cl-dark-pagination');
                                    }
                                    else{
                                        $('.swiper-pagination', $element).removeClass('cl-dark-pagination');
                                        $('.cl-slider-nav', $element).addClass('swiper-button-white');
                                    }
                                }
                                animateSlide($(this.slides[this.activeIndex]));
                                CL_FRONT.animations($(this.slides[this.activeIndex]), true);

                                var next_url = $(this.slides[this.activeIndex]).next().find('[data-thumb]').attr('data-thumb');
                                if( next_url != 'undefined' )
                                    $('.swiper-button-next', $element).find('.image').css('background-image', 'url('+next_url+')');
                            },

                            transitionStart: function(){
                                var swiper = this;
                                setTimeout(function(){
                                    if( CL_FRONT.config.$header.hasClass('cl-transparent') ){
                                    
                                        CL_FRONT.helpers.changeHeaderColor( $(swiper.slides[swiper.activeIndex]) );

                                        setTimeout(function(){
                                            if( ! CL_FRONT.config.$header.hasClass('cl-header-light') ){
                                                $('.cl-slider-nav', $element).removeClass('swiper-button-white');
                                                $('.swiper-pagination', $element).addClass('cl-dark-pagination');
                                            }
                                            else{
                                                $('.swiper-pagination', $element).removeClass('cl-dark-pagination');
                                                $('.cl-slider-nav', $element).addClass('swiper-button-white');
                                            }
                                        }, 50 );
                                    
                                    }
                                    animateSlide($(swiper.slides[swiper.activeIndex]));
                                    CL_FRONT.animations($(swiper.slides[swiper.activeIndex]), true);
                                

                                }, 300);
                            },

                            slideChange: function(){
                                $(this.slides[this.activeIndex]).removeClass('start_animation');
                                $(this.slides[this.activeIndex]).find('.start_animation:not(.bg-layer)').removeClass('start_animation');

                                var next_url = $(this.slides[this.activeIndex]).next().find('[data-thumb]').attr('data-thumb');
                                if( next_url != 'undefined' )
                                    $('.swiper-button-next', $element).find('.image').css('background-image', 'url('+next_url+')');

                                var prev_url = $(this.slides[this.activeIndex]).prev().find('[data-thumb]').attr('data-thumb');
                                if( prev_url != 'undefined' )
                                    $('.swiper-button-prev', $element).find('.image').css('background-image', 'url('+prev_url+')');
                            },
                        },

                        
                        parallax: true,
                        
                        speed: parseInt(CL_FRONT.helpers.parseData( $element.data('speed'), 300 )),
                        direction: CL_FRONT.helpers.parseData( $element.data('direction'), 'horizontal' ),
                        autoplay: codeless_global.is_customize_preview ? false : parseInt(CL_FRONT.helpers.parseData( $element.data('clautoplay'), 0 )),
                        loop: parseInt( CL_FRONT.helpers.parseData( $element.data('loop'), false ) ),
                        mousewheelControl: parseInt( CL_FRONT.helpers.parseData( $element.data('mousewheel'), false ) ),
                        freeMode:true
                    };

                    if( parseInt( CL_FRONT.helpers.parseData( $element.data('mousewheel'), false ) ) )
                        opts['mousewheel'] = {
                            invert: false,
                            sensitivity: 0.5
                        }; 
                    console.log(opts);
                    var cl_effect = {

                        effect: CL_FRONT.helpers.parseData( $element.data('effect'), 'fade' )

                    };

                    if( CL_FRONT.helpers.parseData( $element.data('effect'), 'fade' ) == 'interleave' && CL_FRONT.config.$windowWidth > 992 ){
                        var interleaveOffset = -.5;

                        if( CL_FRONT.helpers.parseData( $element.data('direction'), 'horizontal' ) == 'horizontal' ){

                            cl_effect = {

                                onProgress: function(swiper, progress){
            
                                    for (var i = 0; i < swiper.slides.length; i++){
                                      
                                      var slide = swiper.slides[i];
                                      var translate, innerTranslate;
                                      progress = slide.progress;
                                            
                                      if (progress > 0) {
                                        translate = progress * swiper.width;
                                        innerTranslate = translate * interleaveOffset;        
                                      }
                                      else {        
                                        innerTranslate = Math.abs( progress * swiper.width ) * interleaveOffset;
                                        translate = 0;
                                      }
                                            

                                      $(slide).css({
                                        transform: 'translate3d(' + translate + 'px,0,0)'
                                      });

                                      $(slide).find('.cl-row > .bg-layer').css({
                                        transform: 'translate3d(' + innerTranslate + 'px,0,0)'
                                      });
                                    }
                                },

                                onTouchStart: function(swiper){
                                    for (var i = 0; i < swiper.slides.length; i++){
                                      $(swiper.slides[i]).css({ transition: '' });
                                    }
                                },

                                onSetTransition: function(swiper, speed) {
                                    for (var i = 0; i < swiper.slides.length; i++){
                                      $(swiper.slides[i])
                                        .find('.cl-row > .bg-layer')
                                        .andSelf()
                                        .css({ transition: speed + 'ms' });
                                    }
                                }

                            };

                        }else{

                            cl_effect = {

                                onProgress: function(swiper, progress){
                                    
                                    for (var i = 0; i < swiper.slides.length; i++){
                                       
                                      var slide = swiper.slides[i];
                                      var translate, innerTranslate;
                                      progress = slide.progress;
                                            
                                      if (progress > 0) {
                                        translate = progress * swiper.height;
                                        innerTranslate = translate * interleaveOffset;        
                                      }
                                      else {        
                                        innerTranslate = Math.abs( progress * swiper.height ) * interleaveOffset;
                                        translate = 0;
                                      }
                                                

                                      $(slide).css({
                                        transform: 'translate3d(0,' + translate + 'px, 0)'
                                      });

                                      
                                    

                                      $(slide).find('.cl-row').css({
                                        transform: 'translate3d(0,' + innerTranslate + 'px, 0)'
                                      });
                                      
                                    }
                                },

                                onTouchStart: function(swiper){
                                    for (var i = 0; i < swiper.slides.length; i++){
                                      $(swiper.slides[i]).css({ transition: '' });
                                    }
                                },

                                onSetTransition: function(swiper, speed) {
                                    for (var i = 0; i < swiper.slides.length; i++){

                                      $(swiper.slides[i])
                                        .find('.cl-row')
                                        .andSelf()
                                        .css({ transition: speed + 'ms' });
                                    }
                                }

                            };

                        }
                       
                    }


                    if( CL_FRONT.helpers.parseData( $element.data('effect'), 'fade' ) == 'softscale'){
                        cl_effect = {

                
                            onSetTransition: function (s, duration) {
                                s.slides.transition(duration);
                               
                                if (s.params.virtualTranslate && duration !== 0) {
                                    var eventTriggered = false;
                                    s.slides.transitionEnd(function () {
                                        if (eventTriggered) return;
                                        if (!s) return;
                                        eventTriggered = true;
                                        s.animating = false;
                                        var triggerEvents = ['webkitTransitionEnd', 'transitionend', 'oTransitionEnd', 'MSTransitionEnd', 'msTransitionEnd'];
                                        for (var i = 0; i < triggerEvents.length; i++) {
                                            s.wrapper.trigger(triggerEvents[i]);
                                        }
                                    });
                                }
                            },

                            onSlideChangeStart: function(swiper){
                                var active = swiper.activeIndex,
                                    prev = swiper.previousIndex;
                              

                                if( ! $( swiper.slides[prev] ).find('.cl-row').hasClass('navOutNext') )
                                    $( swiper.slides[prev] ).find('.cl-row').addClass('navOutNext');

                                if( $( swiper.slides[active] ).find('.cl-row').hasClass('navInNext') )
                                    $( swiper.slides[active] ).find('.cl-row').removeClass('navInNext');
                                
                                $( swiper.slides[active] ).find('.cl-row').addClass('navInNext');

                                setTimeout(function(){
                                    $( swiper.slides[prev] ).find('.cl-row').removeClass('navOutNext');
                                    $( swiper.slides[active] ).find('.cl-row').removeClass('navInNext');
                                }, 1500);
                            }, 


                            effect: 'softscale',
                            virtualTranslate: true,
                            slidesPerView : 1,
                            watchSlidesProgress : true,
                            loop:false,
                            parallax: false,
                            spaceBetween : 0,

                        };
                    }

                    opts = $.extend(opts, cl_effect);



                    if( parseInt(CL_FRONT.helpers.parseData( $element.data('pagination'), 1 ) ) ){
                        opts['pagination'] = '.swiper-pagination';
                        opts['paginationClickable'] = true;
                    }
                    
                    if( parseInt(CL_FRONT.helpers.parseData( $element.data('navigation'), 1 ) ) ){
                        opts['navigation'] = {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        };
                    } 

                    if( parseInt(CL_FRONT.helpers.parseData( $element.data('anchors'), 0 ) ) ){
                        opts['paginationBulletRender'] = function (swiper, index, className) {
                            var anchor = $(swiper.slides[index]).find('[data-anchor]').data('anchor');
                            return '<span class="' + className + '" data-label="'+ anchor +'"></span>';
                        }
                    } 


                    
                    var actualInstance = new Swiper( '.cl_slider', opts );
                    CL_FRONT.config.$initSliders[$element.attr('id')] = actualInstance;
                    

                    var animateOnScroll = function(){
                        var startPoint = $element.offset().top + ( $element.height() * 0.44 );
                       
                        if( CL_FRONT.config.$windowTop >= startPoint && ! $element.hasClass('cl-animateScroll') )
                            $element.addClass('cl-animateScroll');
                        else if( $element.hasClass('cl-animateScroll') && CL_FRONT.config.$windowTop < startPoint)
                            $element.removeClass('cl-animateScroll')

                    };
                    setTimeout(function(){
                        $(window).on('scroll', function(){  

                            if( CL_FRONT.helpers.parseData( $element.data('direction'), 'horizontal' ) == 'vertical' && CL_FRONT.config.$windowWidth < 992 )
                                return;
                            animateOnScroll();
                         });

                    }, 100);

                    var destroyed = false;

                    var verticalSliderResponsive = function(){
                        if( CL_FRONT.helpers.parseData( $element.data('direction'), 'horizontal' ) != 'vertical' || ! $element.hasClass('cl_slider-responsive-plain') )
                            return;
                   
                        if( CL_FRONT.config.$windowWidth > 992 ){
                            
                            if( destroyed ){
                                actualInstance = new Swiper( '.cl_slider', opts );
                                CL_FRONT.config.$initSliders[$element.attr('id')] = actualInstance;
                            }

                            return;
                        }
                        
                        if( ! destroyed ){
                            actualInstance.destroy(false);
                            destroyed = true;
                            CL_FRONT.animations($element, true);
                        }
                        
                    }

                    

                    verticalSliderResponsive();

                    $(window).resize(function(){
                        verticalSliderResponsive();
                    })

                } );

            } );
        }

    };

    CL_FRONT.scrollIndicator = function(){
        const indicator = document.querySelector('.cl-scroll-indicator');
        if( indicator ){
            window.addEventListener('scroll', function(){
                if( window.scrollY > 50 && ! indicator.classList.contains( 'hide-scroll' ) )
                    indicator.classList.add('hide-scroll');
                else if( window.scrollY == 0 && indicator.classList.contains( 'hide-scroll' )  )
                    indicator.classList.remove('hide-scroll');
            });
        }
    };



    /**
     * Load More Button and Infinite Scroll
     * 
     * @since 1.0.0
     */
    CL_FRONT.paginationInfinite = function( $el ) {
        "use strict";

        var $elements = $el || $( '.cl-pagination-infinite' );
        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'infinitescroll.js' ], function() {

                    var $container = $( '#' + $element.parent().data( 'containerId' ) );
                  
                    // Init infinite scroll
                    $container.infinitescroll( {
                            loading: {
                                msg: null,
                                finishedMsg: '',
                                msgText: '',
                                start: function(){
                                    var inf = $(this).data('infinitescroll');
                                    var opts = inf.options;

                                    $('.cl-infinite-loader').removeClass('hidden');
                                   
                                    $(opts.navSelector).hide();
                                    
                                    opts.loading.msg
                                    .appendTo(opts.loading.selector)
                                    .show(opts.loading.speed, $.proxy(function() {
                                        inf.beginAjax(opts);
                                    }));
                                },
                                finished: function(){
                                    $('.cl-infinite-loader').addClass('hidden');
                                }
                            },
                            navSelector: 'div.cl-pagination-infinite .older-posts',
                            nextSelector: 'div.cl-pagination-infinite .older-posts a',
                            itemSelector: 'article.post, .portfolio_item, .product_item',
                            errorCallback: function() {
                                $( '#cl_load_more_btn' ).animate( {
                                    opacity: 0
                                } ).remove();
                                $('.cl-infinite-loader').addClass('hidden');
                            },
                           
                        },

                        // Callback function
                        function( newElements ) {

                            $( '#infscr-loading', $container ).remove();
                            var $newElems = $( newElements );

                            if ( !$container.hasClass( 'animated-entries' ) )
                                $newElems.css( 'opacity', 0 );

                            $newElems.imagesLoaded( function() {

                                // Animate new Items
                                if ( !$container.hasClass( 'animated-entries' ) ){
                                    $newElems.animate( {
                                        opacity: 1
                                    } );
                                    
                                }
                                    

                                

                                CL_FRONT.postInit( $newElems );

                                

                                CL_FRONT.fixPostVideoHeight( $newElems );

                                // Appended to Isotope
                                if ( $container.hasClass( 'grid-entries' ) || $container.hasClass( 'masonry-entries' ) ) {
                                    var iso = $container.data( 'isotope' );
                                    iso.appended( $newElems );
                                    iso.layout();
                                }

                                // Run Animation
                                if ( $container.hasClass( 'animated-entries' ) )
                                    CL_FRONT.animations();
                                    
                                
                                if ( $element.data( 'type' ) == 'loadmore' )
                                    $( 'body, html' ).animate( {
                                        scrollTop: $newElems.offset().top
                                    }, 800 );

                            } );

                        } );

                    // If loadmore button is active
                    if ( $element.data( 'type' ) == 'loadmore' ) {
                        $( window ).unbind( '.infscr' );

                        $( '#cl_load_more_btn' ).on( 'click', function() {
                           
                            $container.infinitescroll( 'retrieve' );
                        } );
                    }


                } );

            } );
        }

    };

    CL_FRONT.blogSlider = function(){
        "use strict";
        $('.cl_blog_slider .owl-carousel').each(function(){
            var data = {

                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 1
                    },
                    768: {
                        items: 1
                    },
                    992: {
                        items: $( this ).attr('data-columns')
                    }
                },

                items: $( this ).attr('data-columns'),
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                slideBy: 1,
                nav: true,
                navText: []

            };
            if( $( this ).attr('data-columns') > 1 )
                data['margin'] = 30;

            CL_FRONT.components.Carousel( $( this ), data, function(owl, el){
                  
            });
        });
    };

    /**
     * Blog Grid and Masonry Isotope
     * Use the Isotope component
     * 
     * @since 1.0.0
     */
    CL_FRONT.isotopeBlogGrid = CL_FRONT.init_cl_blog = function( $el ) {
        "use strict";
        $( '.blog-entries' ).each(function(){
            if( $(this).hasClass('cl-carousel') ){
                console.log('hey');
                CL_FRONT.components.Carousel( $( this ), {

                    responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        992: {
                            items: $( this ).attr('data-grid-cols')
                        }
                    },

                    items: $( this ).attr('data-grid-cols'),
                    animateIn: 'alpha-in',
                    animateOut: 'fadeOut',
                    slideBy: $( this ).attr('data-grid-cols'),

                }, function(owl, el){
                    CL_FRONT.fixPostVideoHeight(el.find('article.format-video'));
                    CL_FRONT.postSwiper(el);
                    owl.on('resized.owl.carousel', function(event){
                        CL_FRONT.animations( el.find( '.owl-item.active' ), true ); 
                    });          
                });

            }else if( $(this).hasClass('masonry-entries') || $(this).hasClass('grid-entries') )
                CL_FRONT.components.Isotope( $( this ) );

        });
        
    };

    /**
     * Isotope Portfolio Init
     * used on Customizer too
     * 
     * @since 1.0.0
     */
    CL_FRONT.isotopePortfolioGrid = CL_FRONT.init_cl_portfolio = function( $el ) {
        "use strict";
        $( '.portfolio-entries:not(.portfolio-parallax):not(.portfolio-parallax-2)' ).each(function(){
            if( $(this).hasClass('cl-carousel') )
                CL_FRONT.components.Carousel( $( this ) );
            else if( $(this).hasClass('cl-justify-gallery') )
                CL_FRONT.components.JustifyGallery( $( this ) );
            else
                CL_FRONT.components.Isotope( $( this ) );

        });

        if( CL_FRONT.config.$isMobileScreen ){
           $('.portfolio_item .entry-link').attr('onClick', 'return false');
           $('.portfolio_item').each(function(){
              $(this).on('mousemove', function(){
                
                 if( parseInt( $(this).find( '.entry-overlay' ).css('opacity') ) == 1 ){
                      
                        $(this).find('.entry-link').attr('onClick', '');
                 }
                    else
                      $(this).find('.entry-link').attr('onClick', 'return false');
                })
            })
        }

        
    };

    CL_FRONT.portfolioCarouselCenter = CL_FRONT.init_cl_portfolio_carousel_center = function( $el ) {
        "use strict";

        $('.portfolio-carousel-center').each(function(){
            var $portfolio = $(this);
            CL_FRONT.components.Carousel( $portfolio, {
                center: true,
                responsive: {
                    0:{
                        items:1
                    },
                    992:{
                        items:2
                    }
                },
                startPosition: 1,
                stagePadding: 200
            } );

            $('.portfolio-carousel-center-navs .next', $portfolio).on('click', function(e){
                e.preventDefault();
                $portfolio.trigger('next.owl.carousel');
            });

            $('.portfolio-carousel-center-navs .prev', $portfolio).on('click', function(e){
                e.preventDefault();
                $portfolio.trigger('prev.owl.carousel');
            });
        });
    };


    

    /**
     * Init Testimonial Carousel
     * 
     * @since 1.0.0
     */
    CL_FRONT.testimonialCarousel = CL_FRONT.init_cl_testimonial = function(){
        "use strict";
   
      
        $('#testimonial-entries').each(function(){
            CL_FRONT.components.Carousel( $( this ), {

                items: CL_FRONT.helpers.parseData( $( this ).attr( 'data-carousel-items' ), 1 ),
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                autoplay: CL_FRONT.helpers.parseData( $( this ).attr( 'data-carousel-autoplay' ), false )
            });
        });
    };


    CL_FRONT.testimonial_1 = function($elements){
        "use strict";
        if( typeof $elements == 'undefined' )
            $elements = $('.cl_testimonial_1');

        $elements.each(function(){
            var $element = $(this);
            CL_FRONT.components.Carousel( $element, {
                items: 1,
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                autoplay: true
            });

            $('.nav .prev', $element).on( 'click', function(e){
                e.preventDefault();
                $element.trigger('prev.owl.carousel');
            } );

            $('.nav .next', $element).on( 'click', function(e){
                e.preventDefault();
                $element.trigger('next.owl.carousel');
            } );
        });
    };


    CL_FRONT.testimonial_2 = function($elements){
        "use strict";
        if( typeof $elements == 'undefined' )
            $elements = $('.cl_testimonial_2');

        $elements.each(function(){
            var $element = $(this),
                $carousel = $element.find('.wrapper');
            CL_FRONT.components.Carousel( $carousel, {
                items: 1,
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                autoplay: true,
                dots:true,
                dotsData:true,
                center:true,
                loop:true,
                startPosition:1,
                dotsEach: 2,
            });

        });
    };

    CL_FRONT.testimonial_3 = function($elements){
        "use strict";
        if( typeof $elements == 'undefined' )
            $elements = $('.cl_testimonial_3');

        $elements.each(function(){
            var $element = $(this),
                $carousel = $element.find('.wrapper');
            CL_FRONT.components.Carousel( $carousel, {
                items: 1,
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                autoplay: true,
            });

            $('.nav .prev', $element).on( 'click', function(e){
                e.preventDefault();
                $carousel.trigger('prev.owl.carousel');
            } );

            $('.nav .next', $element).on( 'click', function(e){
                e.preventDefault();
                $carousel.trigger('next.owl.carousel');
            } );

        });
    }



    /**
     * Team Carousel
     * 
     * @since 1.0.0
     */
    CL_FRONT.teamCarousel = CL_FRONT.init_cl_team = function(){
        "use strict";

        
        $('.cl_team.cl-carousel').each(function(){
            CL_FRONT.components.Carousel( $( this ), {

                responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: CL_FRONT.helpers.parseData( $(this).attr('data-columns'), 4 )
                        }
                },
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                stagePadding: CL_FRONT.helpers.parseData( $(this).data('stagePadding'), false ) ? 150 : false,
            });
        });
    }


    /**
     * Clients Carousel
     * 
     * @since 1.0.0
     */
    CL_FRONT.clientsCarousel = CL_FRONT.init_cl_clients = function(){
        "use strict";
        $('.cl_clients.cl-carousel').each(function(){
            CL_FRONT.components.Carousel( $( this ), {
                responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: CL_FRONT.helpers.parseData( $(this).data('items'), 6 )
                        }
                    },
                items: CL_FRONT.helpers.parseData( $(this).data('items'), 6 ),
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
                autoplay: true,
                stagePadding: CL_FRONT.helpers.parseData( $(this).data('stagePadding'), false ) ? 50 : false,
                autoplayTimeout: CL_FRONT.helpers.parseData( $(this).data('autoplayTimeout'), 5000 ),
                loop: false
            });
        });
    };


    /**
     * Gallery Carousel
     * 
     * @since 1.0.0
     */
    CL_FRONT.galleryCarousel = CL_FRONT.init_cl_gallery = function(){
        "use strict";
        $('.cl_gallery.cl-carousel').each(function(){
            CL_FRONT.components.Carousel( $( this ), {
                responsive: {
                        0: {
                            items: 1
                        },
                        480: {
                            items: 2
                        },
                        768: {
                            items: 3
                        },
                        992: {
                            items: CL_FRONT.helpers.parseData( $(this).data('items'), 2 )
                        }
                    },
                items: CL_FRONT.helpers.parseData( $(this).data('items'), 2 ),
                animateIn: 'alpha-in',
                animateOut: 'fadeOut',
            });
        });
    }


    


    /**
     * Fix Height of Video Post when loaded with ajax
     * 
     * @since 1.0.0
     */
    CL_FRONT.fixPostVideoHeight = function( $el ) {

        var $elements = CL_FRONT.helpers.parseData( $el, $( 'article.format-video' ) );
        
        if ( $elements.length ) {
            $elements.each( function( i ) {
                var $element = $( this );
                if ( !$element.hasClass( 'format-video' ) )
                    return;
                if( $element.hasClass('alternate-style') )
                    return;

                var width = $element.find( 'video, iframe' ).attr( 'width' ),
                    height = $element.find( 'video, iframe' ).attr( 'height' ),
                    element_width = $element.width();

                var new_height = ( element_width * height ) / width;

                $element.find( 'video, iframe' ).height( new_height + 'px' );
            } );
        }
    }


    /**
     * Sticky Sidebar Function
     * 
     * @since 1.0.0
     */
    CL_FRONT.stickySidebar = function() {
        "use strict";

        if ( this.config.$aside.hasClass( 'cl-sticky' ) && !this.config.$isMobileScreen ) {

            if ( this.config.$asideHeight == 0 )
                this.config.$asideHeight = this.config.$aside.height();

            if ( this.config.$asideTop == 0 )
                this.config.$asideTop = this.config.$aside.offset().top;

            if ( this.config.$asideStickyOffset == 0 )
                this.config.$asideStickyOffset = this.config.$aside.data( 'stickyOffset' ) != 0 ? this.config.$aside.find( '.widget:nth-last-child(' + parseInt( this.config.$aside.data( 'stickyOffset' ) ) + ')' ).offset().top : 0;

            var cl_distace = 80,
                cl_point = 0;

            if ( this.config.$asideStickyOffset != 0 )
                cl_point = this.config.$asideStickyOffset;
            else
                cl_point = this.config.$asideTop - cl_distace;

            this.config.$aside.find( '.cl-sticky-wrapper' ).width( this.config.$aside.width() + 'px' );

            if ( this.config.$windowTop >= cl_point ) {
                this.config.$aside.addClass( 'cl-sticky-active' );
                this.config.$aside.find( '.cl-sticky-wrapper' ).css( 'top', '-' + ( cl_point - this.config.$asideTop ) + 'px' );

            } else {
                this.config.$aside.find( '.cl-sticky-wrapper' ).css( 'top', cl_distace + 'px' );
                this.config.$aside.removeClass( 'cl-sticky-active' );
            }

        }
    }


    /**
     * Sticky Column Function
     *
     * @since 1.0.0
     *
     */


    CL_FRONT.stickyColumn = function() {
        "use strict";

        if(!this.config.$isMobileScreen && $('.cl-sticky.cl_column').length > 0){
       
            $('.cl-sticky.cl_column').each( function(){
                var $sticky = $(this),
                    stickyTop = 0,
                    stickyHeight = 0;

                
                stickyHeight = $sticky.height();

                stickyTop = $sticky.offset().top;

               
                var cl_distace = 0,
                    cl_point = 0;

                cl_point = stickyTop - cl_distace;

                $sticky.find( '.cl_col_wrapper ' ).width( $sticky.width() + 'px' );

                if ( CL_FRONT.config.$windowTop >= cl_point ) {
                    $sticky.addClass( 'cl-sticky-active' );
                    $sticky.find( '.cl_col_wrapper' ).css( 'top', '-' + ( cl_point - stickyTop ) + 'px' );

                } else {
                    $sticky.find( '.cl_col_wrapper' ).css( 'top', cl_distace + 'px' );
                    $sticky.removeClass( 'cl-sticky-active' );
                }

            
            });   
        }    
    }

    
    /**
     * Progress Bar Function
     *
     * @since 1.0.0
     *
     */

    CL_FRONT.progressBar = function($el){
        "use strict";

        var from_start = $el == null ? true : false;
        var $elements = CL_FRONT.helpers.parseData( $el, $( '.cl_progress_bar' ) );
       
        if( $elements.length > 0 ){
            $elements.each(function(){

                var $element = $(this),
                    percentage = $element.attr('data-percentage');

                if( from_start && $element.hasClass('animate_on_visible') )
                    return;

                $element.find('.percentage').html(percentage+'%');
                $element.find('.bar').css('width', percentage+'%');
            });
        }
    };


    CL_FRONT.mediaElement = CL_FRONT.init_cl_media = function(){
        "use strict";

        if( $('.cl_media.type-video').length > 0 ){
            $('.cl_media.type-video').each(function(){
                
                var $element = $(this),
                    $play = $element.find( '.play-button' ),
                    $isPlay = ($play.length > 0) ? true : false;

                if( $isPlay ){

                    $element.addClass('hide-video');
                    if(typeof $element.find('video').get(0) !== "undefined")
                        $element.find('video').get(0).pause();
                    setTimeout(function(){
                        var height = $element.find( 'iframe, video' ).height();
                        $element.height(height);
                    }, 50);

                    $play.on('click', function(e){
                        e.preventDefault();
                        
                        /*$element.find( 'source, iframe' ).each(function(){
                            var src = $(this).attr('data-src');
                            $(this).attr('src', src);
                        });*/

                        
                            $element.find( 'video' ).load();
                            $element.addClass('show-video');
                            $element.find( 'video' ).get(0).play();
                          
                       
                        
                        return true;

                    });
                }else{
                    $element.find( 'source, iframe' ).each(function(){
                        var src = $(this).attr('data-src');
                        $(this).attr('src', src);
                    });
                }



            });
        }


       

    };


    /**
     * Init Page Header Element
     * Used on Codeless Builder Too
     * @since 1.0.0
     */
    CL_FRONT.init_cl_page_header = function(){
        
        this.fixPageHeaderCenter();
        CL_FRONT.components.loadAnimation( $( '.cl_page_header' ), function(){
            CL_FRONT.pageHeaderParallax();
        } );     

    };

    /**
     * Page Header Parallax
     * Loads the Parallax component
     * @since 1.0.0
     */

    CL_FRONT.pageHeaderParallax = function() {
        "use strict";

        if ( $( '.cl_page_header.cl-parallax .bg-layer' ).length > 0 )
            CL_FRONT.components.Parallax( $( '.cl_page_header.cl-parallax .bg-layer' ) ).init();
    };
    

    CL_FRONT.fixPageHeaderCenter = function(){
        if( this.config.$header.hasClass('cl-transparent') && $( '.cl_page_header'  ).length > 0 ){
            var $pageHeader = $( '.cl_page_header'  );   
            
            if( $pageHeader.hasClass('modern') )
                $pageHeader.css( { paddingTop: (this.config.$headerHeight / 2) + 'px' } ); 
        }
    }


    /**
     * Fix Megamenu Position when is out from container
     * @since 1.0.0
     */
    CL_FRONT.fixMegaMenuPosition = function( menu ){
        "use strict";

        var fixMegaMenu = function(megamenu){
            var width = $( megamenu ).find('> .sub-menu').width(),
                liParent = $( megamenu ).parent( 'li' ),

                mega_columns = $( megamenu ).children('ul').children('li'),
                columns = mega_columns.length,
                column_width = width / columns,
                mega_menu_layout = $( megamenu ).hasClass('layout-boxed') ? 'boxed' : 'fullwidth',
                bg_image = liParent.data('bg'),
                bg_type = $( megamenu ).hasClass('bg_type-background') ? 'background' : 'column',
                offsetFromLi = liParent.offset().left - CL_FRONT.config.$containerOffsetLeft;
            

            
            if( mega_menu_layout == 'boxed' ){
                width = $( megamenu ).width() - 72;
                column_width = width / columns;
                if( width == CL_FRONT.config.$containerWidth ){
                    $( megamenu ).css( { left: '-' + offsetFromLi + 'px' } );
                    $( megamenu )[0].style.setProperty( '--arrow-position', offsetFromLi + 'px' );
                }else {  
                    setTimeout(function(){

                        var offsetOutFromContainer =  Math.abs( (CL_FRONT.config.$containerOffsetLeft + CL_FRONT.config.$containerWidth) - ( liParent.offset().left + width ) );
                        
                        if( offsetOutFromContainer >  offsetFromLi )
                            offsetOutFromContainer = 0;
                        
                        $( megamenu ).css( { left: '-' + (offsetOutFromContainer + 72) + 'px' } );
                        $( megamenu )[0].style.setProperty( '--arrow-position', (offsetOutFromContainer + 72 + 30 +  ( ( liParent.width() /2 ) - 10)  ) + 'px' );
                    }, 1); 
                }
            }else{
                $( megamenu ).css( { left: '-' + liParent.offset().left + 'px', width: CL_FRONT.config.$windowWidth + 'px'} );
                $( megamenu ).find('> .sub-menu').css({width:'1170px', margin: '0 auto'});
                $( megamenu )[0].style.setProperty( '--arrow-position', (liParent.offset().left + 30 + ( ( liParent.width() /2 ) - 10)  ) + 'px' );
            }

            if( bg_image != '' && bg_type == 'background' ){
                $( megamenu ).css({"background-image": 'url("'+bg_image+'")'});
            }
           
            mega_columns.css( { width: column_width + 'px'} );
        };

        if( ! menu ){
            this.config.$navigation.find( '.codeless_custom_menu_mega_menu' ).each( function( index, megamenu ){
            
                fixMegaMenu( megamenu );

            } );
        }else{
            fixMegaMenu( menu );
        }
    };


    /**
     * Initialize Tools Dropdown in Responsive
     * 
     * @since 1.0.0
     */

    CL_FRONT.initToolsResponsive = function() {
        "use strict";
        var self = this;
       

        if( this.config.$windowWidth <= 991 ){

            if( this.config.$headerToolsInit )
                return;

            this.config.$headerTools.find( '.tool .cl-submenu' ).each(function(){
                var submenu = $(this);
                submenu.addClass('cl-hide-on-mobile');

                var responsiveMenu = submenu.clone().appendTo(CL_FRONT.config.$header);
                responsiveMenu.removeClass( 'cl-hide-on-mobile' ).addClass( 'cl-mobile-menu' );

                CL_FRONT.config.$headerToolsList.push(submenu);
                submenu.closest('.tool').find(' > i, > .tool-link').on( 'click', function( e ){
                    e.preventDefault();

                    var button = $(this);
                    responsiveMenu.slideToggle('200');

                } );
            });

            this.config.$headerToolsInit  = true;

        }else{
            this.config.$header.find('.cl-mobile-menu').addClass('cl-hide-not-mobile');
            
            if( CL_FRONT.config.$headerToolsList.length > 0 ){
                CL_FRONT.config.$headerToolsList.forEach( function(menu){
                    menu.closest('.tool').find(' > i, > .tool-link').off('click');
                    menu.closest('.tool').find(' > i, > .tool-link').on('click', function(e){
                        return true;
                    });
                } );
            }
        }

    }

    /**
     * Tools Dropdown init
     * @since 1.0.0
     */

    CL_FRONT.initToolsDropdown = function() {
        "use strict";

        var toOpen = null,
            isOpen = false,
            mainNode = null;


        this.config.$headerTools.find( '.tool' ).each( function( index, submenu ) {

            if ( $( submenu ).find( '.cl-submenu' ).length > 0 ) {
                $( submenu ).addClass( 'hasSubMenu' );
            }

        } );

        mainNode = this.config.$headerTools[0];

        this.config.$headerTools.mouseover( function( e ) {

            var item = e.target || e.srcElement;

            while ( ! $(item).hasClass('tool') && item != mainNode ) {
                item = item.parentNode;
            }

            if ( $(item).hasClass('tool') ) {
                toOpen = item;
                open();
            }

        } ).mouseleave( function() {
            close();
        } );

        var open = function() {
            isOpen = true;

            // Get other items with same parent
            var items = $( toOpen ).parent().children( '.tool' );
            
            $( items ).each( function( index, item ) {
                $( item ).find( ".cl-submenu" ).each( function( index, submenu ) {
                    if ( item != toOpen ) {
                        $( item ).removeClass( "showDropdown" );
                        close( item );

                    } else 
                    if ( !$( item ).hasClass( 'showDropdown' ) ) {



                        $( item ).addClass( "showDropdown" );

                        
                        var left = 0;
                        var node = submenu;
                        while ( node ) {
                            
                            left += Math.abs( node.offsetLeft );
                            node = node.offsetParent;
                        }
                        var right = left + submenu.offsetWidth;


                        //We should refactor this code to execute only when menu is vertical
                        var menuHeight = $( submenu ).outerHeight();
                        var parentTop = $( submenu ).offset().top - $( window ).scrollTop();
                        var totalHeight = menuHeight + parentTop;
                        var windowHeight = window.innerHeight;



                        $( item ).removeClass( 'dropdownRightToLeft' );

                        if ( left < 0 ) $( item ).addClass( 'dropdownLeftToRight' );

                        if ( right > CL_FRONT.config.$containerOffsetLeft + CL_FRONT.config.$containerWidth ) {
                            $( item ).addClass( 'dropdownRightToLeft' );
                        }

                        if( $( item ).parents( '.showDropdown' ).length > 0 ){
                            var width = $( item ).parents( '.showDropdown' ).first().children('.cl-submenu').width();
                            
                            if( $( item ).hasClass( 'dropdownLeftToRight' ) || ( ! $( item ).hasClass( 'dropdownLeftToRight' ) && ! $( item ).hasClass( 'dropdownRightToLeft' ) ) )
                                $( item ).find( ".cl-submenu" ).css( { left: (width+1)+'px' } );
                            if( $( item ).hasClass( 'dropdownRightToLeft' ) )
                                $( item ).find( "cl-submenu" ).css( { right: (width+1)+'px' } );
                        }

                    }
                } );
            } );
        };

        var close = function( node ) {
            if (!node) {
              isOpen = false;
              node = mainNode;
            }

            // loop over the items, closing their submenus
            $(node).find('.tool').each(function(index, item) {
              $(item).removeClass('showDropdown');
            });
        }

    };


    CL_FRONT.customMouseCursor = function(){
        // set the starting position of the cursor outside of the screen
        if( !$('body').hasClass( 'cl-custom-mouse-cursor' ) )
            return;

        CL_FRONT.components.loadDependencies([codeless_global.FRONT_LIB_JS + "gsap.js"], function(){
            class CursorCustom {
                constructor() {
                  this.initCursor();
                  this.initHovers();
                }
              
                initCursor() {
                  const { Back } = window;
                  this.outerCursor = document.querySelector(".circle-cursor--outer");
                  this.innerCursor = document.querySelector(".circle-cursor--inner");
                  this.outerCursorBox = this.outerCursor.getBoundingClientRect();
                  this.outerCursorSpeed = 0;
                  this.easing = Back.easeOut.config(1.7);
                  this.clientX = -100;
                  this.clientY = -100;
                  this.showCursor = false;
              
                  const unveilCursor = () => {
                    TweenMax.set(this.innerCursor, {
                      x: this.clientX,
                      y: this.clientY
                    });
                    TweenMax.set(this.outerCursor, {
                      x: this.clientX - this.outerCursorBox.width / 2,
                      y: this.clientY - this.outerCursorBox.height / 2
                    });
                    setTimeout(() => {
                      this.outerCursorSpeed = 0.2;
                    }, 100);
                    this.showCursor = true;
                  };
                  document.addEventListener("mousemove", unveilCursor);
              
                  document.addEventListener("mousemove", e => {
                    this.clientX = e.clientX;
                    this.clientY = e.clientY;
                  });
              
                  const render = () => {
                    TweenMax.set(this.innerCursor, {
                      x: this.clientX,
                      y: this.clientY
                    });
                    if (!this.isStuck) {
                      TweenMax.to(this.outerCursor, this.outerCursorSpeed, {
                        x: this.clientX - this.outerCursorBox.width / 2,
                        y: this.clientY - this.outerCursorBox.height / 2
                      });
                    }
                    if (this.showCursor) {
                      document.removeEventListener("mousemove", unveilCursor);
                    }
                    requestAnimationFrame(render);
                  };
                  requestAnimationFrame(render);
                }
              
                initHovers() {
                    const handleMouseEnter = e => {
                        this.isStuck = true;
                        const target = e.currentTarget;
                        const box = target.getBoundingClientRect();
                        var color = this.outerCursor.classList.contains('issue-zone-light') ? '#000000' : codeless_global.cursorColor;
                        color = this.outerCursor.classList.contains('issue-zone-dark') ? '#ffffff' : color;

                        this.outerCursorOriginals = {
                          width: this.outerCursorBox.width,
                          height: this.outerCursorBox.height
                        };
                        TweenMax.to(this.outerCursor, 0.2, {
                          x: box.left-5,
                          y: box.top-5,
                          width: box.width + 10,
                          height: box.height + 10,
                          opacity: 0.4,
                          borderColor: color
                        });
                      };
                  
                      const handleMouseLeave = () => {
                        this.isStuck = false;
                        var color = this.outerCursor.classList.contains('issue-zone-light') ? '#000000' : codeless_global.cursorColor;
                        color = this.outerCursor.classList.contains('issue-zone-dark') ? '#ffffff' : color;

                        TweenMax.to(this.outerCursor, 0.2, {
                          width: this.outerCursorOriginals.width,
                          height: this.outerCursorOriginals.height,
                          opacity: 0.2,
                          borderColor: color
                        });
                      };
              
                  const linkItems = document.querySelectorAll(".ce-nav-menu-icon, .ce-flyout-close, .elementor-icon, i.feather, i.fab");
                  linkItems.forEach(item => {
                    item.addEventListener("mouseenter", handleMouseEnter);
                    item.addEventListener("mouseleave", handleMouseLeave);
                  });
                  
                  var color = this.outerCursor.classList.contains('issue-zone-light') ? '#000000' : codeless_global.cursorColor;
                    color = this.outerCursor.classList.contains('issue-zone-dark') ? '#ffffff' : color;
                  
                  const mainNavHoverTween = TweenMax.to(this.outerCursor, 0.3, {
                    backgroundColor: color,
                    ease: this.easing,
                    paused: true,
                    width: 45,
                    height: 45
                  });
              
                  const mainNavMouseEnter = () => {
                    
                    this.outerCursorSpeed = 0;
                    TweenMax.set(this.innerCursor, { opacity: 0 });
                    mainNavHoverTween.play();
                  };
              
                  const mainNavMouseLeave = () => {
                    this.outerCursorSpeed = 0.2;
                    TweenMax.set(this.innerCursor, { opacity: 1 });
                    mainNavHoverTween.reverse();
                  };
              
                  const mainNavLinks = document.querySelectorAll("a:not(.elementor-icon)");
                  mainNavLinks.forEach(item => {
                    item.addEventListener("mouseenter", mainNavMouseEnter);
                    item.addEventListener("mouseleave", mainNavMouseLeave);
                  });


                  const colorIssueEnter = e => {
                    const target = e.currentTarget;
                    this.outerCursor.classList.add( 'issue-zone' );
                    this.innerCursor.classList.add( 'issue-zone' );
                    var new_target = color = false;

                    if( $(target).closest( '.ce-megamenu-wrapper' ).length || $(target).hasClass( 'ce-megamenu-wrapper' ) ){
                        new_target = $(target).hasClass( 'ce-megamenu-wrapper' ) ? target : $(target).closest( '.ce-megamenu-wrapper' )[0];
                    }

                    if( $(target).closest( '.sub-menu' ).length || $(target).hasClass( 'sub-menu' ) ){
                        new_target = $(target).hasClass( 'sub-menu' ) ? target : $(target).closest( '.sub-menu' )[0];
                    }

                    if( $(target).closest( '.ce-flyout-content' ).length || $(target).hasClass( 'ce-flyout-content' ) ){
                        new_target = $(target).hasClass( 'ce-flyout-content' ) ? target : $(target).closest( '.ce-flyout-content' )[0];
                    }

                    if( $(target).closest( 'footer#colophon' ).length || $(target).is( $('footer#colophon' ) ) ){
                        new_target = $(target).hasClass( 'elementor-section' ) ? target : $(target).closest( '.elementor-section' )[0];
                    }
                    

                    if( new_target )
                        color = window.getComputedStyle( new_target, null ).getPropertyValue( 'background-color' );
                    
                    if( color == 'rgb(255, 255, 255)' || color == '#ffffff' ){
                        this.outerCursor.classList.add( 'issue-zone-light' );
                        this.innerCursor.classList.add( 'issue-zone-light' );
                    }
                    if( color == 'rgb(0, 0, 0)' || color == '#000000' ){
                        this.outerCursor.classList.add( 'issue-zone-dark' );
                        this.innerCursor.classList.add( 'issue-zone-dark' );
                    }
                  };
              
                  const colorIssueLeave = e => {
                    this.outerCursor.classList.remove( 'issue-zone' );
                    this.outerCursor.classList.remove( 'issue-zone-light' );
                    this.outerCursor.classList.remove( 'issue-zone-dark' );

                    this.innerCursor.classList.remove( 'issue-zone' );
                    this.innerCursor.classList.remove( 'issue-zone-light' );
                    this.innerCursor.classList.remove( 'issue-zone-dark' );
                  };

                  const fixColorissue = document.querySelectorAll(".ce-megamenu-wrapper, .ce-has-no-megamenu .sub-menu, .ce-flyout-content, footer#colophon .elementor-section");
                  fixColorissue.forEach(item => {
                    item.addEventListener("mouseenter", colorIssueEnter);
                    item.addEventListener("mouseleave", colorIssueLeave);
                  });
                }
              }

              const cursor = new CursorCustom();
        });
    };


    /**
     * Menu Dropdown init
     * @since 1.0.0
     */

    CL_FRONT.initMenuDropdown = function() {
        "use strict";

        var toOpen = null,
            isOpen = false,
            mainNode = null,
            subHeights = [];

        if( this.config.$navigation.hasClass('vertical-menu') ){
            CL_FRONT.verticalMenuInit();
            return false;
        }

        this.config.$navigation.find( 'ul > li' ).each( function( index, submenu ) {

            if ( $( submenu ).find( 'ul' ).length > 0 ) {
                $( submenu ).addClass( 'hasSubMenu' );
                $( submenu ).find( '> a' ).addClass('anchorSubmenu');
                
            }

        } );
        
        mainNode = this.config.$navigation[0];

        this.config.$navigation.mouseover( function( e ) {

            var item = e.target || e.srcElement;

            while ( item.nodeName != 'LI' && item != mainNode ) {
                item = item.parentNode;
            }

            if ( item.nodeName == 'LI' ) {
                toOpen = item;
                open();
            }

        } ).mouseleave( function() {
            close();
        } );

        var open = function() {
            isOpen = true;

            // Get other items with same parent
            var items = $( toOpen ).parent().children( 'li' );
            
            $( items ).each( function( index, item ) {
                $( item ).find( "ul" ).each( function( index, submenu ) {

                    if ( item != toOpen ) {
                        
                        $( item ).removeClass( "showDropdown" );

                        close( item );

                    } else if ( !$( item ).hasClass( 'showDropdown' ) ) {

                        if( $( item ).children( '.codeless_custom_menu_mega_menu' ).length > 0 ){
                            CL_FRONT.fixMegaMenuPosition( $( item ).children( '.codeless_custom_menu_mega_menu' )[0] );
                        }

                        $( item ).addClass( "showDropdown" );

                        
                        var left = 0;
                        var node = submenu;
                        while ( node ) {
                            
                            left += Math.abs( node.offsetLeft );
                            node = node.offsetParent;
                        }
                        var right = left + submenu.offsetWidth;

                        var menuHeight = $( submenu ).outerHeight();
                        var innerHeight = $( submenu ).innerHeight();
                        var parentTop = $( submenu ).offset().top - $( window ).scrollTop();
                        var totalHeight = menuHeight + parentTop;
                        var windowHeight = window.innerHeight;

                       
                        $( item ).removeClass( 'dropdownRightToLeft' );

                        if ( left < 0 ) $( item ).addClass( 'dropdownLeftToRight' );

                        if ( right > document.body.clientWidth ) {
                            $( item ).addClass( 'dropdownRightToLeft' );
                        }

                        if( $( item ).parents( '.showDropdown' ).length > 0 && $( item ).parents( '.codeless_custom_menu_mega_menu' ).length == 0 ){
                            var width = $( item ).parents( '.showDropdown' ).first().children('ul').width();
                            
                            if( $( item ).hasClass( 'dropdownLeftToRight' ) || ( ! $( item ).hasClass( 'dropdownLeftToRight' ) && ! $( item ).hasClass( 'dropdownRightToLeft' ) ) )
                                $( item ).find( "ul" ).css( { left: (width+1)+'px' } );
                            if( $( item ).hasClass( 'dropdownRightToLeft' ) )
                                $( item ).find( "ul" ).css( { right: (width+1)+'px' } );
                        }

                    }
                } );
            } );
        };

        var close = function( node ) {
            if (!node) {
              isOpen = false;
              node = mainNode;
            }

            // loop over the items, closing their submenus
            $(node).find('li').each(function(index, item) {
                if( $( item ).parents('.cl-dropdown-inline').length > 0 )
                    $(item).find('.sub-menu').css('height', 0);

                $(item).removeClass('showDropdown');
            });
        }

    }

   





     /**
     * Contact Form Submit Button add neccessary classes
     * @since 1.0.0
     */
    CL_FRONT.contactForm = function(){
        if( $('.wpcf7-form').length > 0 ){
            $('.wpcf7-form').each(function(){
                var $form = $(this);

                $form.find('.wpcf7-submit').addClass(codeless_global.cl_btn_classes);
            });
        }
        
    }


     /**
     * Add appropiate btn classes to shop widgets
     * @since 1.0.0
     */
    CL_FRONT.shopBtnClasses = function(){

        var $btn = $('.widget_shopping_cart_content .button'),
            $btn2 = $('.price_slider_amount .button');
        
        if( $btn.length > 0 )
            $btn.addClass(codeless_global.cl_btn_classes).removeClass("btn-layout-large").addClass('btn-layout-small').removeClass('btn-font-medium').addClass('btn-font-small');
        if( $btn2.length > 0 )
            $btn2.addClass(codeless_global.cl_btn_classes).removeClass("btn-layout-large").addClass('btn-layout-small').removeClass('btn-font-medium').addClass('btn-font-small');
        
        CL_FRONT.config.$body.on('added_to_cart', function(){
            CL_FRONT.shopBtnClasses();
        });
    }


     /**
     * Row Parallax Initialize
     * @since 1.0.0
     */
    CL_FRONT.rowParallax = function() {
        "use strict";
        if ( $( '.cl-row.cl-parallax > .bg-layer' ).length > 0 ){
            $( '.cl-row.cl-parallax > .bg-layer' ).each(function(){
                CL_FRONT.components.Parallax( $( this ) ).init();
            })
            
        }
    };


    /**
     * Creative Search
     * @since 1.0.0
     */
    CL_FRONT.creativeSearch = function(){
        'use strict';

        if( $('.search-style-creative').length == 0 )
            return;

       
        var mainContainer = document.querySelector('#wrapper'),
            openCtrl = document.getElementById('header_search_btn'),
            closeCtrl = document.getElementById('btn-search-close'),
            searchContainer = document.querySelector('.creative-search');

        if( searchContainer === null )
            return;

        var inputSearch = searchContainer.querySelector('.search__input');

        var init = function() {
         
            initEvents();   
        }

        var initEvents = function() {
           
            openCtrl.addEventListener('click', openSearch);
            closeCtrl.addEventListener('click', closeSearch);
            document.addEventListener('keyup', function(ev) {
                // escape key.
                if( ev.keyCode == 27 ) {
                    closeSearch();
                }
            });
        }

        var openSearch = function(e) {
            e.preventDefault();
       
            mainContainer.classList.add('main-wrap--hide');
            searchContainer.classList.add('search--open');
            setTimeout(function() {
                inputSearch.focus();
            }, 500);
        }

        var closeSearch = function() {
            mainContainer.classList.remove('main-wrap--hide');
            searchContainer.classList.remove('search--open');
            inputSearch.blur();
            inputSearch.value = '';
        }

        init();

    };


    



     /**
     * Initialize Odometer counter
     * @since 1.0.0
     */
    CL_FRONT.codelessCounter = function(el){
        "use strict";
        var element = el;
        CL_FRONT.preloadOdometer();
        setTimeout(function(){
            var odometer = element.find('.odometer').first(); 
            var number = odometer.data('number');
            var duration = odometer.data('duration');

            var el = odometer[0];
            console.log(el);
            var od = new Odometer({
              el: el,
              value: 0,
              duration: duration,
             
              // Any option (other than auto and selector) can be passed in here
              format: '',
              theme: 'default'
            });
            console.log(od);
            od.update(parseInt(number));
        }, 50);
        
    };

    /**
     * Initialize all shop functions
     * @since 1.0.0
     */
    CL_FRONT.shopInit = CL_FRONT.init_cl_woocommerce = function(){
        "use strict";

        CL_FRONT.shopDropDown();
        CL_FRONT.isotopeShop();
    };



    /**
     * Style Woocommerce Dropdown
     * Load Select2 Plugin JS
     * @since 1.0.0
     */
    CL_FRONT.shopDropDown = function(){
        var $elements = $( '.woocommerce-ordering .orderby, .variations select' );
        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'select2.min.js' ], function() {
                    $element.select2({
                        minimumResultsForSearch: Infinity
                    });
                });
            });
        }
    };

    /**
     * Initialize Single Product Slider with Carousel
     * @since 1.0.0
     */
    /*CL_FRONT.shopProductSlider = function(){
        if( $( '.cl-images .cl-carousel' ).length > 0 )
            CL_FRONT.components.Carousel( $( '.cl-images .cl-carousel' ), {
                items:1,
                loop:false,
                center:true,
                URLhashListener:true,
                autoplayHoverPause:true,
                startPosition: 'URLHash',
                animateIn: 'alpha-in',
                animateOut: 'fadeOut'
            }, function( owl, el ){
                
                
                var onChangefunc = function(event){
                    var index = event.item.index;
                    var actived_id = $( event.currentTarget ).find('.active .cl-image-item').attr('data-hash');
                   
                    var thumbnails = $(event.currentTarget).closest('.images').find('.thumbnails');
                      
                    thumbnails.find('a').removeClass('active');
                    thumbnails.find('[href="#'+actived_id+'"]').addClass('active');
                };

                owl.on('translated.owl.carousel', onChangefunc );
                owl.on('initialize.owl.carousel', onChangefunc );
            } );
    };*/


    /*CL_FRONT.shopEasyZoom = function(){
        "use strict";
        var $elements = $( '.easyzoom' );
        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'easyzoom.js' ], function() {
                    var $easyzoom = $element.easyZoom();
                
                });
            });
        }
    };/*


    /**
     * Isotope Shop Init
     * used on Customizer too
     * 
     * @since 1.0.0
     */
    CL_FRONT.isotopeShop = CL_FRONT.init_cl_shop = function( $el ) {
        "use strict";
        $( '.shop-products' ).each(function(){
            if( $(this).hasClass('cl-carousel') )
                CL_FRONT.components.Carousel( $( this ) );
            else
                CL_FRONT.components.Isotope( $( this ) );
        })
        
    };



   


    CL_FRONT.footerReveal = function(){
        if( $('#footer-wrapper.reveal').length == 0 )
            return false;

        var footerHeight = $('#footer-wrapper').height();

        if( this.config.$viewport.hasClass('cl-layout-bordered') ){
            $('#footer-wrapper').width( this.config.$main.width() );
        }

        this.config.$main.css( 'margin-bottom', footerHeight ).css( 'background-color', '#ffffff' ).css('position', 'relative').css('z-index', 1);
    };


    CL_FRONT.restartAnimations = function( $el, force ){
        if( $el.length == 0 )
            return;

        $el.find( ' > .start_animation' ).removeClass('start_animation').addClass('animate_on_visible');
        setTimeout(function(){
            CL_FRONT.animations( $el, force );
        }, 20);
    }

    /* -------------------------------------------------------- */
    /* ----------------- COMPONENTS TO REUSE ------------------ */


    CL_FRONT.components.JustifyGallery = function( container ){
        var $elements = container;

        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'jquery.justifiedGallery.min.js' ], function() {

                    var $data = $element.data(),
                        $rowHeight = parseInt( CL_FRONT.helpers.parseData( $element.attr('data-rowheight'), 200 ) ),
                        $maxRowHeight = parseInt( CL_FRONT.helpers.parseData( $element.attr('data-maxheight'), 0 ) ),
                        $lastRow = CL_FRONT.helpers.parseData( $element.attr('data-lastrow'), 'nojustify' ),
                        $margins = parseInt( CL_FRONT.helpers.parseData( $element.attr('data-margins'), 15 ) );
               
                    $element.css( {opacity: 0} );
                    // Load justifyGallery after images loaded

                    
                        $element.imagesLoaded( function() {
                            //CL_FRONT.fixPostVideoHeight();
                            
                            $element.css( {opacity: 1} );

                            $element.justifiedGallery({
                                lastRow: $lastRow,
                                rowHeight: $rowHeight,
                                maxRowHeight: $maxRowHeight,

                                margins: $margins
                            });

                            if( typeof CL_FRONT['animations'] !== 'undefined' )
                                CL_FRONT.animations();
                            
                            CL_FRONT.rowParallax();
                        } );

                        if( $element.hasClass( 'filterable-entries' ) ){
                            $( '.cl-filters' ).on( 'click', 'button', function() {
                                var filterValue = $(this).attr('data-filter');
                                if( filterValue != '*' )
                                    $element.justifiedGallery({
                                        filter: filterValue
                                    }); 
                                else
                                    $element.justifiedGallery({
                                            filter: false
                                    }); 

                                CL_FRONT.restartAnimations( $element );
                        
                                $(this).parent().find('button.selected').removeClass('selected');
                                $(this).addClass('selected');

                            });
                        }
                        
                } );
            } );
        }
    }


    CL_FRONT.components.Isotope = function( container ){
        var $elements = container;

        if ( $elements.length ) {
            $elements.each( function( i ) {

                var $element = $( this );
               
                CL_FRONT.components.loadDependencies( [ codeless_global.FRONT_LIB_JS + 'isotope.js' ], function() {

                    var $data = $element.data(),
                        $transitionDuration = CL_FRONT.helpers.parseData( $data.transitionDuration, '0.4' ),
                        $layoutMode = CL_FRONT.helpers.parseData( $data.layoutMode, 'masonry' );

                    $element.css( {opacity: 0} );
                    // Load isotope after images loaded

                    
                        $element.imagesLoaded( function() {
                            CL_FRONT.fixPostVideoHeight();
                            if( $element.is('.blog-entries') )
                                CL_FRONT.fixPostMasonryHeight( $element );


                            if( $element.hasClass('masonry-entries') && $element.is('.portfolio-entries') )
                                CL_FRONT.fixPortfolioMasonryHeight( $element );

                            if( $element.is( '.blog-entries' ) && $element.is( '.grid_noimage-entries' ) )
                                $layoutMode = 'fitRows';

                            $element.css( {opacity: 1} );

                            var isotope_options = {
                                itemSelector: '.cl-isotope-item',
                                transformsEnabled: true,
                                filter: '*',
                                percentPosition: true,
                                transitionDuration: '0.0s',
                                layoutMode: $layoutMode
                            };
                            
                          

                            $element.isotope( isotope_options );
                            if( typeof CL_FRONT['animations'] !== 'undefined' )
                                CL_FRONT.restartAnimations( $element );
                            
                            $element.isotope('arrange');
                            console.log('rerun');
                            CL_FRONT.rowParallax();
                        } );
                        

                    

                    if( $element.hasClass( 'filterable-entries' ) ){
                            $( '.cl-filters' ).on( 'click', 'button', function() {
                                var filterValue = $(this).attr('data-filter');
                                if( filterValue != '*' )
                                    $element.isotope({
                                        filter: filterValue,
                                        sortBy: 'random'
                                    }); 
                                else
                                    $element.isotope({
                                            filter: filterValue,
                                            sortBy: 'original-order'
                                    }); 
                                
                                CL_FRONT.restartAnimations( $element );
                                $element.isotope('arrange');

                                $(this).parent().find('button.selected').removeClass('selected');
                                $(this).addClass('selected');

                            });
                    }

                } );
            } );
        }
    }



    /**
     * Parallax Effect Used on various parts of site
     * @since 1.0.0
     */

    CL_FRONT.components.Parallax = function( el ) {
        "use strict";



        var self = this,
            $this = el ,
            obj = $this[ 0 ],

            config = $this.data( 'parallax-config' ),
            headerHeight = null,
            offset = null,
            elHeight = null,
            ticking = false,
            isMobile = null;

        var clientRect = null;

        if( config == null )
            config = { speed: 0.3 };

        var update = function() {
            // Update Positions
            obj.style.transform = null;
            obj.style.top = null;
            obj.style.bottom = null;
            if ( CL_FRONT.config.$isMobileScreen ) {
                $this.css( 'height', '' );
                return;
            }

            clientRect = $this[ 0 ].getBoundingClientRect();

            offset = clientRect.top;

            elHeight = clientRect.height;
            headerHeight = 0;
          
            offset = offset - headerHeight + CL_FRONT.config.$windowTop;

            setPosition();
            setSize();
        };


        var h = 0,
            winH = 0,
            proportion = 0,
            height = 0;

        
        var setSize = function() {

            $this.css( 'height', '' );
            winH = CL_FRONT.config.$window.height() - headerHeight;
            h = obj.getBoundingClientRect().height;

            if ( config.speed <= 1 && config.speed > 0 ) {
                if ( offset === 0 ) {
                    $this.css( {
                        backgroundAttachment: 'scroll',
                        'will-change': 'transform'
                    } );
                } else {
                    $this.css( {
                        height: h + ( ( winH - h ) * config.speed ),
                        backgroundAttachment: 'scroll',
                        'will-change': 'transform'
                    } );
                }

            } else if ( config.speed > 1 && h <= winH ) {
                $this.css( {
                    // good for full heights - 2 because it's viewable by 2 screen heights
                    height: ( winH + ( ( winH * config.speed ) - winH ) * 2 ),
                    top: -( ( winH * config.speed ) - winH ),
                    backgroundAttachment: 'scroll',
                    'will-change': 'transform'
                } );

            } else if ( config.speed > 1 && h > winH ) {
                proportion = h / winH;
                height = ( winH + ( ( winH * config.speed ) - winH ) * ( 1 + proportion ) );

                $this.css( {
                    height: height,
                    top: -( height - ( winH * config.speed ) ),
                    backgroundAttachment: 'scroll',
                    'will-change': 'transform'
                } );

            } else if ( config.speed < 0 && h >= winH ) {
                height = h * ( 1 - config.speed );
                $this.css( {
                    height: height + ( height - h ),
                    top: h - height,
                    backgroundAttachment: 'scroll',
                    'will-change': 'transform'
                } );

            } else if ( config.speed < 0 && h < winH ) {
                // candidate to change
                var display = ( winH + h ) / winH;
                height = h * -config.speed * display;
                $this.css( {
                    height: h + ( height * 2 ),
                    top: -height,
                    backgroundAttachment: 'scroll',
                    'will-change': 'transform'
                } );
            }
        };


        var currentPoint = null,
            progressVal = null,
            startPoint = null,
            endPoint = null,

            scrollY = null;

        var setPosition = function() {
            ticking = false;

            if( scrollY == null )
                scrollY = window.scrollY;

            var currentScrollY = scrollY;
            if (!CL_FRONT.config.$isMobileScreen){
                
                startPoint = offset - winH;
               
                endPoint = offset + elHeight + winH - headerHeight;
                
                if ( currentScrollY < startPoint || currentScrollY > endPoint ) {
                    ticking = false;
                    return;
                }

                currentPoint = ( ( -offset + currentScrollY ) * config.speed );

                $this.css( {
                    '-webkit-transform': 'translateY(' + currentPoint + 'px) translateZ(0)',
                    '-moz-transform': 'translateY(' + currentPoint + 'px) translateZ(0)',
                    '-ms-transform': 'translateY(' + currentPoint + 'px) translateZ(0)',
                    '-o-transform': 'translateY(' + currentPoint + 'px) translateZ(0)',
                    'transform': 'translateY(' + currentPoint + 'px) translateZ(0)'
                } );

                
            }
        };


        var requestTick = function() {
           
            if ( !ticking ) {
                window.requestAnimationFrame( setPosition );
            }
            ticking = true;
            
        };

        var onScroll = function(){
            scrollY = window.scrollY;
            requestTick();
        }


        var init = function() {
            
            // Disable scroll effects when smooth scroll is disabled
            if ( !CL_FRONT.config.$isSmoothScroll || CL_FRONT.config.$isCustomizer ) {
                return;
            }

            update();
            setTimeout( update, 300 );

            CL_FRONT.config.$window.on( 'load', update );
            CL_FRONT.config.$window.on( 'resize', update );
            window.addEventListener('scroll', onScroll, false);

        };


        return {
            init: init
        };

    };


    CL_FRONT.components.loadAnimation = function( content, callback ){

        content.imagesLoaded( { background: true }, function(list){
          
            callback();
            content.addClass( 'cl-loaded-component' );
        });

    };


    /**
     * Core function for loading dinamically JS
     * 
     * @since 1.0.0
     */
    CL_FRONT.components.loadDependencies = function( dependencies, callback ) {
        "use strict";

        var _callback = callback || function() {};
        if ( !dependencies )
            return void _callback();

        var newDeps = dependencies.map( function( dep ) {
            return -1 === CL_FRONT.config._loadedDependencies.indexOf( dep ) ? "undefined" == typeof CL_FRONT.config._inQueue[ dep ] ? dep : ( CL_FRONT.config._inQueue[ dep ].push( _callback ), !0 ) : !1
        } );

        if ( newDeps[ 0 ] !== !0 ) {
            if ( newDeps[ 0 ] === !1 )
                return void _callback();
            var queue = newDeps.map( function( script ) {
                CL_FRONT.config._inQueue[ script ] = [ _callback ];
                return $.getCachedScript( script );
            } );

            var onLoad = function() {
                newDeps.map( function( loaded ) {
                    CL_FRONT.config._inQueue[ loaded ].forEach( function( callback ) {
                        callback()
                    } );
                    delete CL_FRONT.config._inQueue[ loaded ];
                    CL_FRONT.config._loadedDependencies.push( loaded )
                } );
            };

            $.when.apply( null, queue ).done( onLoad )
        }


    };


    


    /* ---------------------------------------------------*/
    /* ------------------ HELPERS FUNCTIONS --------------*/


    CL_FRONT.helpers.changeHeaderColor = function(element){
        
        var color = 'dark';
        if( CL_FRONT.config.$header.hasClass('cl-header-sticky-active') )
            return;


        if( element.find('.cl-row').hasClass('light-text') )
            color = 'light';
        
    
        if( color == 'light' && ! CL_FRONT.config.$header.hasClass('cl-header-light') ){
            CL_FRONT.config.$header.addClass('cl-header-light');
            CL_FRONT.config.$body.addClass('cl-header-light');
        }

        if( color == 'dark' && CL_FRONT.config.$header.hasClass('cl-header-light') ){
            CL_FRONT.config.$header.removeClass('cl-header-light');
            CL_FRONT.config.$body.removeClass('cl-header-light');
        }
            


    };

    CL_FRONT.helpers.recognizeColor = function(color){
        var rgb = '';
        if( CL_FRONT.helpers.includes(color, 'rgb') ){
            var match = color.match(/rgba?\((\d{1,3}), ?(\d{1,3}), ?(\d{1,3})\)?(?:, ?(\d(?:\.\d?))\))?/);
            rgb = match ? {
                0: match[1],
                1: match[2],
                2: match[3]
              } : {};


        }else{
            var isOk  = /(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(color);
            if( ! isOk )
                return 'none';
            rgb = CL_FRONT.helpers.hexToRgb(color);
            
        }
        

        var o = Math.round(((parseInt(rgb[0]) * 299) + (parseInt(rgb[1]) * 587) + (parseInt(rgb[2]) * 114)) /1000);
        if(o > 125) {
            return 'light';
        }else{ 
            return 'black';
        }

    };

    CL_FRONT.helpers.hexToRgb = function(hex){
        var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return result ? {
            r: parseInt(result[1], 16),
            g: parseInt(result[2], 16),
            b: parseInt(result[3], 16)
        } : null;
    };

    CL_FRONT.helpers.includes = function(container, value){
        var returnValue = false;
        var pos = container.indexOf(value);
        if (pos >= 0) {
            returnValue = true;
        }
        return returnValue;
    };

    CL_FRONT.helpers.loadCSS = function(href){
        var ss = document.styleSheets;
        for (var i = 0, max = ss.length; i < max; i++) {
            if (ss[i].href == href)
                return;
        }
        var link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = href;

        document.getElementsByTagName("head")[0].appendChild(link);
    }

    /**
     * Core function for loading dinamically JS
     * 
     * @since 1.0.0
     */
    $.getCachedScript = function( url, callback ) {
        "use strict";

        url = url.replace( /.*?:\/\//g, "" );

        if ( location.protocol === 'https:' )
            url = 'https://' + url;
        else
            url = 'http://' + url;

        var options = {
            dataType: "script",
            cache: false,
            url: url
        };

        return $.ajax( options ).done( callback );
    };


    /**
     * parse and sanitize value
     *
     * @since 1.0.0
     */
    CL_FRONT.helpers.parseData = function( val, fallback ) {
        "use strict";
        return ( typeof val !== 'undefined' ) ? val : fallback;
    };

    CL_FRONT.helpers.scroll = function() {
        "use strict";
        var offset = 0,
            $window = $(window),
            hasPageYOffset = (window.pageYOffset !== undefined),
            body = (document.documentElement || document.body.parentNode || document.body);

        var update = function() {
            offset = hasPageYOffset ? window.pageYOffset : body.scrollTop;
        };

        var rAF = function() {
            window.requestAnimationFrame(update);
        };

        update();
        $window.on('load', update);
        $window.on('resize', update);
        $window.on('scroll', rAF);

        
        return offset;
      
    };


    function initGMAP(){
        CL_FRONT.codelessGMap();
    }

    CL_FRONT.siteInit();

    if( typeof CL_FRONT.animations == 'undefined' ){

        CL_FRONT.animations = function( el, force ) { 
            if (!window.waypoint_animation) {
                window.waypoint_animation = function(el, force) {
                    
                    var notEl = (el == null) ? true : false;

                    if( el == null )
                        el = $('.animate_on_visible:not(.start_animation)');
                    else
                        el = el.find('.animate_on_visible:not(.start_animation)').andSelf();

                   
                    $.each(el, function(index, val) {
                        var run = true;
                        if ($(val).closest('.cl-slide').length > 0 || $(val).closest('.cl-slide-content').length > 0) run = false;
                       
                        if ($(val).closest('.cl-carousel').length > 0) run = false;

                        if ($(val).closest('#navigation').length > 0) run = false;

                        if( force )
                            run = true;
                        if (run) {
                            
                            CL_FRONT.components.loadDependencies([codeless_global.FRONT_LIB_JS + "waypoints.min.js"], function(){
                                
                                new Waypoint({
                                    element: val,
                                    handler: function() {
                                        var element = $(this.element),
                                            index = element.index(),
                                            delayAttr = element.attr('data-delay');
                                        
                                        if (delayAttr == undefined) delayAttr = 0;
                                        setTimeout(function() {
                                            element.addClass('start_animation');
                                            
                                            if( element.hasClass('cl_counter') )
                                                CL_FRONT.codelessCounter(element);

                                            if( element.hasClass('cl_progress_bar') )
                                                CL_FRONT.progressBar( element );

                                        }, delayAttr);
                                        this.destroy();
                                    },
                                    offset: '90%'
                                });
                            });
                            
                        }
                    });
                }
            }
            setTimeout(function() {
                window.waypoint_animation(el, force);
            }, 1);
        };
    }


    CL_FRONT.fullHeightRow = function($el) {
        "use strict";
        
        var $elements = $('.cl_row-fullheight');
        if ($elements.length) {
    
            $elements.each(function(i){
                var $element = $(this);
                
                if(i == 0){
                    var $window, windowHeight, offsetTop, fullHeight;
                    
                    $window = $(window);
                    windowHeight = $window.height();
                    
                    
                    offsetTop = $element.offset().top;
                    windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100), $element.css("min-height", fullHeight + "vh"));
                    
                    
                }else{
                    $element.css('min-height', '100vh');
                }
                
            });
            
        }
        
        if($el != null && $el.length)
            $el.css('min-height', 'auto');
    };
    
    
    CL_FRONT.fullHeightSlider = function($el) {
        "use strict";
        
        var $elements = $('.cl_slider-fullheight');
        if ($elements.length) {
    
            $elements.each(function(i){
                var $element = $(this);
                
                if(i == 0){
                    var $window, windowHeight, offsetTop, fullHeight;
                    
                    $window = $(window);
                    windowHeight = $window.height();
                    
                    
                    offsetTop = $element.offset().top;
                    windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100), $element.css("height", fullHeight + "vh"));
                    
                    
                }else{
                    $element.css('height', '100vh');
                }
                
            });
            
        }
        
        if($el != null && $el.length)
            $el.css('height', 'auto');
    };
    

    
    
    CL_FRONT.videoSection = function(){
        $.each($('.video-section'), function(index, val){
            var stream = $(val).data('stream');
            if(stream == 'youtube'){
                
                $.getCachedScript('https://www.youtube.com/player_api', function(){
                    var iframe_src = $(val).find('iframe').attr('src');
                    $(val).find('iframe')[0].src = iframe_src;
                    
                    var youtube = $(val).find('iframe')[0];
                    
                    var player;
                    setTimeout(function() {
                        player = new YT.Player(youtube);
                    }, 500);
                    
                    setTimeout(function() {
                        if(typeof player.playVideo == 'function'){
                            player.playVideo();
                            player.mute();
                        }
                    }, 2000);
                     
                    
                    
                    CL_FRONT.fixAspectRatio(val);
                    
                    $(window).resize(function(){
                        CL_FRONT.fixAspectRatio(val);
                    }).resize();
                    
                    $(val).css('opacity', 1);
                });
    
            }
            
            if(stream == 'vimeo'){
    
                    var iframe_src = $(val).find('iframe').attr('src');
                    $(val).find('iframe')[0].src = iframe_src;
                    CL_FRONT.fixAspectRatio(val);
                    
                    $(window).resize(function(){
                        CL_FRONT.fixAspectRatio(val);
                    }).resize();
                    
                    $(val).css('opacity', 1);
                    
                
            }
        });
    };
    
    
    CL_FRONT.fixAspectRatio = function(el){
        
        var parent = $(el), baseAspectRatio = 41.6, $videoHolder = parent.find('.cl-video-centered');
        var parentHeight = parent.height();
        var parentWidth = parent.width();
        var parentAspectRatio = (parentHeight / parentWidth) * 100;
    
        var width = (parentAspectRatio / baseAspectRatio) * 100,
                widthOverflow = (width - 100);
    
        if(parentAspectRatio > baseAspectRatio)
            $videoHolder.css({
                'padding-top': parentAspectRatio + '%',
                'width': width + '%',
                'left': -(widthOverflow / 2) + '%'
            }); 
    
    };


    CL_FRONT.wooQuantity = function(){
        if ( ! String.prototype.getDecimals ) {
            String.prototype.getDecimals = function() {
                var num = this,
                    match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if ( ! match ) {
                    return 0;
                }
                return Math.max( 0, ( match[1] ? match[1].length : 0 ) - ( match[2] ? +match[2] : 0 ) );
            }
        }
        // Quantity "plus" and "minus" buttons
        $( document.body ).on( 'click', '.plus, .minus', function(e) {
            e.preventDefault();
            var $qty        = $( this ).closest( '.quantity' ).find( '.qty'),
                currentVal  = parseFloat( $qty.val() ),
                max         = parseFloat( $qty.attr( 'max' ) ),
                min         = parseFloat( $qty.attr( 'min' ) ),
                step        = $qty.attr( 'step' );

            // Format values
            if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) currentVal = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( currentVal >= max ) ) {
                    $qty.val( max );
                } else {
                    $qty.val( ( currentVal + parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            } else {
                if ( min && ( currentVal <= min ) ) {
                    $qty.val( min );
                } else if ( currentVal > 0 ) {
                    $qty.val( ( currentVal - parseFloat( step )).toFixed( step.getDecimals() ) );
                }
            }

            // Trigger change event
            $qty.trigger( 'change' );
        });
    };

   
    

} )( jQuery );



function Parallax(options){
    options = options || {};
    this.nameSpaces = {
        wrapper: options.wrapper || '.parallax',
        layers: options.layers || '.parallax-layer',
        deep: options.deep || 'data-parallax-deep'
    };
    this.init = function() {
        var self = this,
            parallaxWrappers = document.querySelectorAll(this.nameSpaces.wrapper);
          for(var i = 0; i < parallaxWrappers.length; i++){
            (function(i){
                parallaxWrappers[i].addEventListener('mousemove', function(e){
                    var x = e.clientX,
                        y = e.clientY,
                        layers = parallaxWrappers[i].querySelectorAll(self.nameSpaces.layers);
                    for(var j = 0; j < layers.length; j++){
            (function(j){
              var deep = layers[j].getAttribute(self.nameSpaces.deep),
                  disallow = layers[j].getAttribute('data-parallax-disallow'),
                  itemX = (disallow && disallow === 'x') ? 0 : x / deep,
                  itemY = (disallow && disallow === 'y') ? 0 : y / deep;
                  if(disallow && disallow === 'both') return;
                  layers[j].style.transform = 'translateX(' + itemX + '%) translateY(' + itemY + '%)';
            })(j);  
                    }
                })
            })(i);
          }
    };
    this.init();
    return this;
}



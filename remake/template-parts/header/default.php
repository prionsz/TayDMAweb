<div class="cl-header-default">
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2 col-xs-4">
                    <div class="logo-wrapper">
                    <?php 
                        if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                            the_custom_logo();
                        }else{
                            echo '<a href="'.site_url().'"><img src="'. get_template_directory_uri() . '/img/logo.png' .'" alt="site-logo"></a>';
                        }
                    ?>
                    </div>
                </div>
                <div class="col-sm-10 menu-col col-xs-8">
                    <div class="menu-wrapper">
                        <?php

                            $args = array("theme_location" => "main", "container" => true, "fallback_cb" => false);

                            $menu_html = wp_nav_menu( $args );

                            echo codeless_complex_esc( $menu_html );

                        ?>
                        
                    </div>
                    <div class="cl-mobile-menu-button">
                            <span></span>
                            <span></span>
                            <span></span>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
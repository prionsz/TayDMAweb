<div class="ce-page-header">
    <div class="wrapper-content">
        <div class="container container-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-data">
                        <?php 
                        $title = get_the_title();
                        if( function_exists( 'is_shop' ) && is_shop() )
                            $title = get_the_title( woocommerce_get_page_id('shop') );

                        if( is_archive() )
                            $title = get_the_archive_title();

                        if( is_search() )
                            $title = esc_html__( 'Search Results', 'remake' );
                        ?>
                        <h1><?php echo codeless_complex_esc( $title ) ?></h1>
                        <?php 

                        $output = '<ul class="page_parents">';
                                    $output .= '<li class="home"><a href="'.esc_url(home_url()).'">'.esc_html__('Home', 'remake').'</a><span class="delimiter">/</span></li>';
                                        $page_parents = codeless_page_parents();
                                        if( $page_parents )
                                        for($i = count($page_parents) - 1; $i >= 0; $i-- ){
            
                                            $output .= '<li><a href="'.esc_url(get_permalink($page_parents[$i])).'">'.codeless_complex_esc(get_the_title($page_parents[$i])).'</a><span class="delimiter">/</span></li>';
            
                                        }
                                    if(!is_front_page())  
                                        $output .= '<li class="active"><a href="'.esc_url(get_permalink()).'">'.codeless_complex_esc($title).'</a></li>';
        
                        $output .= '</ul>';
                        echo codeless_complex_esc( $output );
                        
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
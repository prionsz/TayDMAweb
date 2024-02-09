<div class="cl-post-header">
    <?php if( codeless_get_post_header_style() == 'with_image' ): ?>
        <div class="wrapper-layers">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url(get_the_ID(),'full') );  ?>" alt="post-header"/>
            <div class="overlay"></div>
        </div>
    <?php endif; ?>
    <div class="wrapper-content">
        <div class="container container-content">
            <div class="row">
                <div class="col-sm-12">
                    <article>
                        <?php echo codeless_get_category_colored(); ?>
                        <h1><?php echo get_the_title() ?></h1>
                        <div class="entry-footer">
                            <?php codeless_output_entry_meta(false) ?>
                            <?php echo codeless_get_entry_tool_share(); ?>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
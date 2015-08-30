<?php if ( have_posts() ) { 
    while ( have_posts() ) {
    the_post();
    get_template_part( 'library/templates/format-single', get_post_format() );
    comments_template();
    //kopa_about_author(); //author
    }
}

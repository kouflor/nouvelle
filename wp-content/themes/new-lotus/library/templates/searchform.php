<form action="<?php echo esc_url( home_url() ); ?>" method="get" class="search-form">
    <input type="text"  name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php _e('Search this site',('new-lotus')); ?>" class="form-control kopa-search-input">
    <input class="kopa-search-submit fa fa-search" type="submit" value="">
    <button type="submit" class="kopa-icon-search fa fa-search"></button>
</form>



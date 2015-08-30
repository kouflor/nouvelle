
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php
    if ('enable' === kopa_get_option('kopa_theme_options_responsive_status', 'enable')) {
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
    }
    ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- Le fav and touch icons -->
    <?php if (kopa_get_option('favicon_url')) { ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url(kopa_get_option('favicon_url')); ?>">
    <?php } ?>
    <?php if (kopa_get_option('apple_iphone_icon_url')) { ?>
    <link rel="apple-touch-icon" sizes="57x57"
          href="<?php echo esc_url(kopa_get_option('apple_iphone_icon_url')); ?>">
    <?php } ?>

    <?php if (kopa_get_option('apple_ipad_icon_url')) { ?>
    <link rel="apple-touch-icon" sizes="72x72"
          href="<?php echo esc_url(kopa_get_option('apple_ipad_icon_url')); ?>">
    <?php } ?>

    <?php if (kopa_get_option('apple_iphone_retina_icon_url')) { ?>
    <link rel="apple-touch-icon" sizes="114x114"
          href="<?php echo esc_url(kopa_get_option('apple_iphone_retina_icon_url')); ?>">
    <?php } ?>

    <?php if (kopa_get_option('apple_ipad_retina_icon_url')) { ?>
    <link rel="apple-touch-icon" sizes="144x144"
          href="<?php echo kopa_get_option('apple_ipad_retina_icon_url'); ?>">
    <?php } ?>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>    
<header id="kopa-header">
    
    <div class="kopa-header-top">
        <div class="container">
            <span class="kopa-time pull-left font-heading"> 
                <?php
                $date_status = kopa_get_option('date_status');
                if ('1' === $date_status){
                    kopa_the_current_time();
                } ?>
            </span>

            <?php
                $topmenu = kopa_get_option('topmenu_status');
                if ('1' === $topmenu){
                    if(has_nav_menu('top-nav')){
                        $args = array(
                            'theme_location' => 'top-nav',
                            'container' => '',
                            'menu_class' => 'third-menu list-unstyled pull-right',
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                        );
                        wp_nav_menu( $args );
                    }
                }
                
            ?>
        </div>
    </div>
    <!-- kopa header top -->
    <div class="kopa-header-middle">
        <div class="container">
            <div id="kopa-logo" class="pull-left">
                <?php if( kopa_get_option( 'logo_url' ) ){ ?>
                    <a href="<?php echo esc_url(home_url()); ?>" class="img-responsive">
                        <img src="<?php echo esc_url(kopa_get_option( 'logo_url' )); ?>" alt="<?php bloginfo('name'); ?> <?php _e('Logo', 'new-lotus'); ?>">
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- kopa header middle -->
    <div class="kopa-header-bottom">
        <div class="wrap-main-menu">
            <div class="container">
                
                <?php
                    if(has_nav_menu('main-nav')){
                        $args = array(
                            'theme_location' => 'main-nav',
                            'container' => '',
                            'menu_class' => 'sf-menu main-menu',
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                        );
                        wp_nav_menu( $args ); ?>
                        <i class="mobile-menu-icon fa fa-align-justify"></i>
                        <?php $args = array(
                            'theme_location' => 'main-nav',
                            'container' => '',
                            'menu_class' => 'mobile-menu main-menu',
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                        );
                        wp_nav_menu( $args );
                    }
                ?>
               
                <?php
                    $search_box = kopa_get_option('search_status');
                    if ('1' === $search_box){ ?>
                         <div class="widget widget_search kopa-search" id="kopa-search">
                            <?php get_search_form(); ?>
                        </div>
                    <?php }
                ?>
                
            </div>
        </div>
    </div>
    <!-- kopa header bottom -->
</header>
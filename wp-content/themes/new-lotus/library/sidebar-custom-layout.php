<?php

// sidebar manager
add_filter('kopa_sidebar_default', 'kopa_extra_sidebar_manager_settings');

function kopa_extra_sidebar_manager_settings($options) {

    $options['sidebar_1'] = array(
        'name' => __('Right sidebar', 'new-lotus'),
        'description' => '',
    );
    $options['sidebar_2'] = array(
        'name' => __('Main col', 'new-lotus'),
        'description' => ''
    );
    $options['sidebar_3'] = array(
        'name' => __('Top footer', 'new-lotus'),
        'description' => __('Show social link', 'new-lotus')
    );
    $options['sidebar_4'] = array(
        'name' => __('Footer 1', 'new-lotus'),
        'description' => __('Show contact info', 'new-lotus'),
    );
    $options['sidebar_5'] = array(
        'name' => __('Footer 2', 'new-lotus'),
        'description' => __('Show categories', 'new-lotus'),
    );
    $options['sidebar_6'] = array(
        'name' => __('Footer 3', 'new-lotus'),
        'description' => __('Show archives', 'new-lotus')
    );
    $options['sidebar_7'] = array(
        'name' => __('Footer 4', 'new-lotus'),
        'description' => __('Show recent tweets', 'new-lotus')
    );
    return $options;
}

add_filter('kopa_sidebar_default_attributes', 'kopa_edit_common_attributes');

function kopa_edit_common_attributes($options) {
    $options['before_widget'] = '<div id="%1$s" class="widget %2$s">';
    $options['after_widget'] = '</div>';
    $options['before_title'] = '<header class="widget-header"><h3 class="widget-title">';
    $options['after_title'] = '</h3></header>';

    return $options;
}

/**
 * Custom layouts
 */
add_filter('kopa_layout_manager_settings', 'kopa_extra_layout_manager_settings');

function kopa_extra_layout_manager_settings($options) {
    $positions = array(
        'position_1' => __('Widget Area 1', 'new-lotus'),
        'position_2' => __('Widget Area 2', 'new-lotus'),
        'position_3' => __('Widget Area 3', 'new-lotus'),
        'position_4' => __('Widget Area 4', 'new-lotus'),
        'position_5' => __('Widget Area 5', 'new-lotus'),
        'position_6' => __('Widget Area 6', 'new-lotus'),
        'position_7' => __('Widget Area 7', 'new-lotus'),
    );


    //set layout for blog
    $blog = array(
        'title' => 'Blog',
        'preview' => get_template_directory_uri() . '/library/images/layouts/blog.png',
        'positions' => array(
            'position_1',
            'position_2',
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7',
        )
    );

    $blog_default = array(
        'position_1' => 'sidebar_1',
        'position_2' => 'sidebar_2',
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );

    //set layout for blog full width style 1
    $blog_fullwidth = array(
        'title' => __('Blog full width', 'new-lotus'),
        'preview' => get_template_directory_uri() . '/library/images/layouts/blog_fullwidth.png',
        'positions' => array(
            'position_2',
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7'
        )
    );

    $blog_fullwidth_default = array(
        'position_2' => 'sidebar_2',
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );

    //set layout for page full-width
    $page_fullwidth = array(
        'title' => __('Page full width', 'new-lotus'),
        'preview' => get_template_directory_uri() . '/library/images/layouts/page_fullwidth.png',
        'positions' => array(
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7'
        )
    );

    $page_fullwidth_default = array(
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );

    //set layout for page right sidebar
    $page = array(
        'title' => __('Page', 'new-lotus'),
        'preview' => get_template_directory_uri() . '/library/images/layouts/page.png',
        'positions' => array(
            'position_1',
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7'
        )
    );
//
    $page_default = array(
        'position_1' => 'sidebar_1',
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );


    //set layout for single
    $single = array(
        'title' => __('Single', 'new-lotus'),
        'preview' => get_template_directory_uri() . '/library/images/layouts/single.png',
        'positions' => array(
            'position_1',
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7'
        )
    );

    $single_default = array(
        'position_1' => 'sidebar_1',
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );

    //set layout for single full width
    $single_fullwidth = array(
        'title' => __('Single full width', 'new-lotus'),
        'preview' => get_template_directory_uri() . '/library/images/layouts/single_fullwidth.png',
        'positions' => array(
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7'
        )
    );

    $single_fullwidth_default = array(
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );

    //set layout for 404 right sidebar
    $page_404 = array(
        'title' => __('Page right sidebar', 'new-lotus'),
        'preview' => get_template_directory_uri() . '/library/images/layouts/404.png',
        'positions' => array(
            'position_1',
            'position_3',
            'position_4',
            'position_5',
            'position_6',
            'position_7',
        )
    );

    $page_404_default = array(
        'position_1' => 'sidebar_1',
        'position_3' => 'sidebar_3',
        'position_4' => 'sidebar_4',
        'position_5' => 'sidebar_5',
        'position_6' => 'sidebar_6',
        'position_7' => 'sidebar_7'
    );




    // blog layout
    $options['blog-layout']['positions'] = $positions;
    $options['blog-layout']['layouts'] = array(
        'blog' => $blog,
        'blog-fullwidth' => $blog_fullwidth,
    );
    $options['blog-layout']['default'] = array(
        'layout_id' => 'blog',
        'sidebars' => array(
            'blog' => $blog_default,
            'blog-fullwidth' => $blog_fullwidth_default,
        ),
    );

    // page layout
    $options['page-layout']['positions'] = $positions;
    $options['page-layout']['layouts'] = array(
        'page-fullwidth' => $page_fullwidth,
        'page' => $page,
    );
    $options['page-layout']['default'] = array(
        'layout_id' => 'page',
        'sidebars' => array(
            'page-fullwidth' => $page_fullwidth_default,
            'page' => $page_default,
        ),
    );

    // post layout
    $options['post-layout']['positions'] = $positions;
    $options['post-layout']['layouts'] = array(
        'single' => $single,
        'single-fullwidth' => $single_fullwidth,
    );
    
    $options['post-layout']['default'] = array(
        'layout_id' => 'single',
        'sidebars' => array(
            'single-fullwidth' => $single_fullwidth_default,
            'single' => $single_default,
        ),
    );

    //search layout
    $options['search-layout']['positions'] = $positions;
    $options['search-layout']['layouts'] = array(
        'blog' => $blog,
    );
    $options['search-layout']['default'] = array(
        'layout_id' => 'blog',
        'sidebars' => array(
            'blog' => $blog_default,
        ),
    );

    //404 layout
    $options['error404-layout']['positions'] = $positions;
    $options['error404-layout']['layouts'] = array(
        'page_404' => $page_404,
    );
    $options['error404-layout']['default'] = array(
        'layout_id' => 'page_404',
        'sidebars' => array(
            'page_404' => $page_404_default,
        ),
    );

    return $options;
}



add_filter('kopa_custom_template_setting_id','remove_frontpage_layout');

function remove_frontpage_layout($setting_id)
{
 if(is_front_page() && !is_home()){
  $setting_id = 'page-layout';
 }
 return $setting_id;
}
add_filter('kopa_layout_manager_settings','unset_frontpage_layout');
function unset_frontpage_layout($options)
{
 //remove frontpage tab from layout manager
 unset($options['frontpage-layout']);

 foreach($options as $key => $value){
  if($value['id'] == 'frontpage-title'){
   unset($options[$key]);
  }
 }
 return $options;
}
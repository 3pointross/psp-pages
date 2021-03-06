<?php
add_action( 'init', 'psp_pages_create_post_type' );
function psp_pages_create_post_type() {

    $slug = psp_get_option( 'psp_slug', 'panorama' );

    $labels = apply_filters( 'psp_pages_post_type_labels', array(
        'name'                => _x( 'Pages', 'Post Type General Name', 'psp_projects' ),
        'singular_name'       => _x( 'Page', 'Post Type Singular Name', 'psp_projects' ),
        'menu_name'           => __( 'Pages', 'psp_projects' ),
        'parent_item_colon'   => __( 'Parent Page:', 'psp_projects' ),
        'all_items'           => __( 'All Pages', 'psp_projects' ),
        'view_item'           => __( 'View Page', 'psp_projects' ),
        'add_new_item'        => __( 'Add New Page', 'psp_projects' ),
        'add_new'             => __( 'New Page', 'psp_projects' ),
        'edit_item'           => __( 'Edit Page', 'psp_projects' ),
        'update_item'         => __( 'Update Page', 'psp_projects' ),
        'search_items'        => __( 'Search Pages', 'psp_projects' ),
        'not_found'           => __( 'No pages found', 'psp_projects' ),
        'not_found_in_trash'  => __( 'No pages found in Trash', 'psp_projects' ),
    ) );

    $rewrite = apply_filters( 'psp_pages_post_type_rewrites', array(
        'slug'                => $slug . '-page',
        'with_front'          => true,
        'pages'               => true,
        'feeds'               => true,
    ) );

    $args = apply_filters( 'psp_pages_post_type_args', array(
        'label'               => __( 'psp_projects', 'psp_projects' ),
        'description'         => __( 'Pages', 'psp_projects' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'comments', 'revisions', 'author' ),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => false,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => false,
        'menu_position'       => 20,
        'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => $rewrite,
        'capability_type'     => 'page'
    ) );

    register_post_type( 'psp_pages', $args );

    do_action( 'psp_loaded_post_type_project' );

}

add_action( 'plugins_loaded', 'psp_register_pages_post_types', 10000 );

function psp_register_pages_post_types() {
    if( function_exists('acf_add_local_field_group') ):


        acf_add_local_field_group( apply_filters( 'psp_pages_access_fields', array(
        	'key' => 'group_5c486fcd9eeb6',
        	'title' => 'Page Access',
        	'fields' => array(
               array (
                    'key' => 'field_psp_login_pages',
                    'label' => __('Private Page','psp_projects'),
                    'name' => 'psp_pages_must_login',
                    'type' => 'checkbox',
                    'choices' => array (
                         'Yes' => __('Yes','psp_projects'),
                    ),
                    'default_value' => 'Yes',
                    'layout' => 'vertical',
                ),
        		array(
        			'key' => 'field_5c486fd92b229',
        			'label' => 'Associated Project(s)',
        			'name' => 'associated_projects',
        			'type' => 'relationship',
        			'instructions' => 'Select which project(s) this page should be linked from.',
        			'required' => 0,
        			'conditional_logic' => array(
                         array(
                              array(
                                   'field'        => 'field_psp_login_pages',
                                   'operator'     =>   '==',
                                   'value'        =>   'Yes'
                              )
                         )
                    ),
        			'wrapper' => array(
        				'width' => '',
        				'class' => '',
        				'id' => '',
        			),
        			'post_type' => array(
        				0 => 'psp_projects',
        			),
        			'taxonomy' => '',
        			'filters' => array(
        				0 => 'search',
        			),
        			'elements' => '',
        			'min' => '',
        			'max' => '',
        			'return_format' => 'id',
        		),
     		array(
     			'key' => 'field_psp_access_teams',
     			'label' => 'Teams',
     			'name' => 'psp_pages_teams',
     			'type' => 'relationship',
     			'instructions' => 'What teams can access this content?',
     			'required' => 0,
                    'conditional_logic' => array(
                         array(
                              array(
                                   'field'        => 'field_psp_login_pages',
                                   'operator'     =>   '==',
                                   'value'        =>   'Yes'
                              )
                         )
                    ),
     			'wrapper' => array(
     				'width' => '',
     				'class' => '',
     				'id' => '',
     			),
     			'post_type' => array(
     				0 => 'psp_teams',
     			),
     			'taxonomy' => '',
     			'filters' => array(
     				0 => 'search',
     			),
     			'elements' => '',
     			'min' => '',
     			'max' => '',
     			'return_format' => 'id',
     		),
     		array(
     			'key' => 'field_psp_access_users',
     			'label' => 'Users',
     			'name' => 'psp_pages_users',
     			'type' => 'user',
     			'instructions' => '',
     			'required' => 0,
                    'conditional_logic' => array(
                         array(
                              array(
                                   'field'        => 'field_psp_login_pages',
                                   'operator'     =>   '==',
                                   'value'        =>   'Yes'
                              )
                         )
                    ),
     			'wrapper' => array(
     				'width' => '',
     				'class' => '',
     				'id' => '',
     			),
     			'role' => '',
     			'allow_null' => 0,
     			'multiple' => 1,
     			'return_format' => 'id',
     		),
        	),
        	'location' => array(
        		array(
        			array(
        				'param' => 'post_type',
        				'operator' => '==',
        				'value' => 'psp_pages',
        			),
        		),
        	),
        	'menu_order' => 0,
        	'position' => 'side',
        	'style' => 'default',
        	'label_placement' => 'top',
        	'instruction_placement' => 'label',
        	'hide_on_screen' => '',
        	'active' => 1,
        	'description' => '',
        ) ) );

    endif;

}

add_action( 'psp_after_panorama_loaded', 'psp_pages_fields' );
function psp_pages_fields() {



}

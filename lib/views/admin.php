<?php
add_action( 'admin_menu', 'psp_pages_add_menu_link', 999 );
function psp_pages_add_menu_link() {
    global $submenu;
    $submenu[ 'edit.php?post_type=psp_projects' ][] = array( __( 'Pages', 'psp_projects' ), 'read', admin_url() . 'edit.php?post_type=psp_pages' );
}

add_action( 'psp_head', 'psp_pages_assets' );
function psp_pages_assets() {

    if( 'psp_pages' != get_post_type() ) return;

    psp_enqueue_style( 'psp-pages', PSP_PAGES_URL . 'assets/psp-pages.css' );

}

add_filter( 'psp_settings_sections_addons', 'psp_pages_settings_section' );
add_filter( 'psp_settings_addons', 'psp_pages_settings' );

function psp_pages_settings_section( $sections ) {

    $sections[ 'psp_pages_settings' ] = __( 'Panorama Pages', 'psp-front-edit' );

    return $sections;

}

function psp_pages_settings( $settings ) {

    $psp_pages_settings[ 'psp_pages_settings' ] = array(
        'psp_pages_title'  => array(
            'id' => 'psp_pages_title',
            'name' => '<h2>' . __( 'Project Panorama Pages', 'psp-front-edit' ) . '</h2>',
            'type' => 'html',
        ),
        'psp_project_pages_menu' => array(
            'id'    => 'psp_project_pages_menu',
            'name'  => __( 'Project Pages Menu Location', 'psp-front-edit' ),
            'desc'  => __( 'Select if where you\'d the nested pages menu should appear on projects.', 'psp-front-edit' ),
            'type'  => 'select',
            'options'   =>  array(
                'below_docs'    =>  __( 'Below documents', 'psp_projects' ),
                'top_menu'      =>  __( 'Top menu', 'psp_projects' )
            )
        ),
        'psp_pages_show_global_nav' => array(
             'id'      =>   'psp_pages_show_global_nav',
             'name'    =>   __( 'Enable global pages nav', 'psp_projects' ),
             'type'    =>   'select',
             'options'  =>   array(
                  'yes' =>   __( 'Yes', 'psp_projects' ),
                  'no' => __( 'No', 'psp_projects' )
                  )
        ),
        'psp_pages_global_nav_label' => array(
             'id'      => 'psp_pages_global_nav_label',
             'name'    => __( 'Global Nav Label', 'psp_projects' ),
             'type'    => 'text',
             'default' => 'Menu',
        ),
        'psp_pages_mobile_nav_label' => array(
             'id'      => 'psp_pages_mobile_nav_label',
             'name'    => __( 'Mobile Nav Label', 'psp_projects' ),
             'type'    => 'text',
             'default' => 'More',
        ),
    );

    return array_merge( $settings, $psp_pages_settings );

}

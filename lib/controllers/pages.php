<?php
add_filter( 'template_include', 'psp_pages_template_page' );
function psp_pages_template_page( $template ) {

    if( 'psp_pages' != get_post_type() ) return $template;

    return apply_filters( 'psp_pages_single_template', PSP_PAGES_PATH . 'lib/views/templates/page.php' );

}

add_action( 'psp_footer', 'psp_include_footer_call' );
function psp_include_footer_call() {

    if( psp_get_option('psp_enable_wp_footer') || 'psp_pages' != get_post_type() ) return false;

    wp_footer();

}

add_action( 'psp_head', 'psp_project_page_styles' );
function psp_project_page_styles() {

    psp_register_style( 'psp-pages', PSP_PAGES_URL . 'assets/psp-pages.css' );

    if( psp_get_option('psp_enable_wp_header') || 'psp_pages' != get_post_type() ) return false;

    wp_head();

}

add_filter( 'psp_get_the_title', 'pspp_return_the_title' );
function pspp_return_the_title( $title ) {

     if( get_post_type() !== 'psp_pages' ) {
          return $title;
     }

     return wp_title( false, false );

}

function psp_get_global_pages() {

     if( !is_user_logged_in() ) {
          return psp_get_public_pages();
     }

     $cuser    = wp_get_current_user();
     $team_ids = psp_get_team_ids( $cuser->ID );

     $team_meta = array();

     if($team_ids) {
          foreach( $team_ids as $team_id ) {
               $team_meta[] = array(
                    'key'     => 'psp_pages_teams',
                    'value'   => '"' . $team_id . '"',
                    'compare' =>   'LIKE'
               );
          }
     }

     $args = array(
          'post_type'    =>   'psp_pages',
          'posts_per_page'    =>   -1,
     );

     $meta_query = array(
          'relation' =>   'OR',
          array(
               'key'     =>   'psp_pages_users',
               'value'   =>   '"' . $cuser->ID . '"',
               'compare' =>   'LIKE'
          ),
          array(
               'key'     =>   'psp_pages_must_login',
               'value'   =>   'Yes',
               'compare' =>   '!='
          )
     );

     if( !empty($team_meta) ) {
          $meta_query = array_merge( $meta_query, $team_meta );
     }

     $args['meta_query'] = $meta_query;

     $args = apply_filters( 'psp_pages_global_pages_args', $args, $cuser );

     $pages = new WP_Query($args);

     if( !$pages->have_posts() ) {

          wp_reset_query(); wp_reset_postdata();

          return false;
     }

     $page_ids = array();

     while( $pages->have_posts() ): $pages->the_post();
          $page_ids[] = get_the_ID();
     endwhile;

     wp_reset_query(); wp_reset_postdata();

     return $page_ids;

}

function psp_get_public_pages() {

     $args = array(
          'post_type'    =>   'psp_pages',
          'posts_per_page'    =>   -1,
          'meta_query'   =>   array(
               array(
                    'key'   =>   'psp_pages_must_login',
                    'value' =>   'Yes',
                    'compare' => 'NOT'
               )
          )
     );

     $pages = new WP_Query($args);

     if( !$pages->have_posts() ) {

          wp_reset_query(); wp_reset_postdata();

          return false;
     }

     $page_ids = array();

     while( $pages->have_posts() ): $pages->the_post();
          $page_ids[] = get_the_ID();
     endwhile;

     wp_reset_query(); wp_reset_postdata();

     return $page_ids;

}

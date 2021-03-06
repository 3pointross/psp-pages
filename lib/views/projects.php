<?php
function psp_get_associated_psp_pages( $post_id = null ) {

    if( $post_id == null || get_post_type($post_id) !== 'psp_projects' ) {
        return false;
    }

    $args = array(
        'post_type'         =>  'psp_pages',
        'posts_per_page'    =>  -1,
        'meta_query'        =>  array(
            array(
                'key'       =>  'associated_projects',
                'value'     =>  '"' . $post_id . '"',
                'compare'   =>  'LIKE'
            )
        )
    );

    $associated_pages = new WP_Query($args);

    // Reset the query for safety
    wp_reset_query(); wp_reset_postdata();

    return $associated_pages;

}

function pspp_user_has_page_access() {

   if( !get_field('psp_pages_must_login') || current_user_can('edit_others_psp_projects') ) {
        return true;
   }

   $cuser = wp_get_current_user();

    if( $teams = get_field('psp_pages_teams') ) {

         $team_ids = psp_get_team_ids( $cuser->ID );
         $matches  = array_intersect( $teams, $team_ids );

         if( $matches ) {
              return true;
         }

    }

    if( $users = get_field('psp_pages_users') ) {

         if( in_array( $cuser->ID, $users ) ) {
              return true;
         }

    }

    return false;

}

add_filter( 'template_include', 'pspp_template_chooser', 100, 1 );
function pspp_template_chooser( $template ) {

     if( get_post_type() != 'psp_pages' ) {
          return $template;
     }

     if( get_field('psp_pages_must_login') && !is_user_logged_in() ) {
          add_filter( 'psp_body_classes', 'psp_add_login_template_to_body_class' );
          return apply_filters( 'psp_login_template', psp_template_hierarchy( 'global/index' ) );
     }

     return $template;

}

add_action( 'psp_after_documents', 'pspp_list_pages_on_project', 10000 );
function pspp_list_pages_on_project() {

    $menu_location = psp_get_option('psp_project_pages_menu');

    if( $menu_location !== 'below_docs' ) {
        return;
    }

    $post_id = get_the_ID();

    $associated_pages = psp_get_associated_psp_pages( $post_id );

    if( !$associated_pages || !$associated_pages->have_posts() ) {
        return false;
    } ?>

    <div class="pspp-pages">

        <h4><?php echo esc_html_e( 'Pages', 'psp_projects' ); ?></h4>

        <ul class="psp-page-list">
            <?php while( $associated_pages->have_posts() ): $associated_pages->the_post(); global $post; ?>
                <li class="<?php echo esc_attr( $post->post_name ); ?>"><a href="<?php echo esc_url(get_the_permalink() . '?ref_project=' . $post_id ); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; ?>
        </ul>

</div> <!--/.pspp-pages-->

    <?php
    wp_reset_query(); wp_reset_postdata();

}

add_filter( 'psp_section_nav_items', 'psp_pages_in_nav_menu' );
function psp_pages_in_nav_menu( $menu_items ) {

    $menu_location = psp_get_option('psp_project_pages_menu');

    if( $menu_location !== 'top_menu' ) {
        return $menu_items;
    }

    $post_id = get_the_ID();

    $associated_pages = psp_get_associated_psp_pages( $post_id );

    if( !$associated_pages || !$associated_pages->have_posts() ) {
        return $menu_items;
    }

    while( $associated_pages->have_posts() ) { $associated_pages->the_post();

        global $post;

        $menu_items[ $post->post_name ] = array(
            'name' =>  get_the_title( $post->ID ),
            'slug'    =>  'nav-' . $post->post_name,
            'url'  =>  get_the_permalink( $post->ID ),
            'icon'  =>  '',
        );
    };

    return $menu_items;

}

add_action( 'wp_enqueue_scripts', 'psp_pages_master_script' );
function psp_pages_master_script() {

     if( get_post_type() != 'psp_pages' || !function_exists('psp_front_assets') ) {
          return;
     }

     psp_front_assets( true );

}

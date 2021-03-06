<?php
add_action( 'psp_section_nav_actions_start', 'psp_global_user_pages_nav' );
function psp_global_user_pages_nav() {

     if( psp_get_option('psp_pages_show_global_nav') == 'no' ) {
          return;
     }

     $pages = psp_get_global_pages();

     if( empty($pages) || !$pages->have_posts() ) {
          return;
     } ?>

     <div class="psp-section-nav__items psp-global-pages-nav">
          <div class="psp-section-nav__item">
               <span class="psp-section-nav__item-title">
                    <i class="fa fa-file-o"></i>
                    <?php
                    $label = ( psp_get_option('psp_pages_global_nav_label') ? psp_get_option('psp_pages_global_nav_label') : __( 'Pages', 'psp_projects' ) );
                    echo esc_html($label); ?>
               </span>
               <div class="psp-section-nav__items">
                    <div class="psp-section-nav__items-wrap">
                         <?php while( $pages->have_posts() ): $pages->the_post(); ?>
                              <div class="psp-section-nav__item"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                         <?php endwhile; ?>
                    </div>
               </div>
          </div>
     </div>

     <?php
}

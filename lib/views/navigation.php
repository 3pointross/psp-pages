<?php
add_action( 'psp_section_nav_actions_end', 'psp_global_user_pages_nav', 11 );
function psp_global_user_pages_nav() {

     if( psp_get_option('psp_pages_show_global_nav') == 'no' ) {
          return;
     }

     $pages = psp_get_global_pages();

     if( empty($pages) ) {
          return;
     } ?>

     <div class="psp-section-nav__items psp-global-pages-nav">
          <div class="psp-section-nav__item">
               <span class="psp-section-nav__item-title">
                    <i class="fa fa-bars"></i>
                    <?php
                    $label = ( psp_get_option('psp_pages_global_nav_label') ? psp_get_option('psp_pages_global_nav_label') : __( 'Menu', 'psp_projects' ) );
                    echo esc_html($label); ?>
               </span>
               <div class="psp-section-nav__items">
                    <div class="psp-section-nav__items-wrap">
                         <?php foreach( $pages as $page_id ): ?>
                              <div class="psp-section-nav__item"><a href="<?php echo esc_url( get_the_permalink($page_id) ); ?>"><?php echo esc_html( get_the_title($page_id) ); ?></a></div>
                         <?php endforeach; ?>
                    </div>
               </div>
          </div>
     </div>

     <?php
     wp_reset_query();

}

add_action( 'psp_after_sub_nav_items', 'psp_pages_custom_navigation' );
function psp_pages_custom_navigation() {

     if( psp_get_option('psp_pages_show_global_nav') == 'no' ) {
          return;
     }

     $pages = psp_get_global_pages();

     if( empty($pages) ) {
          return;
     }  ?>

     <li>
          <?php
          $label = ( psp_get_option('psp_pages_mobile_nav_label') ? psp_get_option('psp_pages_mobile_nav_label') : __( 'More', 'psp_projects' ) ); ?>
          <a href="#"><i class="fa fa-bars"></i>
 <?php echo esc_html($label); ?></a>
          <ul>
               <?php foreach( $pages as $page_id ): ?>
                    <li><a href="<?php echo esc_url( get_the_permalink($page_id) ); ?>"><?php echo esc_html( get_the_title($page_id) ); ?></a></li>
               <?php endforeach; ?>
          </ul>
     </li>

     <?php

}

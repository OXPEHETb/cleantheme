<?php
/*---top_menu привет---*/
if (function_exists('add_theme_support')) {
 add_theme_support('menus');
}

register_nav_menus( array(

'top_menu' => __( 'Верхнее меню' ),

) );

/*---Raw привет---*/
function my_formatter($content) {
$new_content = '';
$pattern_full = '{(\[raw\].*?\[/raw\])}is';
$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
foreach ($pieces as $piece) {
if (preg_match($pattern_contents, $piece, $matches)) {
$new_content .= $matches[1];
} else {
$new_content .= wptexturize(wpautop($piece));
}
}
return $new_content;
}
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'my_formatter', 99);


/*---More Досвиданья---*/
  function remove_more_tags($link) {
      $offset = strpos($link, '#more-');
      if ($offset) {
          $end = strpos($link, '"',$offset);
      }
      if ($end) {
          $link = substr_replace($link, '', $offset, $end-$offset);
      }
      return $link;
  }
  add_filter('the_content_more_link', 'remove_more_tags');


// убрать непонятные ссылки для Windows Live Writer
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action( 'wp_head', 'dns-prefetch' );

// отключить вывод мета тэга "generator"
remove_action('wp_head', 'wp_generator');
remove_action( 'wp_head', 'wp_resource_hints', 2 );


// REMOVE EMOJI ICONS
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter( 'emoji_svg_url', '__return_false' );


remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );


// скрыть версию WordPress
function gb_hide_wp_ver()
{
    return '';
}
add_filter('the_generator','gb_hide_wp_ver');
function secure_remove_wp_ver_css_js($src) {
    if(strpos($src, 'ver='))
      $src = remove_query_arg('ver', $src);
    return $src;
}
 
add_filter('style_loader_src', 'secure_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'secure_remove_wp_ver_css_js', 9999);

/*----Сайдбары----*/
add_action( 'widgets_init', 'registriruem_sidebari' ); 

function registriruem_sidebari() {
register_sidebar(
  array(
    'id' => 'primary',
    'name' => __( 'Сайдбар' ),
    'description' => __( 'Это сайдбар' ),
    'before_widget' => '<div class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="winget-title">',
    'after_title' => '</h4>'
    )
   );
}


/*-- The Excerpt без скобочек  --*/
add_filter('excerpt_more', function($more) {
  return '...';
});
/*-- The Excerpt длина анонса  --*/
function new_excerpt_length($length) {
  return 45;
}
add_filter('excerpt_length', 'new_excerpt_length');


/*--all in one seo goodbuy--*/

if(!function_exists('before_header_ox_fix') && !function_exists('after_header_ox_fix') && !function_exists('change_aioseop_tag_ox_fix')){
add_action('template_redirect', 'before_header_ox_fix', 0);
add_action('wp_head', 'after_header_ox_fix', 900);
function before_header_ox_fix (){
ob_start('change_aioseop_tag_ox_fix');
}
function change_aioseop_tag_ox_fix($head) {
$head_description = preg_replace("~(<meta name=\"description\" content=\".*\" />)\n~Uis", '$1', $head);
if($head_description !== NULL) $head = $head_description;
$head_keywords = preg_replace("~(<meta name=\"keywords\" content=\".*\" />)\n~Uis", '$1', $head);
if($head_keywords !== NULL) $head = $head_keywords;
return preg_replace("~(\n<!-- All in One SEO Pack .* by Michael Torbert of Semper Fi Web Design\[.*\] -->\n)(.*)(<!-- /all in one seo pack -->\n)~Uis", '$2', $head);
}
function after_header_ox_fix() {
ob_end_flush();
}
}

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
  function start_lvl(&$output, $depth) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"sub-menu dropdown-menu\">\n";
  }
}

add_filter( 'document_title_separator', function(){ return ' | '; } );

//отключение обновления плагинов start
function disable_updates($value) {
   unset($value->response['advanced-custom-fields-pro-master/acf.php']);
   return $value;
}
add_filter('site_transient_update_plugins', 'disable_updates');
//отключение обновления плагинов end


function modify_read_more_link() {
    return '<a class="more-link btn btn-default" href="' . get_permalink() . '">Читать далее...</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );



function bootstrap_pagination( $echo = true ) {
  global $wp_query;

  $big = 999999999; // need an unlikely integer

  $pages = paginate_links( array(
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format' => '?paged=%#%',
      'current' => max( 1, get_query_var('paged') ),
      'total' => $wp_query->max_num_pages,
      'type'  => 'array',
      'prev_next'   => true,
      'prev_text'    => __('«'),
      'next_text'    => __('»'),
    )
  );

  if( is_array( $pages ) ) {
    $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');

    $pagination = '<ul class="pagination btn-group">';

    foreach ( $pages as $page ) {
      $pagination .= '<li class="btn btn-more">' . $page . '</li>';
    }

    $pagination .= '</ul>';

    if ( $echo ) {
      echo $pagination;
    } else {
      return $pagination;
    }
  }
}


/*bootstrap 4*/

class bootstrap_4_walker_nav_menu extends Walker_Nav_menu {
    
    function start_lvl( &$output, $depth ){ // ul
        $indent = str_repeat("\t",$depth); // indents the outputted HTML
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "\n$indent<ul class=\"sub-menu dropdown-menu$submenu depth_$depth\">\n";
    }
  
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ){ // li a span
        
    $indent = ( $depth ) ? str_repeat("\t",$depth) : '';
    
    $li_attributes = '';
        $class_names = $value = '';
    
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        
        $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_anchestor) ? 'active' : '';
        $classes[] = 'nav-item';
        $classes[] = 'nav-item-' . $item->ID;
        if( $depth && $args->walker->has_children ){
            $classes[] = 'dropdown-menu';
        }
        
        $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr($class_names) . '"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        
        $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';
        
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $attributes .= ( $args->walker->has_children ) ? ' class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="nav-link"';
        
        $item_output = $args->before;
        $item_output .= ( $depth > 0 ) ? '<a class="dropdown-item"' . $attributes . '>' : '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters ( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    
    }
    
}

add_action( 'admin_menu', 'ox_remove_menu_items' );
 
function ox_remove_menu_items() {
    // тут мы укахываем ярлык пункты который удаляем.
    //remove_menu_page( 'index.php' );                  // Консоль
    remove_menu_page( 'edit.php' );                   // Записи
    remove_menu_page( 'post-new.php' );                 // Новые записи
    remove_menu_page( 'upload.php' );                 // Медиафайлы
    remove_menu_page( 'edit.php?post_type=page' );    // Страницы
    remove_menu_page( 'edit-comments.php' );          // Комментарии
    remove_menu_page( 'themes.php' );                 // Внешний вид
    remove_menu_page( 'plugins.php' );                // Плагины
    remove_menu_page( 'users.php' );                  // Пользователи
    remove_menu_page( 'tools.php' );                  // Инструменты
    remove_menu_page( 'options-general.php' );        // Настройки
    //remove_menu_page( 'edit.php?post_type=acf-field-group' );        // acf
  
}
/*
if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Контакты',
    'menu_title'  => 'Контакты',
    'menu_slug'   => 'contacts',
    'capability'  => 'edit_posts',
    'redirect'    => false,
    'update_button'   => __('Сохранить', 'acf'),
    'updated_message' => __("Настройки сохранены", 'acf'),
    'icon_url' => 'dashicons-phone'
  ));

  
}
*/
function phone_format($phone_format) {
    $pfx_phone = substr($phone_format, 0, 3);
    $thre_phone = substr($phone_format, 3, 3);
    $two_phone = substr($phone_format, 6, 2);
    $last_phone = substr($phone_format, -2);

    $good_phone = '+7 (' . $pfx_phone .') ' . $thre_phone . '-' . $two_phone . '-' . $last_phone;
    return $good_phone;
}


?>
<?php
if (!defined('ABSPATH')) exit;
add_action('after_setup_theme',function(){
 add_theme_support('title-tag');add_theme_support('post-thumbnails');add_theme_support('responsive-embeds');
 add_theme_support('html5',['search-form','gallery','caption','style','script']);
 add_theme_support('editor-styles');add_editor_style('editor.css');
 add_theme_support('align-wide');register_nav_menus(['primary'=>'Основное меню']);
 if(defined('WC_VERSION'))add_theme_support('woocommerce');
});
add_action('wp_enqueue_scripts',function(){
 wp_enqueue_style('kl-theme',get_stylesheet_uri(),[],wp_get_theme()->get('Version'));
 wp_enqueue_script('kl-theme',get_template_directory_uri().'/app.js',[],wp_get_theme()->get('Version'),true);
});
function kl_url($path=''){return esc_url(home_url('/'.trim($path,'/').($path?'/':'')));}
function kl_image($id,$fallback=''){
 $url=get_the_post_thumbnail_url($id,'large');
 if(!$url)$url=get_post_meta($id,'_kl_image',true);
 return esc_url($url?:get_template_directory_uri().'/assets/'.$fallback.'.png');
}
function kl_photo($file,$alt,$class=''){
 $source=get_template_directory_uri().'/assets/'.$file.'.png';
 if(in_array($file,['linea-house','forma-hero','redakcia-city'],true)&&get_theme_mod('kl_hero_image'))$source=get_theme_mod('kl_hero_image');
 echo '<img class="'.esc_attr($class).'" src="'.esc_url($source).'" alt="'.esc_attr($alt).'" width="1440" height="960" decoding="async">';
}
function kl_posts($type='post',$count=6,$extra=[]){return get_posts(array_merge(['post_type'=>$type,'numberposts'=>$count,'post_status'=>'publish','orderby'=>'menu_order date','order'=>'ASC'],$extra));}
function kl_arrow(){echo '<svg aria-hidden="true" viewBox="0 0 24 24" width="23" height="23" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 12h17M13 5l7 7-7 7"/></svg>';}
function kl_search(){echo '<form class="search-form" role="search" method="get" action="'.esc_url(home_url('/')).'"><label class="sr-only" for="site-search">Поиск по сайту</label><input id="site-search" type="search" name="s" value="'.esc_attr(get_search_query()).'" placeholder="Поиск по журналу"><button aria-label="Найти" type="submit"><svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="10" cy="10" r="7"/><path d="m15 15 6 6"/></svg></button></form>';}
function kl_contact_form(){
 if(isset($_GET['sent']))echo '<div class="form-success" role="status">Тестовая заявка сохранена. Письмо не отправляется; это демонстрационный проект.</div>';
 echo '<form class="contact-form" action="'.esc_url(admin_url('admin-post.php')).'" method="post"><input type="hidden" name="action" value="kl_inquiry">';
 wp_nonce_field('kl_inquiry','kl_nonce');
 echo '<label>Имя для тестовой заявки<input name="name" required maxlength="80" autocomplete="off"></label><label>Тестовый email<input name="email" type="email" required maxlength="160" placeholder="demo@example.com" autocomplete="off"></label><label>Описание задачи<textarea name="message" required maxlength="3000" rows="5"></textarea></label><div class="honey" aria-hidden="true"><label>Оставьте пустым<input name="website" tabindex="-1" autocomplete="off"></label></div><p class="fine">Используйте вымышленные данные. Заявка остаётся в демобазе, email не отправляется.</p><button class="button" type="submit">Сохранить тестовую заявку</button></form>';
}

function kl_mod($key,$fallback){$v=get_theme_mod($key,'');return $v!==''?$v:$fallback;}

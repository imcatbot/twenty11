<?php
/*
  Template Name: Display by category
*/

$next_page = 1;

$next_page = isset( $_GET['next'] ) ? $_GET['next']: 1;


get_header(); ?>

		<div id="container">
			<div id="content" role="main">
  <div id="head_ads"><?php print $head_ads;?></div>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<span class="entry-title"></span>
					<?php } else { ?>
						<div class="my-entry-title">当前位置:<?php the_title(); ?></div>	
<?php $current_page_link = get_permalink(); ?>
					<?php } ?>

					<div class="entry-content">
						   <?php the_content(); ?>
						   <?php
						   // 得到所有分类列表
						   //$this_category_name = "经典案例";

						   //从自定义中得到分类
						   $mykey_values = get_post_custom_values('this_category_name');
$this_category_name = $mykey_values[0];

//取得每页的显示数量，默认20
$my_post_num = 20;
$mykey_values = get_post_custom_values('this_post_num');
if ($mykey_values) {
  foreach ( $mykey_values as $key => $value ) {
    $my_post_num = $value;
  }
}
					   
$categories = get_categories();

$my_offset = ( $next_page - 1) * $my_post_num;
					   // 循环所有分类
					   foreach ($categories as $cat) {
					     
					   // 得到分类ID
					   $catid = $cat->cat_ID;
					   $catname = get_cat_name($catid);
  
					   if ($catname == $this_category_name) {
					     
					     $args = array('category' => $catid,
							   'numberposts' => -1,
							   'offset'      => 0,
							   );
					     $myposts = get_posts( $args );
					     $total_num = count($myposts);
					     $i = 0;
					     $j = 0;
					   foreach( $myposts as $post )  : 
					     if ($i < $my_offset) {
					       $i++;
					       continue;
					     }
					     if ( $j < $my_post_num ) {
					       $pid= $post->ID;
					       //echo $post->ID;
					       //echo "title=".$post->post_title;
					       $ptitle = $post->post_title;
					       $plink = get_permalink($pid);
					       //echo "link=".$plink;
					       echo "<li><a href=\"$plink\">$ptitle</a></li>";
					       $j++;
					     } else {
					       break;
					     }
					     endforeach;
					   }
					   }
$pages = $total_num / $my_post_num;
$m = $total_num % $my_post_num;
if ($m > 0 ) $pages++;

//多于1页
if ($pages >= 2) {
  echo "<br/>";
  echo "<div class=\"my_page_num\">";
  echo "<span>页数:</span>";
  for ($i =1; $i <= $pages; $i++) {
    if ($next_page == $i) {
      echo "<span>$i</span> ";
    } else {
      echo "<span style=\"border:1px solid #368\"><a href=\"$current_page_link&next=$i\">$i</a></span> ";
    }
  }
  echo "</div>";
}
?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

				<?php comments_template( '', true ); ?>

<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

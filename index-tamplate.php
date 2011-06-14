<?php
/*
  Template Name: Index article
*/

$next_page = 1;

$next_page = isset( $_GET['next'] ) ? $_GET['next']: 1;


get_header(); ?>

		<div id="container">
			<div id="content" role="main">
  <div id="head_ads"><?php print $head_ads;?></div>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">

<br/>						   <?php the_content(); ?>


						   <?php

						   //从自定义中得到分类
						   $categories = get_post_custom_values('categories');

						   foreach($categories as $cat) {
						    $catid = get_cat_ID($cat);
						    //需要有一个以分类命名的页面
						    $page = get_page_by_title($cat);
						    $page_id = $page->ID;

						    ?>
						   <table style="text-align: left; width: 100%;" border="0" cellspacing="1" cellpadding="1">
<tbody>
<tr style="background-color: #F1F7FC; border-bottom:1px solid #c3daf2; border-top:1px solid #c3daf2;">
<th style="font-weight: bold;font-size:10pt; color: #418FD8;"><?php echo $cat;?></th>
<th style="vertical-align: top; text-align: right;font-size:9pt; color: #418FD8;"><a href="?page_id=<?php echo $page_id; ?>">更多内容&gt;&gt;</a></th>
</tr>
<?php

    $args = array('numberposts'=>8, 'category' => $catid );
    $myposts = get_posts( $args );
    foreach( $myposts as $post ){
      $pid= $post->ID;
      //echo $post->ID;
      //echo "title=".$post->post_title;
      $ptitle = $post->post_title;
      $plink = get_permalink($pid);

      $today = date('Y-m-d');
      $pdate = $post->post_date;
      $is_new = strncasecmp($today, $pdate, 10);
      if ($is_new == 0) {
	$pdate = "<span id=\"today_news\">".$pdate."</span>";
      } else {
	$pdate = "<span id=\"old_news\">".$pdate."</span>";
      }
      if ($cat != "新闻动态") {
	$pdate = "";
      }
      //echo "link=".$plink;
      //echo "<li><a href=\"$plink\">$ptitle</a></li>";
echo "<tr><td style=\"vertical-align: top;\" colspan=\"2\">&bull; <a href=\"$plink\">$ptitle</a> $pdate</td></tr>";
    }
  

?>
</tbody>
</table>
<?php
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

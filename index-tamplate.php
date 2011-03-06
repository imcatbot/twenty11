<?php
/*
  Template Name: Index article
*/

$next_page = 1;

$next_page = isset( $_GET['next'] ) ? $_GET['next']: 1;


get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						   <?php the_content(); ?>

						   <?php

						   //从自定义中得到分类
						   $categories = get_post_custom_values('categories');

						   foreach($categories as $cat) {
						    $catid = get_cat_ID($cat);
						    //需要有一个以分类命名的页面
						    $page = get_page_by_title($cat);
						    $page_id = $page->ID;

						    ?>
						   <table style="text-align: left; width: 90%;" border="0" cellspacing="1" cellpadding="1">
<tbody>
<tr style="background-color: #fff; border-bottom:1px solid #c3daf2;">
<th style="vertical-align: top;font-size:9pt;"><?php echo $cat;?></th>
<th style="vertical-align: top; text-align: right;font-size:9pt;"><a href="?page_id=<?php echo $page_id; ?>">更多内容&gt;&gt;</a></th>
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
      //echo "link=".$plink;
      //echo "<li><a href=\"$plink\">$ptitle</a></li>";
echo "<tr><td style=\"vertical-align: top;\" colspan=\"2\"><a href=\"$plink\">$ptitle</a></td></tr>";
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

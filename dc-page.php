<?php
/*
Template Name: Display by category
*/

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( is_front_page() ) { ?>
						<span class="entry-title"></span>
					<?php } else { ?>
						<span class="my-entry-title">当前位置:<?php the_title(); ?></span><hr/>	
					<?php } ?>

					<div class="entry-content">
					<?php the_content(); ?>
					<?php
					   // 得到所有分类列表
					   //$this_category_name = "经典案例";

					
					   $mykey_values = get_post_custom_values('this_category_name');
					   $this_category_name = $mykey_values[0];
					
					   $categories = get_categories();

					   // 循环所有分类
					   foreach ($categories as $cat) {

					   // 得到分类ID
					   $catid = $cat->cat_ID;
					$catname = get_cat_name($catid);
  
					  if ($catname == $this_category_name) {
					      //echo $catname;
					        // global $post;
						    $args = array('category' => $catid );
						        $myposts = get_posts( $args );
					 foreach( $myposts as $post )  : 
					       $pid= $post->ID;
					             //echo $post->ID;
						       //echo "title=".$post->post_title;
							         $ptitle = $post->post_title;
								       $plink = get_permalink($pid);
						      //echo "link=".$plink;
						            echo "<li><a href=\"$plink\">$ptitle</a></li>";

    endforeach;
  }
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

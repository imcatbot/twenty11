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
						   <?php the_content(); ?>
<div id="toparticle">
<?php

//截断函数  
function chinasuber($sourcestr,$cutlength){ 
   $returnstr='';
   $i=0;
   $n=0;
   $str_length=strlen($sourcestr);//字符串的字节数
   while (($n<$cutlength) and ($i<=$str_length))
   {
      $temp_str=substr($sourcestr,$i,1);
      $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
      if ($ascnum>=224)    //如果ASCII位高与224，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符        
         $i=$i+3;            //实际Byte计为3
         $n++;            //字串长度计1
      }
      elseif ($ascnum>=192) //如果ASCII位高与192，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
         $i=$i+2;            //实际Byte计为2
         $n++;            //字串长度计1
      }
      elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,1);
         $i=$i+1;            //实际的Byte数仍计1个
         $n++;            //但考虑整体美观，大写字母计成一个高位字符
      }
      else                //其他情况下，包括小写字母和半角标点符号，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,1);
         $i=$i+1;            //实际的Byte数计1个
         $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...
      }
   }
         if ($str_length>$cutlength){
          $returnstr = $returnstr . "...";//超过长度时在尾处加上省略号
      }
    return $returnstr; 

}

	$catid = get_cat_ID("置顶文章");

    $args = array('numberposts'=>2, 'category'=>$catid);
    $myposts = get_posts( $args );
    foreach( $myposts as $post ){
      $pid= $post->ID;
      //echo $post->ID;
      //echo "title=".$post->post_title;
      $ptitle = $post->post_title;
      $plink = get_permalink($pid);
      $pcontent = chinasuber($post->post_content, 240);
      echo "<h2><a href=\"$plink\">$ptitle</a></h2>";
      echo "<p>$pcontent";
      echo "<a href=\"$plink\">阅读全部</a></p><br/>";
    }
  
?>
</div>
<br/>

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

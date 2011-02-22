<?php
/*
Template Name: Contact-Me

*/

if( isset($_POST['tougao_form']) && $_POST['tougao_form'] == 'send')
{
    global $wpdb;
    $last_post = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_type = 'post' ORDER BY post_date DESC LIMIT 1");

    // 两次投稿间隔至少120秒，可自行修改时间间隔，修改下面代码中的120即可
    // 相比Cookie来验证两次投稿的时间差，读数据库的方式更加安全
    if ( time() - strtotime($last_post) < 120 )
    {
        wp_die('您投稿也太勤快了吧，先歇会儿！');
    }
       
    // 表单变量初始化
    $name = isset( $_POST['tougao_authorname'] ) ? trim(htmlspecialchars($_POST['tougao_authorname'], ENT_QUOTES)) : '';
    $email =  isset( $_POST['tougao_authoremail'] ) ? trim(htmlspecialchars($_POST['tougao_authoremail'], ENT_QUOTES)) : '';
    $blog =  isset( $_POST['tougao_authorblog'] ) ? trim(htmlspecialchars($_POST['tougao_authorblog'], ENT_QUOTES)) : '';
    $title =  isset( $_POST['tougao_title'] ) ? trim(htmlspecialchars($_POST['tougao_title'], ENT_QUOTES)) : '';
    $category =  isset( $_POST['cat'] ) ? (int)$_POST['cat'] : 0;
    $content =  isset( $_POST['tougao_content'] ) ? trim(htmlspecialchars($_POST['tougao_content'], ENT_QUOTES)) : '';
   
   $category = '联系我们';
   $email = "contactme@cccme.com";

    // 表单项数据验证
    if ( empty($name) || strlen($name) > 20 )
    {
        wp_die('昵称必须填写，且长度不得超过20字');

    }
   
    if ( empty($email) || strlen($email) > 60 || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        wp_die('Email必须填写，且长度不得超过60字，必须符合Email格式');
    }
   
    if ( empty($title) || strlen($title) > 100 )
    {
        wp_die('标题必须填写，且长度不得超过100字');
    }
   
    if ( empty($content) || strlen($content) > 3000 || strlen($content) < 100)
    {
        wp_die('内容必须填写，且长度不得超过3000字，不得少于100字');
    }
   
    $post_content = '昵称: '.$name.'<br />Email: '.$email.'<br />内容:'.$content;
 
    $tougao = array(
        'post_title' => $title,
        'post_content' => $post_content,
        'post_category' => array($category)
    );


    // 将文章插入数据库
    $status = wp_insert_post( $tougao );
 
    if ($status != 0)
    {
        // 投稿成功给博主发送邮件
        // somebody#example.com替换博主邮箱
        // My subject替换为邮件标题，content替换为邮件内容
        //wp_mail("somebody#example.com","My subject","content");

        wp_die('投稿成功！感谢投稿！');
    }
    else
    {
        wp_die('投稿失败！');
    }
}

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
					<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <div style="text-align: left; padding-top: 10px;">
        <label>昵称:*</label>
    </div>
    <div>
        <input type="text" size="40" value="" name="tougao_authorname" />
    </div>
<!--
    <div style="text-align: left; padding-top: 10px;">
        <label>E-Mail:*</label>
    </div>
    <div>
        <input type="text" size="40" value="" name="tougao_authoremail" />
    </div>
                   
    <div style="text-align: left; padding-top: 10px;">
        <label>您的博客:</label>
    </div>
    <div>
        <input type="text" size="40" value="" name="tougao_authorblog" />
    </div>
-->
                   
    <div style="text-align: left; padding-top: 2px;">
        <label>主题:*</label>
    </div>
    <div>
        <input type="text" size="40" value="" name="tougao_title" />
    </div>
<!--
    <div style="text-align: left; padding-top: 10px;">
        <label>分类:*</label>
    </div>

    <div style="text-align: left;">
        <?php wp_dropdown_categories('show_count=1&hierarchical=1'); ?>
    </div>
-->                   
    <div style="text-align: left; padding-top: 3px;">
        <label>内容:*</label>
    </div>
    <div>
        <textarea rows="6" cols="40" name="tougao_content"></textarea>
    </div>
                   
    <br clear="all">
    <div style="text-align: center; padding-top: 10px;">
        <input type="hidden" value="send" name="tougao_form" />
        <input type="submit" value="提交" />
        <input type="reset" value="重填" />
    </div>
</form>
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

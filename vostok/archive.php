<?php get_header(); ?>
	<div id="content">
		<div id="main-content">
			
			<?php 
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		
			$args = array(
				'post_type' => 'mini_video',
				'posts_per_page' => '5',
				'paged' => $paged
			);
			
			$query = new WP_Query( $args );
			if ($query->have_posts()) : ?>
			 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
			<p class="string"><?php _e('Archive of articles classified as','vostok'); ?>' "<strong><?php echo single_cat_title(); ?></strong>"</p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
	 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<p class="string"><?php _e('Archive of published articles on','vostok'); ?> <?php the_time('F jS, Y'); ?></p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
		 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<p class="string"><?php _e('Archive of published articles on','vostok'); ?> <strong><?php the_time('F, Y'); ?></strong></p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<p class="string"><?php _e('Archive of published articles on','vostok'); ?> <strong><?php the_time('Y'); ?></strong></p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
		  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
			<p class="string"><?php _e('Archive of published articles by ','vostok'); ?></p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
			<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<p class="string"><?php _e('Blog Archives','vostok'); ?></p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
			<?php } ?>
			<?php while ($query->have_posts()) : $query->the_post(); ?>
			<? $postData = get_post_custom($post->ID); ?>
				<article class="post" id="post-<?php the_ID(); ?>">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					<span class="date"><?php the_time(__('m/j/Y','vostok')) ?></span>
					<section class="entry">
						<a href="<? the_permalink(); ?>"><img height="298" width="530" class="thumbnail_image" src="<? echo $postData['custom_thumb'][0]; ?>" /></a>
					</section>
					
					<!--footer>
						<span class="report"><a href="#">Report Issue</a></span>
					</footer-->
				</article><!-- close:post -->
			<?php endwhile; 
				wp_reset_postdata();
			?>
			<div class="pagination clearfix">
				<div class="prev"><?php next_posts_link(__('Older Films','vostok'), $query->max_num_pages) ?></div>
				<div class="next"><?php previous_posts_link(__('Newer Films','vostok'), $query->max_num_pages) ?></div>
			</div>
		<?php else : ?>
			<h2>Not found</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		<?php endif; ?>
		</div><!-- close:main-content -->
	<?php get_sidebar(); ?>
	</div><!-- close:content -->
<?php get_footer(); ?>
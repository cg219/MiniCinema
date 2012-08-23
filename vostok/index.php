<?php get_header(); ?>
	<div id="content">
		<div id="main-content">
		<?
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		
		$args = array(
			'post_type' => 'mini_video',
			'posts_per_page' => '5',
			'paged' => $paged
		);
		
		$query = new WP_Query( $args );
		if ($query->have_posts()) : ?>
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
			<p class="string"><?php _e('The page you are looking for doesn\'t exist. Sorry.','vostok'); ?></p>
			<a href="<?php echo get_option('home'); ?>/" class="back"><?php _e('Back home','vostok'); ?></a>
		<?php endif; ?>
		</div><!-- close:main-content -->
		<?php get_sidebar(); ?>
	</div><!-- close:content -->
<?php get_footer(); ?>
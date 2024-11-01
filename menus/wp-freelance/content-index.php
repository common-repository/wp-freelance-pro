
<div class='index-title'>

<div class='jobline'>
	<div class='time'>
	<?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>
	</div>

	<div class='link'>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'go to view %s', 'wpfrl' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"> 
	<?php echo substr(get_the_title(),0,60)."..."; ?>
	</a>
	</div>
	
	<div class='budget'>
	<?php
	$budg = get_post_meta( get_the_ID(), 'budget', TRUE);
	if ($budg == 'not_disclosed') _e('no budget', 'wpfrl' );
	else echo  __('$ ', 'wpfrl' ) . $budg ;
	?>
	</div>
	
	<div class='deadline'>
	<?php
	$deadl = get_post_meta( get_the_ID(), 'deadline', TRUE);
	if ($deadl > 9999999999) echo __('t.b.d.', 'wpfrl' );
	else echo human_time_diff(current_time('timestamp'),$deadl);
	?>
	</div>
</div>	
	
</div>



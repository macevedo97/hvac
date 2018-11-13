<?php /* Wrapper Name: Header */ ?>

<div class="header_block">
	<div class="row">
		<div class="<?php echo cherry_get_layout_class( 'full_width_content' ); ?>" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
			<?php get_template_part("static/static-nav"); ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="span12" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
		<div class="wrapper"><?php get_template_part("static/static-logo"); ?></div>
	</div>
</div>

<div class="row">
	<div class="span12 hidden-phone" data-motopress-type="static" data-motopress-static-file="static/static-search.php">
		<?php get_template_part("static/static-search"); ?>
	</div>
</div>
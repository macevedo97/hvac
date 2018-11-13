<?php /* Wrapper Name: Footer */ ?>

<div class="row">
	<div class="span5" data-motopress-type="static" data-motopress-static-file="static/static-footer-text.php">
		<?php get_template_part("static/static-footer-text"); ?>
	</div>
	<div class="span7" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar">
		<?php dynamic_sidebar("footer-sidebar"); ?>
	</div>
</div>

<div class="row">
	<div class="span12" data-motopress-type="static" data-motopress-static-file="static/static-footer-nav.php">
		<?php get_template_part("static/static-footer-nav"); ?>
	</div>
</div>
<?php 
    if (!empty($includes['css'])) {
        foreach ($includes['css'] as $css) {
            echo '<link href="'.$css.'" rel="stylesheet">';
        }
    }

    if (!empty($includes['js'])) {
        foreach ($includes['js'] as $js) {
            echo '<script src="'.$js.'"></script>';
        }
    }
?>

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<div class="row">
					<div class="col-md-4">
						<?php echo isset($btnLeft) ? $btnLeft : ''; ?>
					</div>
					<div class="col-md-4">
						<h2 id="head_name">
							<?php echo isset($title) ? strtoupper($title) : ''; ?>
						</h2>
					</div>
					<div class="col-md-4">
						<div class="pull-right">
							<?php echo isset($btnRight) ? $btnRight : ''; ?>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
			</div>
			<div class="row col-md-12">
				<div class="pull-right">
					<?php echo $additionalInfo ?>
				</div>
			</div>
			<div class="x_content">
                <?php echo $contentView; ?>
			</div>
		</div>
	</div>
</div>


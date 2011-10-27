<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php print $this->Html->charset(); ?>
    <title>
       	Practical Assessment Project: <?php print $title_for_layout; ?>
    </title>
<?php
    	print $this->Html->meta('icon');
       	print $this->Html->css('cake.generic');
       	print $scripts_for_layout;
?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><a href="/">Practical Assessment Project</a></h1>

		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?=$content_for_layout?>
		</div>
		<div id="footer">
			<p>Here we go....</p>
		</div>
	</div>

	</body>
</html>

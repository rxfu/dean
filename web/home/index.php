<?php section('header') ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <a href="<?php echo toLink('student.login') ?>" class="thumbnail">
                	<img alt="学生入口" data-src="holder.js/100%x180">
                	<div class="caption text-center">
                		<h3>学生入口</h3>
                	</div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="<?php echo toLink('teacher.login') ?>" class="thumbnail">
                	<img alt="教师入口" data-src="holder.js/100%x180">
                	<div class="caption text-center">
                		<h3>教师入口</h3>
                	</div>
                </a>
            </div>
        </div>
<?php section('footer') ?>
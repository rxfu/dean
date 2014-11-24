<?php include 'header.php' ?>
<?php include 'navigation.php' ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                    	<?php if ($session->has('flash_error')): ?>
                        <div id="flash_error" class="alert alert-danger alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $session->get('flash_error') ?>
                        </div>
                        <?php endif; ?>
                    	<?php if ($session->has('flash_warning')): ?>
                        <div id="flash_warning" class="alert alert-warning alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $session->get('flash_warning') ?>
                        </div>
                        <?php endif; ?>
                    	<?php if ($session->has('flash_success')): ?>
                        <div id="flash_success" class="alert alert-success alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $session->get('flash_success') ?>
                        </div>
                        <?php endif; ?>
                    	<?php if ($session->has('flash_info')): ?>
                        <div id="flash_info" class="alert alert-info alert-dismissable">
                            <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $session->get('flash_info') ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">仪表盘</h1>
                    </div>
                </div>
            </div>

<?php include 'footer.php' ?>
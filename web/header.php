<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="用于广西师范大学教务管理，学生选课，录入成绩">
        <meta name="keywords" content="广西师范大学,教务处,学生选课,教师管理,成绩管理">
        <meta name="author" content="Fu Rongxin,符荣鑫">
        <title>广西师范大学教务管理系统</title>
        <!--link rel="shortcut icon" href="favicon.ico"-->
        <?php echo css('css/bootstrap.min.css') ?>
        <?php echo css('css/formValidation.min.css') ?>
        <?php echo css('css/bootstrap-select.css') ?>
        <?php echo css('css/bootstrap-theme.css') ?>
        <?php echo css('font-awesome/css/font-awesome.min.css') ?>
        <?php echo css('css/plugins/dataTables/dataTables.bootstrap.css') ?>
        <?php echo css('css/sb-admin-2.css') ?>
        <?php echo css('css/timeline.css') ?>
        <?php echo css('css/style.css') ?>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
            <?php echo js('js/html5shiv.js') ?>
            <?php echo js('js/respond.min.js') ?>
        <![endif]-->
    </head>

    <body>

        <div id="wrapper">
            <!-- 页面头部Logo -->
            <header role="banner"></header>

            <?php if (isset($session['logged']) && true == $session['logged']): ?>
                <?php if (Config::get('user.role.student') == $session['role']): ?>
                    <?php include partial('student.navigation') ?>
                <?php elseif (Config::get('user.role.teacher') == $session['role']): ?>
                    <?php include partial('teacher.navigation') ?>
                <?php endif; ?>

                <!-- 页面主体 -->
                <main id="page-wrapper">
            <?php else: ?>
                <!-- 页面主体 -->
                <main class="container">
            <?php endif; ?>
            
            <?php if (Message::has()): ?>
                <!-- 页面消息 -->
                <section class="row">
                    <div class="col-lg-12">
                        <?php Message::display() ?>
                    </div>
                </section>
            <?php endif; ?>

            <!-- 数据加载 -->
            <!--div id="loading">
                <img src="<?php echo img('images/loading.gif') ?>" alt="加载中">
                <p>加载中……请稍后</p>
            </div-->

            <article>

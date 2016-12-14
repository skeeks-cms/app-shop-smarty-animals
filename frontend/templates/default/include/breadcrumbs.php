<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 24.03.2015
 */

if (!@$title)
{

    if ($model)
    {
        $title = $model->name?$model->name:$model->username;
    }
}


?>

<!--
    PAGE HEADER

    CLASSES:
        .page-header-xs	= 20px margins
        .page-header-md	= 50px margins
        .page-header-lg	= 80px margins
        .page-header-xlg= 130px margins
        .dark			= dark page header

        .shadow-before-1 	= shadow 1 header top
        .shadow-after-1 	= shadow 1 header bottom
        .shadow-before-2 	= shadow 2 header top
        .shadow-after-2 	= shadow 2 header bottom
        .shadow-before-3 	= shadow 3 header top
        .shadow-after-3 	= shadow 3 header bottom
-->
<section class="page-header page-header-xs" style="background: white;">
    <div class="">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?= \skeeks\cms\cmsWidgets\breadcrumbs\BreadcrumbsCmsWidget::widget([
                    'viewFile'       => '@template/widgets/BreadcrumbsCmsWidget/default',
                ]); ?>

                <h1><?= $title; ?></h1>
            </div>
        <!-- breadcrumbs -->
        <!--<ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li><a href="#">Pages</a></li>
            <li class="active">Blank Page</li>
        </ol>--><!-- /breadcrumbs -->

        </div>
    </div>
</section>
<!-- /PAGE HEADER -->


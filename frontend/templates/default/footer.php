<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.03.2015
 */
/* @var $this \yii\web\View */
?>
<!-- FOOTER -->
<footer id="footer" class="row">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?= \skeeks\cms\cmsWidgets\text\TextCmsWidget::widget([
                    'namespace' => 'text-footer-left',
                    'text' => <<<HTML
				<!-- Footer Logo -->
				<h4 class="letter-spacing-1">О нас</h4>

				<!-- Small Description -->
				<p>SkeekS.com</p>
				<p>Магазин брендовой одежды</p>

				<!-- Contact Address -->
				<address style="margin-top: 5px;">
					<a href="tel:+74950057926" style="font-size: 21px; text-decoration: none;">(+7 495) 005-79-26</a>
					<p>
						<a href="#sx-callback" class="sx-fancybox" style="text-decoration: none; border-bottom: 1px dashed">Заказать обратный звонок</a>
					</p>

				</address>
				<!-- /Contact Address -->

				<p>&nbsp;</p>

				<a href="http://vk.com/skeeks_com" target="_blank" class="social-icon social-icon-border social-facebook pull-left" data-toggle="tooltip" data-placement="top" title="Vkontakte">

					<i class="icon-vk"></i>
					<i class="icon-vk"></i>
				</a>
				<a href="https://www.facebook.com/skeekscom" target="_blank" class="social-icon social-icon-border social-facebook pull-left" data-toggle="tooltip" data-placement="top" title="Vkontakte">

					<i class="icon-facebook"></i>
					<i class="icon-facebook"></i>
				</a>
HTML
                    ,
                ]); ?>
            </div>
            <div class="col-md-3">
                <? /*= \skeeks\cms\cmsWidgets\contentElements\ContentElementsCmsWidget::widget([
					'namespace'         => 'ContentElementsCmsWidget-footer',
					'viewFile'          => '@template/widgets/ContentElementsCmsWidget/articles-footer',
					'label'             => 'Новости и статьи',
					'enabledCurrentTree'=> \skeeks\cms\components\Cms::BOOL_N,
					'limit'             => 4,
				])*/ ?>

                <?= \skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget::widget([
                    'namespace' => 'menu-footer-3',
                    'viewFile' => '@template/widgets/TreeMenuCmsWidget/menu-footer.php',
                    'label' => 'Каталог',
                    'level' => '1',
                ]); ?>
            </div>
            <div class="col-md-2">
                <?= \skeeks\cms\cmsWidgets\treeMenu\TreeMenuCmsWidget::widget([
                    'namespace' => 'menu-footer-2',
                    'viewFile' => '@template/widgets/TreeMenuCmsWidget/menu-footer.php',
                    'label' => 'Меню',
                    'level' => '1',
                ]); ?>
            </div>
            <div class="col-md-4">
                <h4 class="letter-spacing-1">Обратная связь</h4>

                <div class="sx-feedback-wrapper" id="sx-feedback">
                    <?
                    $this->registerCss(<<<CSS
.sx-feedback-wrapper form
{
	margin-bottom: 0px;
}

#footer .sx-feedback-wrapper form input, #footer .sx-feedback-wrapper form textarea
{
	background: white;
}
#footer .sx-feedback-wrapper form textarea
{
	height: 80px;
}
CSS
                    )
                    ?>
                    <?= \skeeks\modules\cms\form2\cmsWidgets\form2\FormWidget::widget([
                        'namespace' => 'FormWidget-feedback-all',
                        'form_code' => 'feedback',
                        'viewFile' => 'whith-messages',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <ul class="pull-right nomargin list-inline mobile-block">
                <li><a href="http://skeeks.com" title="Студия SkeekS">Разработка сайта — SkeekS.com</a> (<a
                        href="http://cms.skeeks.com" title="Система управления сайтом SkeekS CMS (Yii2 cms)">SkeekS CMS
                        Yii2</a>)
                </li>
            </ul>
            <?= \skeeks\cms\cmsWidgets\text\TextCmsWidget::widget([
                'namespace' => 'text-footer-rights',
                'text' => <<<HTML
				&copy; Все права защищены, SkeekS CMS - SHOP 2016
HTML
                ,
            ]); ?>
        </div>
    </div>
</footer>
<!-- /FOOTER -->
<div style="display: none;">
    <?= \Yii::$app->seo->countersContent; ?>
    <div id="sx-callback" style="width: 600px;">
        <h2>Обратный звонок</h2>

        <p>Оставьте ваш номер телефона и мы вам перезвоним.</p>
        <?= \skeeks\modules\cms\form2\cmsWidgets\form2\FormWidget::widget([
            'namespace' => 'FormWidget-all',
            'form_code' => 'callback',
            'viewFile' => 'whith-messages',
        ]) ?>
    </div>
</div>




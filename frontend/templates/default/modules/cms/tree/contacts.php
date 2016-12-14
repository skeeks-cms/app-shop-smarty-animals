<?
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 01.10.2015
 */
/* @var $this \yii\web\View */
/* @var \skeeks\cms\models\Tree $model */
$this->registerCss(<<<CSS
canvas {
	width: auto  !important;
	/* max-width: 800px; causes panorama gmap problems */
	height: auto !important;
}
CSS
);
?>
<?= $this->render('@template/include/breadcrumbs', [
    'model' => $model
]) ?>
<!--=== Content Part ===-->
<section style="padding: 0px;">
    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=ZIzv2My7at8ytlpC47tEiPvETsD3CdRt&amp;width=100%&amp;height=400&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
    <div class="container">
        <p></p>

        <p></p>

        <div class="row">
            <!-- INFO -->
            <div class="col-md-6 col-sm-6">
                <h2>Контакты</h2>
                <hr/>
                <p>
                    <span class="block"><strong><i class="fa fa-map-marker"></i> Адрес:</strong> г. Солнечногорск...</span>
                    <span class="block"><strong><i class="fa fa-phone"></i> Телефон:</strong>
                        <a href="tel:+74993434040" style="font-size: 21px; text-decoration: none;">+7 (499) 343-40-40</a>
                    </span>
                    <span class="block"><strong><i class="fa fa-envelope"></i> Email:</strong> <a
                            href="mailto:info@zoogum.ru">info@zoogum.ru</a></span>
                </p>

                <div class="margin-top-20">
                    <!--<a href="https://vk.com/stroykray" target="_blank"
                       class="social-icon social-icon-border social-facebook pull-left" data-toggle="tooltip"
                       data-placement="top" title="Vkontakte">
                        <i class="icon-vk"></i>
                        <i class="icon-vk"></i>
                    </a>-->
                    <!--<a href="https://www.facebook.com/skeekscom" target="_blank"
                       class="social-icon social-icon-border social-facebook pull-left" data-toggle="tooltip"
                       data-placement="top" title="Vkontakte">
                        <i class="icon-facebook"></i>
                        <i class="icon-facebook"></i>
                    </a>
                    <a href="https://twitter.com/skeeks_com" target="_blank"
                       class="social-icon social-icon-border social-twitter pull-left" data-toggle="tooltip"
                       data-placement="top" title="Twitter">
                        <i class="icon-twitter"></i>
                        <i class="icon-twitter"></i>
                    </a>
                    <a href="https://www.youtube.com/channel/UC26fcOT8EK0Rr80WSM44mEA" target="_blank"
                       class="social-icon social-icon-border social-twitter pull-left" data-toggle="tooltip"
                       data-placement="top" title="Youtube">
                        <i class="icon-youtube"></i>
                        <i class="icon-youtube"></i>
                    </a>-->
                </div>
            </div>
            <!-- /INFO -->
            <div class="col-md-6 col-sm-6">
                <?= $model->description_full; ?>
                <h2>Обратная связь</h2>
                <hr/>
                <?= \skeeks\modules\cms\form2\cmsWidgets\form2\FormWidget::widget([
                    'viewFile' => 'whith-messages',
                    'form_code' => 'feedback',
                    'namespace' => 'FormWidget-contacts',
                ]) ?>
                <p>
                </p>
            </div>
        </div>
    </div>
</section>
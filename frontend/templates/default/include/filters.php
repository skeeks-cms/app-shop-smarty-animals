<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 28.07.2016
 */

$this->registerCss(<<<CSS
.sorting {
    zoom: 1;
    font-size: 1.083333em;
    line-height: 22px;
    margin: 0px 0px 40px 5px;
}

.sorting .sort {
    float: left;
    zoom: 1;
    overflow: hidden;
    min-width: 65%;
}

.sorting .sort .lbl, .sorting .sort .vals {
    float: left;
    zoom: 1;
}

.sorting .sort .vals a.active {
    font-weight: 700;
    color: #ed1b24;
}
.sorting .sort .vals a {
    float: left;
    margin: 3px 9px;
    line-height: 16px;
    color: #131313;
    border-bottom: dotted 1px #8a8a8a;
    position: relative;
    white-space: nowrap;
}

.sx-view-mode .active
{
    color: #ed1b24;
}
CSS
);

?>


<div class="sorting">

    <?= $this->registerJs(<<<JS
(function(sx, $, _)
{
sx.classes.Filters = sx.classes.Component.extend({
    _onDomReady: function()
    {
        $('.sx-filter-action').on('click', function()
        {
            var jForm = $('#sx-filters');
            $('#' + $(this).data('filter')).val($(this).data('filter-value'));
            jForm.submit();
            return false;
        });
        $('.sx-filter-action-checkbox').on('click', function()
        {
            var checkboxValue;
            if ($(this).attr("checked") != 'checked')
            {
                checkboxValue = 1;
            }
            else
                checkboxValue = 1;
            var jForm = $('#sx-filters');
            $('#' + $(this).data('filter')).val($(this).data('filter-value'));
            jForm.submit();
            return false;
        });
    },
});

new sx.classes.Filters();
})(sx, sx.$, sx._);
JS
); ?>
    <div class="sort">
        <div style="display: none;">
            <? $form = \yii\widgets\ActiveForm::begin([
                'id' => 'sx-filters',
                'method' => 'get',
                'options' =>
                [
                    'data-pjax' => 1,
                ]
                //'action' => \Yii::$app->request->pathInfo
            ]); ?>
                <?= $form->field($filters, 'sort'); ?>
                <?= $form->field($filters, 'inStock'); ?>
                <button>Отправить</button>
            <? $form::end(); ?>
        </div>
        <div class="lbl">
            Сортировать:
        </div>
        <div class="vals">
            <a href="#" class="sx-filter-action <?= $filters->sort == '-popular' ? "active" : "" ; ?>" data-filter="productfilters-sort" data-filter-value="-popular">Популярные</a>
            <a href="#" class="sx-filter-action <?= $filters->sort == 'price' ? "active" : "" ; ?>" data-filter="productfilters-sort" data-filter-value="price">Сначала дешевые</a>
            <a href="#" class="sx-filter-action <?= $filters->sort == '-price' ? "active" : "" ; ?>" data-filter="productfilters-sort" data-filter-value="-price">Сначала дорогие</a>
            <a href="#" class="sx-filter-action <?= $filters->sort == '-published_at' ? "active" : "" ; ?>" data-filter="productfilters-sort" data-filter-value="-published_at">Новинки</a>
        </div>

    </div>
    <!--<div class="checkbox in-stock">
        <input type="checkbox" class="sx-filter-action " <?/*= $filters->inStock == 1 ? "checked" : "" ; */?> data-filter="productfilters-instock" data-filter-value="<?/*=$filters->inStock == 1? -1: 1;*/?>" id="check-in-stock" />
        <label for="check-in-stock">Есть в наличии</label>
    </div>-->
    <div class="sx-view-mode pull-right">
        <?
            $url = \Yii::$app->request->pathInfo;
            if ($_GET)
            {
                $urlTable = "/" . $url . "?" . http_build_query(array_merge($_GET, ['sx-view-mode' => 'table']));
                $urlList = "/" . $url . "?" . http_build_query(array_merge($_GET, ['sx-view-mode' => 'list']));
            } else
            {
                $urlTable = "/" . $url . "?" . http_build_query(['sx-view-mode' => 'table']);
                $urlList = "/" . $url . "?" . http_build_query(['sx-view-mode' => 'list']);
            }
        ?>
        <a class="btn btn-default btn-xs <?= \Yii::$app->settings->product_view == 'table' ? "active" : ""?>" href="<?= $urlTable; ?>" data-toggle="tooltip" title="Отображать товары таблицей">
            <i class="glyphicon glyphicon-th" style="padding-right: 0px;"></i>
        </a>
        <a class="btn btn-default btn-xs <?= \Yii::$app->settings->product_view == 'list' ? "active" : ""?>" href="<?= $urlList; ?>" data-toggle="tooltip" title="Отображать товары списком">
            <i class="glyphicon glyphicon-th-list" style="padding-right: 0px;"></i>
        </a>
    </div>
</div>
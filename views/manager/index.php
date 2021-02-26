<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use kartik\file\FileInput;

$this->title = Yii::t('imagemanager', 'Image manager');

?>
<div id="module-imagemanager" class="container-fluid <?= $selectType ?>">
    <div class="row">
        <div class="col-xs-6 col-sm-9 col-image-editor">
            <div class="image-cropper text-right">
                <div class="image-wrapper">
                    <img id="image-cropper"/>
                </div>
                <div class="btn-group action-buttons mt-2">
                    <a href="#" class="btn btn-primary apply-crop">
                        <i class="fa fa-crop"></i>
                        <span class="hidden-xs"><?= Yii::t('imagemanager', 'Crop') ?></span>
                    </a>
                    <?php if ($viewMode === "iframe"): ?>
                        <a href="#" class="btn btn-info apply-crop-select">
                            <i class="fa fa-crop"></i>
                            <span class="hidden-xs"><?= Yii::t('imagemanager', 'Crop and select') ?></span>
                        </a>
                    <?php endif; ?>
                    <a href="#" class="btn btn-warning cancel-crop">
                        <i class="fa fa-undo"></i>
                        <span class="hidden-xs"><?= Yii::t('imagemanager', 'Cancel') ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-9 col-overview pr-3">
            <?php Pjax::begin([
                'id' => 'pjax-mediamanager',
                'timeout' => '5000'
            ]); ?>
            <?php
            $layout = '<div class="border-primary bg-dark text-white align-content-center mb-3 rounded pt-2">
                                            {pager}
                                    </div>
                                        <div class="item-overview row">{items}</div>
                '
            ?>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item col-3 col-sm-3 col-md-2 col-lg-2 col-xl-2'],
                'layout' => $layout,
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render("_item", ['model' => $model]);
                },
                'pager' => [
                    'class' => \petersonsilvadejesus\imagemanager\widgets\LinkPager::class,
                ]
            ]) ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="col-xs-6 col-sm-3 col-options">
            <div class="form-group">
                <?= Html::textInput('input-mediamanager-search', null, ['id' => 'input-mediamanager-search', 'class' => 'form-control', 'placeholder' => Yii::t('imagemanager', 'Search') . '...']) ?>
            </div>

            <?php
            if (Yii::$app->controller->module->canUploadImage):
                ?>

                <?= FileInput::widget([
                'name' => 'imagemanagerFiles[]',
                'id' => 'imagemanager-files',
                'options' => [
                    'multiple' => true,
                    'accept' => 'image/*'
                ],
                'pluginOptions' => [
                    'uploadUrl' => Url::to(['manager/upload']),
                    'allowedFileExtensions' => \Yii::$app->controller->module->allowedFileExtensions,
                    'uploadAsync' => false,
                    'showPreview' => false,
                    'showRemove' => false,
                    'showUpload' => false,
                    'showCancel' => false,
                    'browseClass' => 'btn btn-primary ',
                    'browseIcon' => '<i class="fa fa-upload mr-1"></i> ',
                    'browseLabel' => Yii::t('imagemanager', 'Upload')
                ],
                'pluginEvents' => [
                    "filebatchselected" => "function(event, files){  $('.msg-invalid-file-extension').addClass('hide'); $(this).fileinput('upload'); }",
                    "filebatchuploadsuccess" => "function(event, data, previewId, index) {
						imageManagerModule.uploadSuccess(data.jqXHR.responseJSON.imagemanagerFiles);
					}",
                    "fileuploaderror" => "function(event, data) { $('.msg-invalid-file-extension').removeClass('d-none'); }",
                ],
            ]) ?>

            <?php
            endif;
            ?>

            <div class="image-info d-none">
                <div class="thumbnail">
                    <img src="#">
                </div>
                <div class="edit-buttons">
                    <a href="#" class="btn btn-primary crop-image-item">
                        <i class="fa fa-crop mr-1"></i>
                        <span class="hidden-xs"><?= Yii::t('imagemanager', 'Crop') ?></span>
                    </a>
                </div>
                <div class="details">
                    <div class="fileName"></div>
                    <div class="created"></div>
                    <div class="fileSize"></div>
                    <div class="dimensions"><span class="dimension-width"></span> &times; <span
                                class="dimension-height"></span></div>
                    <?php
                    if (Yii::$app->controller->module->canRemoveImage):
                        ?>
                        <a href="#" class="btn btn-sm btn-danger delete-image-item"><i
                                    class="fa fa-trash mr-1"></i> <?= Yii::t('imagemanager', 'Delete') ?></a>
                    <?php
                    endif;
                    ?>
                </div>
                <?php if ($viewMode === "iframe"): ?>
                    <a href="#" class="btn btn-primary pick-image-item"><?= Yii::t('imagemanager', 'Select') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

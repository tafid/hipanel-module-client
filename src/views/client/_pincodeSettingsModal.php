<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \yii\web\View
 * @var array $questionList
 */
?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>
<?= Html::activeHiddenInput($model, "[$model->id]id") ?>
<?= Html::activeHiddenInput($model, "[$model->id]pincode_enabled") ?>
<?php if ($model->pincode_enabled) : ?>
    <?php
    $this->registerJs(<<<JS
        jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            jQuery('#' + e.relatedTarget.getAttribute('href').substr(1)).find('input:text').val(''); //e.target
        });
JS
    );
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('hipanel:client', 'Disable pincode'),
                            'content' => $form->field($model, "[$model->id]pincode")->passwordInput(),
                            'active' => true,
                            'options' => [
                                'class' => 'md-mt-10',
                            ],
                        ],
                        [
                            'label' => Yii::t('hipanel:client', 'Forgot pincode?'),
                            'content' => $form->field($model, "[$model->id]answer")->label($model->question),
                            'options' => [
                                'class' => 'md-mt-10',
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="alert alert-warning" role="alert">
                <?= Yii::t('hipanel:client', 'You have already set a PIN code. In order to disable it, enter your current PIN or the secret question.') ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php
    $this->registerJs(<<<JS
        jQuery(document).on( "change", "select.client-question", function() {
            var textField = jQuery('input.own-question');
            if (this.value == 'own') {
                textField.attr('disabled', false).show();
            } else {
                textField.attr('disabled', true).hide();
            }
        });
JS
    );
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="bg-info" style="padding: 10px">
                <?= Yii::t('hipanel:client', 'To further protect your account, you can install a pin code.') ?>
                <?= Yii::t('hipanel:client', 'The following operations, {0}, {1}, {2}, will be executed only when the correct PIN code is entered.', [
                    Html::tag('b', Yii::t('hipanel:client', 'Push domain')),
                    Html::tag('b', Yii::t('hipanel:client', 'Obtaining an authorization code for a domain transfer')),
                    Html::tag('b', Yii::t('hipanel:client', 'Change the email address of the account\'s primary contact')),
                ]) ?>
                <?= Yii::t('hipanel:client', 'In order to be able to disable the pin code in the future, it is required to ask an answer to a security question.') ?>
            </div>
            <br>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, "[$model->id]pincode")->textInput(['value' => mt_rand(1000, 9999), 'autocomplete' => 'new-password']) ?>
            <?= $form->field($model, "[$model->id]question")->dropDownList($questionList, ['class' => 'client-question form-control']) ?>
            <?= Html::activeTextInput($model, "[$model->id]question", [
                'class' => 'own-question form-control',
                'style' => 'display: none;',
                'value' => '',
                'disabled' => true,
                'placeholder' => Yii::t('hipanel:client', 'Enter your question'),
            ]) ?>
            <?= $form->field($model, "[$model->id]answer")->textInput(['autocomplete' => 'new-password']) ?>
        </div>
    </div>
<?php endif ?>
<div class="row">
    <div class="col-md-12">
        <div class="bg-danger" style="padding: 15px">
            <?= Yii::t('hipanel:client', 'In case you forget the PIN code or answer to a secret question, you can disconnect the PIN code only through the support service! (You will need to verify your account by providing a copy of the documents)') ?>
        </div>
    </div>
</div>
<hr>
<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>

<?php

use hipanel\modules\client\controllers\ContactController;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\models\Contact;
use hipanel\widgets\Box;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use Yii;
use yii\helpers\Html;

$this->title    = $model->login;
$this->subtitle = Yii::t('app', 'client detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => 'Clients', 'url' => ['index']],
    $this->title,
]);

FlagIconCssAsset::register($this);

?>
<div class="row">
    <div class="col-md-3">
        <?php Box::begin(); ?>
        <div class="profile-user-img text-center">
            <?= $this->render('//layouts/gravatar', ['email' => $model->email, 'size' => 120]); ?>
        </div>
        <p class="text-center">
            <span class="profile-user-name"><?= $model->login . ' / ' . $model->seller ?></span>
            <br>
            <span class="profile-user-role"><?= $model->type ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="ion-unlocked"></i>' . Yii::t('app', 'Change your password'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-lock-combination"></i>' . Yii::t('app', 'Pincode settings'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-network"></i>' . Yii::t('app', 'Setup IP address restrictions'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-at"></i>' . Yii::t('app', 'Mailing lists settings'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-compose"></i>' . Yii::t('app', 'Change contact information'), ContactController::getActionUrl('update', $model->id)) ?>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-globe"></i>' . Yii::t('app', 'Domain settings'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-ticket"></i>' . Yii::t('app', 'Ticket settings'), '#'); ?>
                </li>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
            <?php $box = Box::begin(['renderBody' => false]) ?>
                <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Yii::t('app', 'Client information'), '&nbsp;') ?>
                    <?php $box->beginTools() ?>
                        <?php /* Html::a(Yii::t('app', 'Recharge account'), '#', ['class' => 'btn btn-default btn-xs']) */ ?>
                    <?php $box->endTools() ?>
                <?php $box->endHeader() ?>
                <?php $box->beginBody() ?>
                    <?= ClientGridView::detailView([
                        'model'   => $model,
                        'columns' => [
                            'seller_id', 'name',
                            'type', 'state',
                            'balance', 'credit',
                            'create_time', 'update_time',
                            'tariff',
                            'tickets', 'servers', 'domains', 'contacts', 'hosting',
                        ],
                    ]) ?>
                <?php $box->endBody() ?>
            <?php $box::end() ?>
            </div>
            <div class="col-md-6">
            <?php $box = Box::begin(['renderBody' => false]); ?>
                <?php $box->beginHeader(); ?>
                    <?= $box->renderTitle(Yii::t('app', 'Contact information'), Html::a('details', ContactController::getActionUrl('view', $model->id))); ?>
                    <?php $box->beginTools(); ?>
                        <?= Html::a(Yii::t('app', 'Change contact information'), ContactController::getActionUrl('update', $model->id), ['class' => 'btn btn-default btn-xs']); ?>
                    <?php $box->endTools(); ?>
                <?php $box->endHeader(); ?>
                <?php $box->beginBody(); ?>
                    <?= ContactGridView::detailView([
                        'model'   => new Contact($model->contact),
                        'columns' => [
                            'first_name', 'last_name',
                            'email',
                            'abuse_email',
                            'skype',
                            'icq',
                            'jabber',
                            'voice_phone',
                            'fax_phone',
                            'street',
                            'city',
                            'province',
                            'postal_code',
                            'country',
                        ],
                    ]) ?>
                <?php $box->endBody(); ?>
            <?php $box::end(); ?>
            </div>
        </div>
    </div>
</div>

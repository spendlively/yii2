<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<p>Вы ввели: имя <?= $name; ?> и email <?= $email; ?></p>

<?php $activeForm = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

<?= $activeForm->field($form, 'name'); ?>
<?= $activeForm->field($form, 'email'); ?>
<?= $activeForm->field($form, 'file')->fileInput(); ?>
<?= Html::submitButton('Отправить'); ?>

<?php $activeForm = ActiveForm::end(); ?>



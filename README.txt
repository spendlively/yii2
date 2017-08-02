
//Установка
В файле config/web.php заполняем конфиг cookieValidationKey





//URL
http://localhost:8888/index.php?r=site/index
site - контроллер SiteController.php
index - экшн actionIndex()





//MVC
//Контроллер - controllers/SiteController.php
//http://localhost:8888/index.php?r=site/hello&name=vasya
public function actionHello($name = "World")
{
    return $this->render('hello', [
        'message' => $name,
    ]);
}

//Представление - views/site/hello.php
//Содержимое будет выведено в views/layouts/main.php в <?= $content ?>
<h1>Hello, <?= $name; ?>!</h1>





//Forms
//controllers/SiteController.php
public function actionForm()
{
    $form = new \app\models\MyForm();
    $name = '';
    $email = '';

    if($form->load(Yii::$app->request->post()) && $form->validate()){

        $name = \yii\helpers\Html::encode($form->name);
        $email = \yii\helpers\Html::encode($form->email);
    }

    return $this->render('form', [
        'form' => $form,
        'name' => $name,
        'email' => $email,
    ]);
}

//models/MyForm.php
namespace app\models;

class MyForm extends \yii\base\Model
{

    public $name;
    public $email;

    public function rules()
    {

        return [
            [['name', 'email'], 'required', 'message' => 'Не заполнено поле'],
            ['email', 'email', 'message' => 'Некорректный email адрес'],
        ];
    }
}

//views/site/form.php
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<p>Вы ввели: имя <?= $name; ?> и email <?= $email; ?></p>

<?php $activeForm = ActiveForm::begin();?>

<?= $activeForm->field($form, 'name'); ?>
<?= $activeForm->field($form, 'email'); ?>
<?= Html::submitButton('Отправить'); ?>

<?php $activeForm = ActiveForm::end(); ?>




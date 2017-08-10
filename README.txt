
//////////////////////////////////////////////////////////////////////////
///////////////////////////////Конфиги////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//config/web.php
cookieValidationKey
//www/config/db.php
//Префикс для таблиц db
'tablePrefix' => 'pref_'





//////////////////////////////////////////////////////////////////////////
/////////////////////////////////MVC//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//URL
http://localhost:8888/index.php?r=site/index
site - контроллер SiteController.php
index - экшн actionIndex()

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





//////////////////////////////////////////////////////////////////////////
///////////////////////////////FORMS//////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
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





//////////////////////////////////////////////////////////////////////////
//////////////////////////////Active Record///////////////////////////////
//////////////////////////////////////////////////////////////////////////
//http://localhost:8888/index.php?r=site/comments
//controllers/SiteController.php
public function actionComments()
{

    $comments = \app\models\Comments::find()->all();

    return $this->render('comments', [
        'comments' => $comments,
    ]);
}

//models/Comments.php //файл назван как таблица в бд
namespace app\models;
use yii\db\ActiveRecord;
class Comments extends ActiveRecord{}

//views/site/comments.php
<h1>Комментарии</h1>
<ul>
<?php foreach($comments as $comment){ ?>
    <li><b><?= $comment->name; ?>:</b> <?= $comment->text; ?></li>
<?php } ?>
</ul>





//////////////////////////////////////////////////////////////////////////
////////////////////////////////Paginator/////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//http://localhost:8888/index.php?r=site/paginator
//controllers/SiteController.php
public function actionPaginator()
{

    $comments = \app\models\Comments::find();

    $pagination = new \yii\data\Pagination([
        'defaultPageSize' => 2,
        'totalCount' => $comments->count(),
    ]);

    $comments = $comments
        ->offset($pagination->offset)
        ->limit($pagination->limit)
        ->all();

    return $this->render('paginator', [
        'comments' => $comments,
        'pagination' => $pagination,
    ]);
}


//views/site/paginator.php
<?php
use yii\widgets\LinkPager;
?>
<h1>Комментарии</h1>
<ul>
<?php foreach($comments as $comment){ ?>
    <li><b><?= $comment->name; ?>:</b> <?= $comment->text; ?></li>
<?php } ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]); ?>





//////////////////////////////////////////////////////////////////////////
//////////////////////////////////LINK////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//config/web.php
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'about' => 'site/about'
    ],
],

//Ссылка
http://localhost:8888/index.php?r=site/user&name=Вася
<?= Yii::$app->urlManager->createUrl(['site/user', 'name' => $comment->name]); ?>





//////////////////////////////////////////////////////////////////////////
///////////////////////////////Параметры//////////////////////////////////
//////////////////////////////////////////////////////////////////////////
$name = yii::$app->request->get('name'); //null по умолчанию
//$name = yii::$app->request->post('name');
//$name = yii::$app->request->post('name', false); //false по умолчанию





//////////////////////////////////////////////////////////////////////////
/////////////////////////////////Сессии///////////////////////////////////
//////////////////////////////////////////////////////////////////////////
$session = yii::$app->session;
$session->set('name', $name);
$session->remove('name');
$session->get('name');
$session->has('name');





//////////////////////////////////////////////////////////////////////////
//////////////////////////////////КУКИ////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//Записать значение в куку пользователя
$cookies = Yii::$app->response->cookies;
$cookies->add(new \yii\web\Cookie([
    'name' => 'name',
    'value' => $name,
]));
//Удалить куки
$cookies->remove('name');

//Получить значение кук браузера
$cookies = Yii::$app->request->cookies;
$value = $cookies->getValue('name');





//////////////////////////////////////////////////////////////////////////
/////////////////////////////////ВИДЖЕТ///////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//Виджет - визуальный блок на сайте
//http://localhost:8888/index.php?r=site/widget
//components/Hello.php
<?php
namespace app\components;
use yii\base\Widget;
use yii\helpers\Html;
class Hello extends Widget
{
    public $message;
    public function run()
    {
        $b = Html::tag('b', $this->message);
        $p = Html::tag('p', $b);
        return $p;
    }
}

//views/site/widget.php
<?php
use app\components\Hello;
?>
<h1><?= Hello::widget(['message' => 'Hello, World!']); ?></h1>





//////////////////////////////////////////////////////////////////////////
////////////////////////Active Record постобработка///////////////////////
//////////////////////////////////////////////////////////////////////////
public function afterFind(){
     $this->img = "path/to/file/" . $this->img . ".png";
}





//////////////////////////////////////////////////////////////////////////
////////////////////Подключение CSS и JavaScript//////////////////////////
//////////////////////////////////////////////////////////////////////////
//Файлы
www/web/css/ie.css
www/web/css/main.css
www/web/js/file.js
assets/AppAsset.php
assets/MyAppAsset.php

//assets/AppAsset.php
public $basePath = '@webroot';
public $baseUrl = '@web';
public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
    'app\assets\MyAppAsset',
];

public $css = [
    'css/ie.css',
];
public $cssOptions = [
    //аттрибут condition для тэга link
    'condition' => 'lte IE8'
];
public $js = [
    'js/file.js',
    '//vk.com/js/api/openapi.js',
];

//assets/MyAppAsset.php
//Чтобы main.css был без condition="lte IE8"
namespace app\assets;
use yii\web\AssetBundle;
class MyAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
    ];
}





//////////////////////////////////////////////////////////////////////////
////////////////////Методы и переменные представления/////////////////////
//////////////////////////////////////////////////////////////////////////
$content;
$action;
$this->title = 'Page title';
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'here goes the description',
]);





//////////////////////////////////////////////////////////////////////////
///////////////////////////Поиск по сайту/////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//Форма для поиска
//models/SearchForm.php
namespace app\models;
use yii\base\Model;
class SearchForm extends Model
{
    public $q;
    public function rules()
    {
        return [
            ['q', 'string']
        ];
    }
}

//Вьюшка
<?php use yii\widgets\ActiveForm; ?>
<?php use yii\models\SearchForm; ?>
<?php $model = new SearchFom(); ?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'q')->textInput(['class'=>'input'])->label(''); ?>
<?php ActiveForm::end(); ?>


//SiteController.php
//Получение запроса из формы поиска
public function beforeAction($action)
{
    $model = new SearchForm();
    if($model->load(Yii::$app->request->post()) && $model->validate()){
        $q = Html::encode($model->q);
        return $this->redirect(Yii::$app->urlManager->createUrl(['site/search', 'q' => $q]));
    }
    return  true;
}

//Страница поиска
public function actionSearch()
{
    $a = Yii::$app->getRequest()->getQueryParam('q');
    //...
}





//////////////////////////////////////////////////////////////////////////
////////////////////////////////ЧПУ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//config/web.php
'components' => [
    'request' => [
        'cookieValidationKey' => 'qwertyasdfghqwrty',
        //Чтобы убрать слово web из url
        'baseUrl' => '',
    ]
],
'urlManager' => [
     'enablePrettyUrl' => true,
    //Убрать index.php
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'app\components\SefRule',
            'connectionID' => 'db',
        ],
    ],
],

//www/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/(web)
RewriteRule (.*) /web/$1
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /web/index.php

//www/web/.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php

//components/SefRule.php
namespace app\components;

use yii\web\UrlRule;
use app\models\Sef;

class SefRule extends UrlRule
{
    public $connectionID = 'db';

    public function init()
    {
        if($this->name === null){
            $this->name = __CLASS__;
        }
    }

    public function createUrl($manager, $route, $params)
    {
        if($route == 'site/index') return "";
        if($route == 'site/search') return "search.html?q=" . $params["q"];
        $link = $route;
        if(count($params)){

        }
    }

}

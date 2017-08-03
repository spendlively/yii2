<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHello($name = "World")
    {
        return $this->render('hello', [
            'message' => $name,
        ]);
    }

    public function actionForm()
    {
        $form = new \app\models\MyForm();
        $name = '';
        $email = '';

        if($form->load(Yii::$app->request->post()) && $form->validate()){

            $name = \yii\helpers\Html::encode($form->name);
            $email = \yii\helpers\Html::encode($form->email);
            //mkdir /web/photo
            $form->file = \yii\web\UploadedFile::getInstance($form, 'file');
            $form->file->saveAs('photo/' . $form->file->baseName . '.' . $form->file->extension);
        }

        return $this->render('form', [
            'form' => $form,
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function actionComments()
    {

        $comments = \app\models\Comments::find()->all();

        return $this->render('comments', [
            'comments' => $comments,
        ]);
    }

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

    public function actionLink()
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

        return $this->render('link', [
            'comments' => $comments,
            'pagination' => $pagination,
        ]);
    }

    public function actionUser()
    {

        $name = yii::$app->request->get('name'); //null по умолчанию

        return $this->render('user', [
            'name' => $name,
        ]);
    }

    public function actionSession()
    {

        $name = yii::$app->request->get('name');

        //Сессию не надо открывать вручную
        $session = yii::$app->session;
        $session->set('name', $name);
//        $session->remove('name');
//        $session->get('name');

        var_dump($session->get('name'));die();
    }

    public function actionCookies()
    {

        $name = yii::$app->request->get('name');

        //Записать значение в куку пользователя
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'name',
            'value' => $name,
        ]));
        //Удалить куки
//        $cookies->remove('name');

        //Получить значение кук браузера
        $cookies = Yii::$app->request->cookies;
        $value = $cookies->getValue('name');
        var_dump($value);
    }

    public function actionWidget()
    {
        return $this->render('widget');
    }
}

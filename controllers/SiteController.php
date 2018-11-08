<?php

namespace app\controllers;

use app\models\BaseStations;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SSP;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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

        $model->password = '';
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
     * Displays about page.
     *
     * @return string
     */

    public function actionMap()
    {
        return $this->render('map');
    }

    public function actionMapAll()
    {
        return $this->render('map_ex');
    }

    public function actionMapFiltration()
    {
        return $this->render('map_e');
    }

    public function actionCoordinatesEx()
    {
        $coordinate = BaseStations::find()->asArray()->all();
        return json_encode($coordinate);
    }

    public function actionCoordinatesE()
    {

    }


    public function actionCoordinates()
    {
        $coordinate = BaseStations::find()->asArray()->limit(5000)->all();
        $sql = 'SELECT DISTINCT (company_title) FROM base_stations';
        $stations = BaseStations::findBySql($sql)->asArray()->all();
        return json_encode($coordinate);
    }

    public function actionServerSide()
    {
        $table = 'base_stations';
        $primaryKey = 'id';

        $columns = array(
            array('db' => 'id', 'dt' => 0),
            array('db' => 'company_title', 'dt' => 1),
            array('db' => 'res', 'dt' => 2),
            array('db' => 'placement', 'dt' => 3),
            array('db' => 'azimuth', 'dt' => 4),
        );

        $sql_details = \Yii::$app->params['sql_details'];

        return json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }


}

<?php


namespace app\controllers;



use app\models\Food_categories;
use app\models\Food_products;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class FoodController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function($rule, $action) {
                            return $this->redirect(Url::toRoute(['/site/login']));
                        }
                    ],
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action)
                        {
                            /** @var User $user */
                            $user = \Yii::$app->user->getIdentity();
                            if ($user->isUser())
                            {
                                return $user->isUser();
                            }
                            else if ($user->isTd())
                            {
                                return $this->redirect(Url::toRoute(['/admin/']));
                            }
                            else
                            {
                                return $this->redirect(Url::toRoute(['/foodadmin/orders', 'type' => 'new']));
                            }


                        },
                    ],
                ],
            ],
        ];
    }

    public function actionCategory(string $id = 'all')
    {
        if ($id == 'all')
        {
            $model = Food_products::find()->where(['>', 'qty', 0]);;
        }
        else
        {
            $model = Food_products::find()->where(['>', 'qty', 0])->andWhere(['category_id'=> $id]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('category', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionProduct(int $id)
    {
        $model = Food_products::find()->where(['id' => $id])->one();
        return $this->render('product', [
            'model' => $model,
        ]);
    }

}
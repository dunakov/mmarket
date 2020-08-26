<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 03.10.2019
 * Time: 10:41
 */

namespace app\controllers;


use app\models\Baby_assortment;
use app\models\Baby_kits;
use app\models\Bed_dress;
use app\models\Bed_set;
use app\models\Bed_sheets;
use app\models\Food_orders;
use app\models\Knitwear;
use app\models\Napkins;
use app\models\Other;
use app\models\Pillows;
use app\models\Table_linen;
use app\models\Underpants;
use app\models\Working_robes;
use phpDocumentor\Reflection\Types\Integer;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Expression;

class BlakitController extends Controller
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionProduct(string $category, int $id)
    {
        $modelname = "app\\models\\".ucfirst($category);
        $model =$modelname::find()->where(['id' => $id])->one();
        return $this->render('product', [
            'model' => $model,
            'category' => $category
        ]);
    }

    public function actionCabinet()
    {
        $user = \app\models\Users::find()->where(['id' => \Yii::$app->user->getId()])->one();
        $orders = \app\models\Orders::find()->where(['user_id' => \Yii::$app->user->getId()])->orderBy(['time_order' => SORT_DESC])->all();
        $food_orders = Food_orders::find()->where(['user_id' => \Yii::$app->user->getId()])->orderBy(['time_order' => SORT_DESC])->all();
        return $this->render('cabinet',
            [
                'user' => $user,
                'orders' => $orders,
                'food_orders' => $food_orders
            ]);
    }

    public function actionBed_sheets(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Bed_sheets::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        /*andWhere(['<>','image','noimage.jpg'])*/
        else
        {
            $model = Bed_sheets::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('bed_sheets', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionTable_linen(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Table_linen::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Table_linen::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('table_linen', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionKnitwear(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Knitwear::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Knitwear::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('knitwear', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionBaby_assortment(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Baby_assortment::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Baby_assortment::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['product_group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('baby_assortment', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionBaby_kits(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Baby_kits::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Baby_kits::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['product_group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('baby_kits', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionBed_set(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Bed_set::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Bed_set::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('bed_set', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }


    public function actionPillows(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Pillows::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Pillows::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('pillows', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionBed_dress(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Bed_dress::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Bed_dress::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('bed_dress', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionOther(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Other::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Other::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('other', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionUnderpants(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Underpants::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Underpants::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('underpants', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionNapkins(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Napkins::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Napkins::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('napkins', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionWorking_robes(string $subcategory = 'all')
    {
        if ($subcategory == 'all')
        {
            $model = Working_robes::find()->where(['barcode'=> arrayWarehouse()])->orderBy(['price' => SORT_ASC]);
        }
        else
        {
            $model = Working_robes::find()->where(['barcode'=> arrayWarehouse()])->andWhere(['group' => $subcategory])->orderBy(['price' => SORT_ASC]);
        }
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('working_robes', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }


}
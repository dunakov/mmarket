<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 25.10.2019
 * Time: 13:17
 */

namespace app\controllers;



use app\models\FeedbackForm;
use app\models\Food_categories;
use app\models\Food_order_items;
use app\models\Food_orders;
use app\models\Food_products;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use function React\Promise\all;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\web\Controller;
use moonland\phpexcel\Excel;

class FoodadminController extends Controller

{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                            return $user->isCanteen();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'food_main';
        return $this->redirect(Url::toRoute(['/foodadmin/orders', 'type' => 'neworders']));
    }

    public function actionOrders($type = '', $date_from = '', $date_to = '')
    {
        $this->layout = 'food_main';
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost)
        {
            $id = \Yii::$app->request->post('id');
            $arr_ret = \Yii::$app->request->post('arr_ret');
            $handeorder = Food_orders::findOne(['id' => $id]);
            if ($handeorder->status == 0)
            {
                if(!empty($arr_ret))
                {
                    foreach ($arr_ret as $key => $value)
                    {
                        $order_item = Food_order_items::findOne(['id' => $key]);
                        $order_item->cancel = 1;
                        $order_item->cancel_count = $value;
                        /*$food_prod = Food_products::find()->where(['id' => $order_item->product_id])->one();
                        $food_prod->qty = $food_prod->qty + $value;
                        $food_prod->save();*/
                        $order_item->save();
                    }
                }
                Food_order_items::updateAll(['preorder' => 0], ['order_id'=>$id]);
                $handeorder->status = 1;
                $handeorder->save();
            }
            else
            {
                Food_order_items::updateAll(['cancel'=> 0, 'cancel_count' => 0, 'preorder' => 1], ['order_id'=>$id]);
                $handeorder->status = 0;
                $handeorder->save();
            }

            return $this->asJson($arr_ret);
        }

        if ($type == 'new')
        {
            if (isset($date_from) && $date_from != '' && isset($date_to) && $date_to != '')
            {
                $model = Food_orders::find()->where(['between', 'time_order', $date_from." "."00:00:00", $date_to." "."23:59:00"])->orderBy(['time_order' => SORT_DESC])->all();
                $model_count = Food_orders::find()->where(['between', 'time_order', $date_from." "."00:00:00", $date_to." "."23:59:00"])->orderBy(['time_order' => SORT_DESC]);
                $count = $model_count->count();
                return $this->render('neworders',
                    [
                        'model' => $model,
                        'count' => $count
                    ]);
            }
            else
            {
                $model = Food_orders::find()->where(['status' => 0])->orderBy(['time_order' => SORT_DESC])->all();
                $model_count = Food_orders::find()->where(['status' => 0])->orderBy(['time_order' => SORT_DESC]);
                $count = $model_count->count();
                return $this->render('neworders',
                    [
                        'model' => $model,
                        'count' => $count
                    ]);
            }

        }
        elseif ($type == 'processed')
        {
            if (isset($date_from) && $date_from != '' && isset($date_to) && $date_to != '')
            {
                $model = Food_orders::find()->where(['between', 'time_order', $date_from." "."00:00:00", $date_to." "."23:59:00"])->orderBy(['time_order' => SORT_DESC]);
                $countModel = clone $model;
                $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
                $models = $model->offset($pages->offset)->limit($pages->limit)->all();

                $model_count = Food_orders::find()->where(['status' => 1])->andWhere(['between', 'time_order', $date_from." "."00:00:00", $date_to." "."23:59:00"])->orderBy(['time_order' => SORT_DESC]);
                $count = $model_count->count();
                return $this->render('processedorders',
                    [
                        'pages' => $pages,
                        'model' => $models,
                        'count' => $count
                    ]);
            }
            else
            {
                $model = Food_orders::find()->where(['status' => 1])->orderBy(['time_order' => SORT_DESC]);
                $countModel = clone $model;
                $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
                $models = $model->offset($pages->offset)->limit($pages->limit)->all();
                $model_count = Food_orders::find()->where(['status' => 1])->orderBy(['time_order' => SORT_DESC]);
                $count = $model_count->count();
                return $this->render('processedorders',
                    [
                        'pages' => $pages,
                        'model' => $models,
                        'count' => $count
                    ]);
            }



        }
        return false;


    }
    public function actionView($category = '')
    {
        $model = Food_products::find()->orderBy(['id' => SORT_DESC])->all();
        $this->layout = 'food_main';
        if ($category !=='')
        {
            $model = Food_products::find()->where(['category_id' => $category])->orderBy(['id' => SORT_DESC])->all();
            return $this->render('view',
                [
                    'model' => $model
                ]);
        }

        return $this->render('view',
            [
                'model' => $model
            ]);
    }
    public  function  actionUpdate($id)
    {

        $this->layout = 'food_main';
        $model = Food_products::findOne($id);

        if ($model->load(\Yii::$app->request->post()))
        {
            $model->calculatePrice();
            $model->save();
            return $this->redirect(['foodadmin/view']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public  function  actionCreate()
    {
        $this->layout = 'food_main';
        $model = new Food_products();

        if ($model->load(\Yii::$app->request->post()))
        {
            $model->calculatePrice();
            $model->save();
            return $this->redirect(['foodadmin/view']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    public function actionMessages()
    {
        $this->layout = 'food_main';
        $model = FeedbackForm::find()->orderBy(['status' => SORT_ASC]);
        $countModel = clone $model;
        $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
        $models = $model->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('messages',
            [
                'pages' => $pages,
                'model' => $models
            ]
        );
    }

    public  function actionViewmess(int $id)
    {
        $this->layout = 'food_main';
        $model = FeedbackForm::findOne($id);
        $model->status = 1;
        $model->save();
        return $this->render('viewmess',
            [
                'model' => $model
            ]
        );

    }

    public  function actionExport($from = "", $to = "")
    {
        $this->layout = 'food_main';
        if ($from != "" && $to != "")
        {
            $orders_id = Food_orders::find()->where(['between', 'time_order', $from." "."00:00:00", $to." "."23:59:00"])->asArray()->all();
            $spreadsheet = new Spreadsheet();
            $spreadsheet->getProperties()
                ->setCreator('Maarten Balliauw')
                ->setLastModifiedBy('Maarten Balliauw')
                ->setTitle('PhpSpreadsheet Test Document')
                ->setSubject('PhpSpreadsheet Test Document')
                ->setDescription('Test document for PhpSpreadsheet, generated using PHP classes.')
                ->setKeywords('office PhpSpreadsheet php')
                ->setCategory('Test result file');
            $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();
            $richText->createText('Выгрузка за период');
            $payable = $richText->createTextRun(' c '.$from.' по '.$to);
            $payable->getFont()->setSize(16);
            $payable->getFont()->setBold(true);
            $payable->getFont()->setColor( new \PhpOffice\PhpSpreadsheet\Style\Color( \PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED) );
            $richText->createText('');
            $spreadsheet->getActiveSheet()->getCell('A1')->setValue($richText);
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
            $spreadsheet->getActiveSheet()->mergeCells('A1:G1');
            $styleArrayHeaders = [
                'font' => [
                    'italic' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            $sizeStyles = [
                'font' => [
                    'size' => 18
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ],
            ];
            foreach ($orders_id as $order)
            {
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();
                for ($row = 1; $row <= $highestRow; ++$row)
                {
                    if ($row = $highestRow)
                    {
                        $user = \app\models\Users::findOne(['id'=>$order['user_id']]);
                        $row++;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'ЗАКАЗ № '.$order['id']);
                        $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(50);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'G'.$row);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->applyFromArray($sizeStyles);
                        $row++;
                        $spreadsheet->getActiveSheet()->mergeCells('A2:G2');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $user->fio.' Цех/табельный номер:  '.$user->login);
                        $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight(50);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'G'.$row);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->applyFromArray($sizeStyles);
                        $row++;
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'G'.$row);
                        $row++;
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'G'.$row);
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A'.$row, $user->fio.' Цех и табельный номер  '.$user->login.' № ЗАКАЗА - '.$order['id']);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'G'.$row);
                        $model = Food_order_items::find()->where(['order_id' => $order['id']])->all();
                        $row++;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Наименование');
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Кол.');
                        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$row, 'Код');
                        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, 'Тип');
                        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Цена за Кг/Шт');
                        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                        $spreadsheet->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setWrapText(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$row, 'Вес');
                        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(9);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, 'Фин. цена');
                        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                        $spreadsheet->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setWrapText(true);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.'E'.$row)->applyFromArray($styleArrayHeaders);
                        $row++;
                        $total_start = $row;
                        foreach ($model as $item)
                        {
                            $product = Food_products::find()->where(['id' => $item->product_id])->one();
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $product->name);
                            $spreadsheet->getActiveSheet()->getStyle('A'.$row)->getAlignment()->setWrapText(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$row, ($item->qty - $item->cancel_count));
                            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$row, $product->id);
                            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, $product->weighted == 1 ? 'Взвеш.': 'Шт.');
                            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, $product->price_per_kg);
                            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                            if ($product->weighted == 1)
                            {
                                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, '='.'ROUND'.'('.'('.'E'.$row.'*'.'F'.$row.')'.','.'2)');
                            }
                            else
                            {
                                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, '='.'ROUND'.'('.'('.'E'.$row.'*'.'B'.$row.')'.','.'2)');
                            }

                            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                            $spreadsheet->getActiveSheet()->getStyle('E'.$row)->getAlignment()->setWrapText(true);

                            $row++;
                        }

                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Пакет:');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, 0);
                        $total_end = $row;
                        $row++;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Итого:');
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, '='.'SUM('.'G'.$total_start.':'.'G'.$total_end.')');
                        $row++;
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'G'.$row);
                    }
                }
            }


            $worksheet1 = $spreadsheet->getActiveSheet();
            $highestRow1 = $worksheet1->getHighestRow();
            $arr_orders =[];
            for ($row = 1; $row <= $highestRow1; ++$row)
            {
                if ($row = $highestRow1)
                {
                    $row = 4 + $row;
                    foreach ($orders_id as $order)
                    {
                        $model_order = Food_order_items::find()->where(['order_id' => $order['id']])->all();
                        foreach ($model_order as $order_it)
                        {
                            if (isset($arr_orders[$order_it['product_id']]))
                            {
                                $arr_orders[$order_it['product_id']]['qty']+= ($order_it['qty'] - $order_it['cancel_count']);
                            }
                            else
                            {
                                $product = Food_products::find()->where(['id' => $order_it['product_id']])->one();
                                $arr_orders[$order_it['product_id']]['name'] = $product->name;
                                $arr_orders[$order_it['product_id']]['qty'] = ($order_it['qty'] - $order_it['cancel_count']);
                            }
                        }
                    }
                    $row++;
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Название товара');
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, 'Кол.');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Код');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$row, 'Вес');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, 'Фин. цена');
                    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                    $spreadsheet->getActiveSheet()->getStyle('G'.$row)->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.'E'.$row)->applyFromArray($styleArrayHeaders);
                    $row++;
                    foreach ($arr_orders as $key_o => $value_o)
                    {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $value_o['name']);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, $value_o['qty']);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, $key_o);
                        $row++;
                    }
                }
            }

            $styleArray = [
                'font' => [
                    'bold' => true,
                    'size' => 16
                ],

            ];
            $styleArrayAlltable =
                [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],

                ];
            $worksheet2 = $spreadsheet->getActiveSheet();
            $highestRow2 = $worksheet2->getHighestRow();
            for ($row = 1; $row <= $highestRow2; $row++)
            {
                if ($row = $highestRow2)
                {
                    $spreadsheet->getActiveSheet()->getStyle('A1:'.'G'.$row)->applyFromArray($styleArrayAlltable);
                }
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);

            $spreadsheet->getActiveSheet()->setTitle('Simple');
            $writer= new Excel();
            $writer->writeFile($spreadsheet, 'Экспорт '.date('m-d-Y', time()).'.xlsx');
        }


        return $this->render('export');
    }

}
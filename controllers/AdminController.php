<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 25.10.2019
 * Time: 13:17
 */

namespace app\controllers;


use app\models\Baby_assortment;
use app\models\Baby_kits;
use app\models\Bed_dress;
use app\models\Bed_set;
use app\models\Bed_sheets;
use app\models\Knitwear;
use app\models\Napkins;
use app\models\OrderItems;
use app\models\Orders;
use app\models\Other;
use app\models\Pillows;
use app\models\Table_linen;
use app\models\Underpants;
use app\models\Users;
use app\models\Working_robes;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use function React\Promise\all;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\i18n\Formatter;
use yii\web\Controller;
use moonland\phpexcel\Excel;

class AdminController extends Controller

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
                            return $user->isTd();
                        }
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'admin_main';
        $count_users = Users::find()->count();
        $count_orders = Orders::find()->count();
        $sum_orders = Orders::find()->sum('sum');
        $new_orders = Orders::find()->where(['status' => 0])->orderBy(['time_order' => SORT_DESC])->limit(5)->all();
        $sum_orders_r = round($sum_orders, 1);
        $count_items = 0;
        $model_order = $model_order = \Yii::$app->blakit->createCommand('SELECT DISTINCT `barcode`, SUM(`qty`) as count FROM order_items GROUP BY `barcode` ORDER BY count DESC')->queryAll();

        foreach ($model_order as $order_it)
        {
            $count_items += $order_it['count'];
        }
        return $this->render('index',
            [
                'count_users' => $count_users,
                'count_orders' => $count_orders,
                'sum_orders' => $sum_orders_r,
                'model_order' => $model_order,
                'count_items' => $count_items,
                'new_orders' =>$new_orders
            ]);
    }

    public function actionOrders($type = '')
    {
        $this->layout = 'admin_main';
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost)
        {
            $id = \Yii::$app->request->post('id');
            $arr_ret = \Yii::$app->request->post('arr_ret');
            $handeorder = Orders::findOne(['id' => $id]);
            if ($handeorder->status == 0)
            {
                if(!empty($arr_ret))
                {
                    foreach ($arr_ret as $key => $value)
                    {
                        $order_item = OrderItems::findOne(['id' => $key]);
                        $order_item->cancel = 1;
                        $order_item->cancel_count = $value;
                        $order_item->save();
                    }
                }
                OrderItems::updateAll(['preorder' => 0], ['order_id'=>$id]);
                $handeorder->status = 1;
                $handeorder->save();
            }
            else
            {
                OrderItems::updateAll(['cancel'=> 0, 'cancel_count' => 0, 'preorder' => 1], ['order_id'=>$id]);
                $handeorder->status = 0;
                $handeorder->save();
            }

            return $this->asJson($arr_ret);
        }

        if ($type == 'new')
        {
            $model = Orders::find()->where(['status' => 0])->orderBy(['time_order' => SORT_DESC])->all();
            return $this->render('neworders',
                [
                    'model' => $model
                ]);
        }
        elseif ($type == 'processed')
        {
            $model = Orders::find()->where(['status' => 1])->orderBy(['time_order' => SORT_DESC]);
            $countModel = clone $model;
            $pages = new Pagination(['totalCount' => $countModel->count(), 'defaultPageSize' => 20]);
            $models = $model->offset($pages->offset)->limit($pages->limit)->all();
            return $this->render('processedorders',
                [
                    'pages' => $pages,
                    'model' => $models
                ]);
        }
        return false;


    }

    public function actionNomenclature()
    {
        $this->layout = 'admin_main';
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost)
        {
            $barcode = \Yii::$app->request->post('barcode');
            $model = Baby_assortment::find()->where(['barcode' => $barcode])->all();
            if ($model == false)
            {
                $model = Baby_kits::find()->where(['barcode' => $barcode])->all();
                if ($model == false)
                {
                    $model = Bed_dress::find()->where(['barcode' => $barcode])->all();
                    if ($model == false)
                    {
                        $model = Bed_set::find()->where(['barcode' => $barcode])->all();
                        if ($model == false)
                        {
                            $model = Bed_sheets::find()->where(['barcode' => $barcode])->all();
                            if ($model == false)
                            {
                                $model = Knitwear::find()->where(['barcode' => $barcode])->all();
                                if ($model == false)
                                {
                                    $model = Napkins::find()->where(['barcode' => $barcode])->all();
                                    if ($model == false)
                                    {
                                        $model = Other::find()->where(['barcode' => $barcode])->all();
                                        if ($model == false)
                                        {
                                            $model = Pillows::find()->where(['barcode' => $barcode])->all();
                                            if ($model == false)
                                            {
                                                $model = Table_linen::find()->where(['barcode' => $barcode])->all();
                                                if ($model == false)
                                                {
                                                    $model = Underpants::find()->where(['barcode' => $barcode])->all();
                                                    if ($model == false)
                                                    {
                                                        $model = Working_robes::find()->where(['barcode' => $barcode])->all();
                                                        if ($model !== false)
                                                        {
                                                            return $this->asJson($model);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        return $this->asJson($model);
                                                    }
                                                }
                                                else
                                                {
                                                    return $this->asJson($model);
                                                }
                                            }
                                            else
                                            {
                                                return $this->asJson($model);
                                            }
                                        }
                                        else
                                        {
                                            return $this->asJson($model);
                                        }
                                    }
                                    else
                                    {
                                        return $this->asJson($model);
                                    }
                                }
                                else
                                {
                                    return $this->asJson($model);
                                }
                            }
                            else
                            {
                                return $this->asJson($model);
                            }
                        }
                        else
                        {
                            return $this->asJson($model);
                        }
                    }
                    else
                    {
                        return $this->asJson($model);
                    }
                }
                else
                {
                    return $this->asJson($model);
                }
            }
            else
            {
                return $this->asJson($model);
            }
        }

        return $this->render('nomenclature');
    }


    public  function actionExport($from = "", $to = "")
    {
        $this->layout = 'admin_main';
        if ($from != "" && $to != "")
        {
            $orders_id = Orders::find()->where(['between', 'time_order', $from." "."00:00:00", $to." "."23:59:00"])->asArray()->all();
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
            $spreadsheet->getActiveSheet()->mergeCells('A1:I1');
            $styleArrayHeaders = [
                'font' => [
                    'italic' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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
                        $row++;
                        $spreadsheet->getActiveSheet()->mergeCells('A2:I2');
                        $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A'.$row, $user->fio.' Цех и табельный номер  '.$user->login);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'I'.$row);
                        $model = OrderItems::find()->where(['order_id' => $order['id']])->all();
                        $row++;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Товарная группа');
                        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$row, 'Код товара');
                        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$row, 'Артикул');
                        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, 'Название товара');
                        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                        $spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Модель');
                        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$row, 'Номер ткани');
                        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, 'Номер рисунка');
                        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('H'.$row, 'Количество');
                        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('I'.$row, 'Цена ');
                        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.'I'.$row)->applyFromArray($styleArrayHeaders);
                        $row++;
                        foreach ($model as $item)
                        {
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $item->product_group);
                            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$row, $item->code);
                            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$row, $item->code_a);
                            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, $item->name);
                            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                            $spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, $item->model);
                            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$row, $item->fabric_number);
                            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$row, $item->fabric_image);
                            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H'.$row, ($item->qty - $item->cancel_count));
                            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I'.$row, $item->price);
                            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
                            $row++;
                        }
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
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Итого:');
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'E'.$row);
                    foreach ($orders_id as $order)
                    {
                        $model_order = OrderItems::find()->where(['order_id' => $order['id']])->all();
                        foreach ($model_order as $order_it)
                        {
                            if (isset($arr_orders[$order_it['barcode']]))
                            {
                                $arr_orders[$order_it['barcode']]['qty']+= ($order_it['qty'] - $order_it['cancel_count']);
                            }
                            else
                            {
                                $arr_orders[$order_it['barcode']]['name'] = $order_it['name'];
                                $arr_orders[$order_it['barcode']]['qty'] = ($order_it['qty'] - $order_it['cancel_count']);
                            }
                        }
                    }
                    $row++;
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, 'Название товара');
                    $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, 'Штрихкод');
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Количество');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$row.':'.'E'.$row)->applyFromArray($styleArrayHeaders);
                    $row++;
                    foreach ($arr_orders as $key_o => $value_o)
                    {
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$row, $value_o['name']);
                        $spreadsheet->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$row, $key_o);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$row, $value_o['qty']);
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
                    $spreadsheet->getActiveSheet()->getStyle('A1:'.'I'.$row)->applyFromArray($styleArrayAlltable);
                }
            }
            $spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray);

            $spreadsheet->getActiveSheet()->setTitle('Simple');
            $writer= new Excel();
            $writer->writeFile($spreadsheet, 'Экспорт '.date('m-d-Y', time()).'.xlsx');
        }


        return $this->render('export');
    }


}
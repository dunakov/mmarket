<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 21.10.2019
 * Time: 15:01
 */

namespace app\controllers;



use app\models\Baby_assortment;
use app\models\Baby_kits;
use app\models\Bedspreads;
use app\models\Blankets;
use app\models\Dining_linen;
use app\models\Dining_sets;
use app\models\Duvet_covers;
use app\models\Food_order_items;
use app\models\Food_orders;
use app\models\Food_products;
use app\models\Mattresses;
use app\models\OrderItems;
use app\models\Orders;
use app\models\Pillowcases;
use app\models\Pillows;
use app\models\Plaids;
use app\models\Sets;
use app\models\Towels;

use app\models\Cart;
use app\models\User;
use app\models\Users;
use Yii;
use yii\web\Controller;

class CartController extends Controller
{

    public function actionAdd(string $category, int $id)
    {
        $this->layout = false;
        $userlimit = Users::find()->where(['id' => \Yii::$app->user->getId()])->one();
        $categoryAjax = Yii::$app->request->get('category');
        $categoryId = Yii::$app->request->get('id');
        $count = Yii::$app->request->get('count');
        if (!$count)
        {
            $count =1;
        }
        if ($categoryAjax !== 'food')
        {
            $modelname = "app\\models\\".ucfirst($categoryAjax);
            $model =$modelname::find()->where(['id' => $categoryId])->one();
        }
        else
        {
            $model = Food_products::find()->where(['id' => $categoryId])->one();
        }

        if ($model == null)
        {
            return false;
        }
        else
        {
            $this->layout = false;
            $session = Yii::$app->session;
            $session->open();
            $cart = new Cart();
            if($cart->addToCart($model, $categoryAjax, $userlimit->limit_sum, $count))
            {
                return $this->render('cart-modal',
                    [
                        'session' => $session,
                    ]);
            }
            else
            {
                return false;
            }

        }

    }



    public function actionStatus()
    {
        $this->layout = false;
        $session = Yii::$app->session;
        $session->open();
        return $this->asJson($session['cart']);
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $session->remove('cart.min_sum');
        $session->remove('cart.max_sum');
        $this->layout=false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem()
    {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    public function actionShow()
    {
        $session =Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }
    public function actionQty()
    {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->asJson($session['cart.qty']);
    }
    public function actionView()
    {
        $session = Yii::$app->session;
        $session->open();
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isGet)
        {
            $user_tel_ajax = Yii::$app->request->get('user_tel');
            $user_model = Users::find()->where(['id' => \Yii::$app->user->getId()])->one();
            $user_model->user_tel = $user_tel_ajax;
            $user_model->save();
        }

        if (isset($session['cart']) && count($session['cart']) > 0)
        {
            return $this->render('view', [
                'session' => $session,
            ]);
        }
        else
        {
            return $this->redirect('/');
        }

    }

    public  function actionSaveorder()
    {
        $session = Yii::$app->session;
        $session->open();
        $order_items = $session['cart'];
        if(!empty($session['cart']))
        {
            foreach ($order_items as $o_id => $item)
            {
                $o_category = preg_replace('/[0-9]+/', '', $o_id);
                if ($o_category !== 'food')
                {
                    $param = $item['barcode'];
                    $arr = Yii::$app->blakit->createCommand('select sum(qty) from order_items where preorder = 1 and barcode =' . $param)->queryOne();
                    if ($item['qty'] > (countWarehouse($item['barcode']) - $arr['sum(qty)']))
                    {
                        if (isset($_SESSION['cart'][$o_id]))
                        {
                            if ((countWarehouse($item['barcode']) - $arr['sum(qty)']) !== 0)
                            {
                                //Пересчёт финальной суммы и количества
                                $_SESSION['cart.qty'] = $_SESSION['cart.qty'] - $item['qty'] + (countWarehouse($item['barcode']) - $arr['sum(qty)']);
                                $_SESSION['cart.sum'] = $_SESSION['cart.sum'] - $item['qty']*$item['price'] + (countWarehouse($item['barcode']) - $arr['sum(qty)'])*$item['price'];
                                $_SESSION['cart'][$o_id]['qty'] = countWarehouse($item['barcode']) - $arr['sum(qty)'];

                            }
                            else
                            {
                                $_SESSION['cart.qty'] = $_SESSION['cart.qty'] - $item['qty'];
                                $_SESSION['cart.sum'] = $_SESSION['cart.sum'] - $item['qty']*$item['price'];
                                unset($_SESSION['cart'][$o_id]);
                                if ($_SESSION['cart.qty'] == 0 )
                                {
                                    unset($_SESSION['cart']);
                                    unset($_SESSION['cart.qty']);
                                    unset($_SESSION['cart.sum']);
                                    return $this->render('view', [
                                        'error' => '804'
                                    ]);
                                }
                            }

                        }
                        return $this->render('view', [
                            'session' => $session,
                            'session_for' => $_SESSION['cart'],
                            'error' => '803'
                        ]);
                    }
                }
                else
                {
                    $food_prod = Food_products::find()->where(['id' => $item['id']])->one();
                    if ($item['qty'] > $food_prod->qty)
                    {
                        $cart_obj = new Cart();
                        $cart_obj->recalc($o_id);
                        return $this->render('view', [
                            'session' => $session,
                            'error' => '805'
                        ]);
                    }

                }

            }
        }
        $food_arr = [];
        $blakit_arr = [];
        $number_of_order_b = '';
        $number_of_order_f = '';
        if(!empty($session['cart']))
        {
            foreach ($order_items as $o_id => $item) {
                $o_category = preg_replace('/[0-9]+/', '', $o_id);
                if ($o_category == 'food') {
                    $food_arr[$o_id] = $item;
                } else {
                    $blakit_arr[$o_id] = $item;
                }
            }
        }
        if(!empty($session['cart']))
        {
            if (!empty($blakit_arr))
            {
                $orders = new Orders();
                $orders->user_id = Yii::$app->user->getId();
                $orders->sum = $session['cart.sum'];
                $orders->save();
                $number_of_order_b = 'Ваш заказ по домашнему текстилю '.'<b>'.'№ '.$orders->id.'</b>';
                $this->saveOrderItems($blakit_arr, $orders->id);
            }
            if (!empty($food_arr))
            {
                $food_orders = new Food_orders();
                $food_orders->user_id = Yii::$app->user->getId();
                $food_orders->sum = 0;
                $food_orders->save();
                $number_of_order_f = 'Ваш заказ по продуктам питания '.'<b>'.'№ '.$food_orders->id.'</b>';
                $this->saveOrderItems($food_arr, $food_orders->id);
            }
            $session->remove('cart');
            $session->remove('cart.qty');
            $session->remove('cart.sum');
            return $this->render('saveorder', [
                'order_id_b' => $number_of_order_b,
                'order_id_f' => $number_of_order_f,
            ]);
        }
        else
        {
            return $this->redirect(\yii\helpers\Url::to(['/']));
        }

    }

    protected function saveOrderItems($items, $order_id)
    {
        foreach($items as $id => $item)
        {
            $category = $words = preg_replace('/[0-9]+/', '', $id);
            if ($category !== 'food')
            {
                $id = preg_replace('~\D+~','',$id);
                $modelname = "app\\models\\".ucfirst($category);
                $model =$modelname::find()->where(['id' => $id])->one();
                $order_items = new OrderItems();
                $order_items->order_id = $order_id;
                $order_items->product_group = $model->product_group;
                $order_items->code = $model->code;
                $order_items->code_a = $model->code_a;
                $order_items->name = $model->name;
                $order_items->model = $model->model;
                $order_items->fabric_number = $model->fabric_number;
                $order_items->fabric_image = $model->fabric_image;
                $order_items->barcode = $model->barcode;
                $order_items->qty = $item['qty'];
                $order_items->price = $model->price;
                $order_items->save();
            }
            else
            {
                $id = preg_replace('~\D+~','',$id);
                $model = Food_products::find()->where(['id' => $id])->one();
                $food_order_items = new Food_order_items();
                $food_order_items->order_id = $order_id;
                $food_order_items->product_id= $item['id'];
                $food_order_items->qty = $item['qty'];
                $food_order_items->save();
                $food_prod = Food_products::find()->where(['id' => $item['id']])->one();
                $food_prod->qty = $food_prod->qty - $item['qty'];
                $food_prod->save();
            }

        }
    }

}
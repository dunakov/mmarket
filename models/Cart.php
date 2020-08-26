<?php
/**
 * Created by PhpStorm.
 * User: uit09
 * Date: 21.10.2019
 * Time: 15:08
 */

namespace app\models;



use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function addToCart($product, $categoryAjax, $user_limit, $qty = 1)
    {
        if ($categoryAjax !== 'food')
        {
            $param = $product->barcode;
            $arr = \Yii::$app->blakit->createCommand('select sum(qty) from order_items where preorder = 1 and barcode =' . $param)->queryOne();
            if ($qty <= (@countWarehouse($product->barcode) - @$arr['sum(qty)']))
            {
                $sumUser = Orders::find()->where(['user_id' => \Yii::$app->user->getId()])->andWhere("MONTH(`time_order`) = MONTH(NOW()) AND YEAR(`time_order`) = YEAR(NOW())")->sum('sum');
                if (($sumUser + @$_SESSION['cart.sum'] + ($qty * @realPrice($product->barcode) - @$_SESSION['cart'][$product->id . $categoryAjax]['price'] * @$_SESSION['cart'][$product->id . $categoryAjax]['qty'])) <= $user_limit) {
                    $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] - @$_SESSION['cart'][$product->id . $categoryAjax]['qty'] + $qty : $qty;
                    $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] - @$_SESSION['cart'][$product->id . $categoryAjax]['price'] * @$_SESSION['cart'][$product->id . $categoryAjax]['qty'] + $qty * realPrice($product->barcode) : $qty * realPrice($product->barcode);
                    if (isset($_SESSION['cart'][$product->id . $categoryAjax])) {
                        $_SESSION['cart'][$product->id . $categoryAjax]['qty'] = $qty;
                    } else {
                        $_SESSION['cart'][$product->id . $categoryAjax] =
                            [
                                'qty' => $qty,
                                'name' => $product->name,
                                'price' => realPrice($product->barcode),
                                'img' => $product->image,
                                'category' => $categoryAjax,
                                'id' => $product->id,
                                'barcode' => $product->barcode,
                            ];
                    }
                    return true;
                } else {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            if ($qty <= $product->qty)
            {
                $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] - @$_SESSION['cart'][$product->id . $categoryAjax]['qty'] + $qty : $qty;

                $_SESSION['cart.min_sum'] = isset($_SESSION['cart.min_sum']) ? $_SESSION['cart.min_sum'] - @$_SESSION['cart'][$product->id . $categoryAjax]['min_price'] * @$_SESSION['cart'][$product->id . $categoryAjax]['qty'] + $qty * $product->min_price : $qty * $product->min_price;
                $_SESSION['cart.max_sum'] = isset($_SESSION['cart.max_sum']) ? $_SESSION['cart.max_sum'] - @$_SESSION['cart'][$product->id . $categoryAjax]['max_price'] * @$_SESSION['cart'][$product->id . $categoryAjax]['qty'] + $qty * $product->max_price : $qty * $product->max_price;
                if (isset($_SESSION['cart'][$product->id . $categoryAjax]))
                {
                    $_SESSION['cart'][$product->id . $categoryAjax]['qty'] = $qty;
                } else {
                    $_SESSION['cart'][$product->id . $categoryAjax] =
                        [
                            'qty' => $qty,
                            'name' => $product->name,
                            'price' => 0,
                            'img' => $product->image,
                            'category' => $categoryAjax,
                            'id' => $product->id,
                            'barcode' => $product->id,
                            'weighted' => $product->weighted,
                            'packing_size' => $product->packing_size,
                            'price_per_kg' => $product->price_per_kg,
                            'min_price' => $product->min_price,
                            'max_price' => $product->max_price,
                        ];
                }
                return true;
            }
            else
            {
                return false;
            }


        }

    }

    public function recalc($id)
    {
        $o_category = preg_replace('/[0-9]+/', '', $id);
        if(isset($_SESSION['cart'][$id]))
        {
            $qtyMinus = $_SESSION['cart'][$id]['qty'];
            $_SESSION['cart.qty'] -= $qtyMinus;
            if ($o_category !=='food')
            {
                $sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
                $_SESSION['cart.sum'] -= $sumMinus;
                unset($_SESSION['cart'][$id]);
            }
            else
            {
                $min_sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['min_price'];
                $max_sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['max_price'];
                $_SESSION['cart.min_sum'] -= $min_sumMinus;
                $_SESSION['cart.max_sum'] -= $max_sumMinus;
                unset($_SESSION['cart'][$id]);
            }

        }
        else
        {
            return false;
        }
    }

}
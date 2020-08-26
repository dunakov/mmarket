<?php
$this->title = 'Admin Panel';
?>
<section id="main-content">
    <section class="wrapper">
        <!-- //market-->
        <div class="market-updates">
            <div class="col-md-4 market-update-gd">
                <div class="market-update-block clr-block-1">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-users" ></i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>Пользователей</h4>
                        <h3><?=$count_users;?></h3>
                        <p>Количество пользователей в базе</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="col-md-4 market-update-gd">
                <div class="market-update-block clr-block-3">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-usd"></i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>Сумма</h4>
                        <h3><?=$sum_orders;?> BYN</h3>
                        <p>Сумма заказов за всё время</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="col-md-4 market-update-gd">
                <div class="market-update-block clr-block-4">
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    </div>
                    <div class="col-md-8 market-update-left">
                        <h4>Заказов</h4>
                        <h3><?=$count_orders;?></h3>
                        <p>Количество заказов за всё время</p>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>

        <div class="agileits-w3layouts-stats">
            <div class="col-md-4 stats-info widget">
                <div class="stats-info-agileits">
                    <div class="stats-title">
                        <h4 class="title">Популярные товары</h4>
                    </div>
                    <div class="stats-body">
                        <ul class="list-unstyled">
                            <?php $i=0; $color = ''; foreach ($model_order as $item) :?>
                            <?php $i++;  ?>
                            <li><?=$item['barcode'];?> <span class="pull-right"><?=$item['count'];?></span>
                                <?php switch($i)
                                {
                                    case 1:
                                        $color = 'green';
                                        break;
                                    case 2:
                                        $color = 'yellow';
                                        break;
                                    case 3:
                                        $color = 'red';
                                        break;
                                    case 4:
                                        $color = 'blue';
                                        break;
                                    case 5:
                                        $color = 'light-blue';
                                        break;
                                    case 6:
                                        $color = 'orange';
                                        break;

                                }

                                 ?>
                                <?php $percent = round(($item['count'] / $count_items),2)  ?>
                                <div class="progress progress-striped active progress-right">
                                    <div class="bar <?=$color?>" style="width:<?=$percent*100?>%;"></div>
                                </div>
                            </li>
                            <?php if ($i == 6) {break;} ?>

                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8 stats-info stats-last widget-shadow">
                <div class="stats-last-agile">
                    <div class="stats-title">
                        <h4 class="title">Последние заказы</h4>
                    </div>
                    <table class="table stats-table">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th class="text-center">Дата</th>
                            <th class="text-center">Заказчик</th>
                            <th class="text-center">Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($new_orders as $new_order) :?>
                        <tr>
                            <th scope="row"><?=$new_order['id'];?></th>
                            <td class="text-center"><?=$new_order['time_order']?></td>
                            <td class="text-center"><?=$new_order->users['fio']?></td>
                            <td class="text-center"><span class="label label-warning">Новый</span></td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </section>
    <!-- footer -->
    <div class="footer">
        <div class="wthree-copyright">
            <p>Admin Control Center</p>
        </div>
    </div>
    <!-- / footer -->
</section>
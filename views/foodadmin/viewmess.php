<?php
$this->title = 'Сообщения';

use yii\helpers\Url;

?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Просмотр сообщения  № <?=$model->id?></h4>
                </div>
                <div class="viewmess">

                    <?php if($model->name !== '') :?>
                        <p>Имя: <?=$model->name?></p>
                    <?php endif; ?>
                    <?php if($model->email !== '') :?>
                        <p>Email: <?=$model->email?></p>
                    <?php endif; ?>
                    <?php if($model->tel !== '') :?>
                        <p>Телефон: <?=$model->tel?></p>
                    <?php endif; ?>
                    <p>Сообщение:</p>
                    <div>
                        <ul class="message_user">
                            <div class="alert alert-info">
                                <?=$model->text?>
                            </div>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
        <div class="clearfix"> </div>
    </section>
    <!-- footer -->
    <div class="footer">
        <div class="wthree-copyright">
            <p>Admin Control Center</p>
        </div>
    </div>
    <!-- / footer -->
</section>

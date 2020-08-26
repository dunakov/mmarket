<?php
$this->title = 'Экспорт';
?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Экспорт данных</h4>

                    <div class="excel-block">
                        <label for="from">От</label>
                        <input type="text" id="from">
                        <label for="to">До</label>
                        <input type="text" id="to">
                        <?= \yii\helpers\Html::img("@web/images/excel.png", ['alt' => 'excel_ico', 'id' => 'excelimg', 'height' => 50]) ?>
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
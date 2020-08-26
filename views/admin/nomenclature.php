<?php
$this->title = 'Номенклатура';
?>
<section id="main-content">
    <section class="wrapper">
        <div class="col-md-12 stats-info stats-last widget-shadow" style="margin-bottom: 20px">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Номенклатура товаров</h4>
                    <form class="form-inline" id="searchform" onsubmit="return false">
                        <div class="form-group">
                            <label for="barcode">Штрихкод:</label>
                            <input type="text" class="form-control" id="barcode">
                        </div>
                        <button type="submit" class="btn btn-default">Найти</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 stats-info stats-last widget-shadow no-content">
            <div class="stats-last-agile">
                <div class="stats-title">
                    <h4 class="title">Найденный товар</h4>
                    <div id="search-container"></div>
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
<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>API </h1>
        <div class="alert alert-info">Из-за недостаточно подробного описания тестового задания, многие вещи были
            додуманы мной(Романом) самостоятельно... Все пробелы в бизнес логике тестового задания так же приходилось восполнять по ходу решения...
            И я не знаток бирж услуг поэтому возможно что то додумал не верно...
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-sm-12">
                <h2>COMMON</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>В целом это должно быть обычное restful API. Делал согласно <a href="https://www.yiiframework.com/doc/guide/2.0/ru/rest-quick-start">документации rest api</a>.
                        Помимо стандартных методов, предоставляемых из коробки Yii2, я дописал еще пару методов и переопределил несколько. </p>
                        <p>BasicAuth для всех методов кроме <b>post: api/user - создание пользователя</b></p>
                        <p>Тестил постманом.</p>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <h2>USER</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        POST: api/user (username, password, email, phone, personal_or_organization) <b>создание пользователя</b>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        GET: api/user <b>список пользователей</b>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h2>ORDER</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        POST: api/order/done   (id) <b>завершить закза</b>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        POST: api/order   (title, descr, reward, deadline) <b>создание заказа</b>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        GET: api/order <b>список заказаов</b>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <h2>OFFER</h2>
                <div class="panel panel-default">
                    <div class="panel-body">
                        POST: api/offer  (order_id) <b>создание заявки</b>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        GET: api/offer <b>все заявки</b>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        GET: api/offer/cancel  (offer_id) <b>отмена заявки</b>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        GET: api/offer/confirm  (offer_id) <b>принятие заявки</b>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

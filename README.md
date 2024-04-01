<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 test</h1>
    <br>
</p>
<h2>Install</h2>
<h4>Installing using Docker</h4>
<pre>
composer install    
docker-compose up -d
docker-compose exec backend yii migrate
open http://localhost:21080
</pre>

<h4>Structure</h4>
<pre>
    /backend/modules/testtasks - src CRUD book, author and etc
    /common/behaviors - behaviors
    /common/components/jobs - jobs (SubscriberSend)
    /console/migrations - migrations (init, report_book)
</pre>
<h4>Ntice</h4>
<p>After creating a book, a job (SubscriberSend) is created to send SMS</p>
<p>User for test: test/12345678</p>



[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)



<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 20:09
 */

$app->get('/api/v1/credit/which-card', ['App\Controllers\v1\CreditController','whichCard']);


/**
 *  在指定时间范围内，找出还款日最长的消费日期和消费卡片
 */
$app->get('/api/v1/credit/which-card-and-date',['App\Controllers\v1\CreditController','whichCardAndDate']);
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 20:12
 */

namespace App\Controllers\v1;

use App\Controllers\BaseController;
use App\Models\Card;
use Illuminate\Database\Eloquent\Collection;


class CreditController extends BaseController
{
    /**
     * 指定日期选择卡片
     * @return string
     */
    public function whichCard(){
        $userId=$this->request->getParam('user_id');
        $consumptionDate=$this->request->getParam('date',date('Y-m-d'));
        $model = new Card();
        /** @var Collection $collection */
        $rows=$model->getByUid($userId)->toArray();
        $arr=Card::addIntervalDay($rows,$consumptionDate);
        $data=Card::sortBy($arr);
        return $this->response->withJson($data);
    }

    public function whichCardAndDate(){
        $userId=$this->request->getParam('user_id');
        $startDate=$this->request->getParam('start_date',date('Y-m-d'));
        $endDate=$this->request->getParam('end_date',date('Y-m-d'));
        $limit=$this->request->getParam('limit',6);//默认获取还款时间最长的前6条数据
        $model = new Card();
        $rows=$model->getByUid($userId)->toArray();
        $startTimestamp=strtotime($startDate);
        $endTimestamp=strtotime($endDate);
        $data=[];
        do{
            $consumptionDate = date('Y-m-d',$startTimestamp);
            $arr=Card::addIntervalDay($rows,$consumptionDate);
            $data = array_merge($data,$arr);

            $startTimestamp=strtotime('+1 day',$startTimestamp);
        }while($startTimestamp<=$endTimestamp);
        $data = Card::sortBy($data);
        count($data)>$limit and $data=array_slice($data,0,$limit);//截取指定长度数组
        return $this->response->withJson($data);
    }
}
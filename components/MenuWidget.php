<?php

namespace app\components;

use yii\base\Widget;
use app\models\Region;
use yii\helpers\Html;
use Yii;

class MenuWidget extends Widget
{
   public $html = '';

   public function init()
   {
           $result = Region::find()->with('area')->orderBy('region_id ASC')->all();
           if(empty($result)) throw  new \yii\web\HttpException(404,'Інформація відсутня');

           $this->html .= "<ul class=\"list-unstyled filter-area ac\">";
           foreach ($result as $val)
           {
               $area = $val->area;

               if(!empty($area))
               {

                   $this->html .= "<li>" . Html::a($val->name_region, '/catalog/' . $val->region_id . '/' .
                           Yii::$app->translit->translit(trim($val->name_region)),
                           ['onclick' => 'window.location.href = "/catalog/' . $val->region_id . '/' . Yii::$app->translit->translit(trim($val->name_region)) . '"']);

                   $this->html .= "<ul class=\"children-items\">";
                   foreach ($area as $v) {
                       $this->html .= "<li>" . Html::a($v->name, '/catalog/' . $val->region_id . '/' . $v->area_id . '/' .
                               Yii::$app->translit->translit(trim($v->name)), [
                               'onclick' => 'window.location.href = "/catalog/' . $val->region_id . '/' . $v->area_id . '/' .
                                   Yii::$app->translit->translit(trim($v->name)) . '"']) . "</li>";
                   }
                   $this->html .= "</ul>";
                   $this->html .= "</li>";

               } else {
                   $this->html .= "<li>".$val->name_region."</li>";
               }
           }
           $this->html .= "</ul>";
   }

    public function run()
    {
        return $this->html;
    }

}
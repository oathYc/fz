<?php


namespace app\modules\content\models;


use yii\db\ActiveRecord;

class Business extends ActiveRecord
{
    public static  function tableName(){
        return '{{%business}}';
    }

}
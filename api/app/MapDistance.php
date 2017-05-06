<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class MapDistance extends Model
{
    //datbase table
    protected $table = 'distance';

    //fillable information
    protected $fillable = ['token', 'start_id', 'end_ids'];

    public function __construct(){

    }

    public function getDistance($token = null){
      if(empty($token)){
        return array('status' => 'failure', 'error' => 'no data found');
      }

      $distance = DB::table($this->table)
              ->select('id', 'token', 'start_id', 'end_ids')
              ->where('token', $token)
              ->first();

      if(empty($distance)){
          return array('status' => 'failure', 'error' => 'no data found');
      }

      return array('status' => 'success', 'data' => $distance);
    }

    public function insertDistance($distanceInfo = null){
      if(empty($distanceInfo)){
        return array('status' => 'failure', 'error' => 'invalid data');
      }
      $distanceInfo = $this->getFillableInfo($distanceInfo);

      $distanceInfo['token'] =  md5(uniqid(rand(), true));
      $distanceInfo['updated_at'] =  date('Y-m-d G:i:s');
      $distanceInfo['created_at'] =  date('Y-m-d G:i:s');

      $id = DB::table($this->table)
            ->insertGetId($distanceInfo);
      if(!empty($id)){
        return array('status' => 'success', 'data' => $distanceInfo['token']);
      }
    }

    private function getFillableInfo($arr = null){
      if(!empty($arr)){
        $finalArr = array();
        foreach ($this->fillable as $value) {
          if( !empty($arr[$value]) ){
            $finalArr[$value] = $arr[$value];
          }
        }
      }
      return $finalArr;
    }
}

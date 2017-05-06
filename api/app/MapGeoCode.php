<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class MapGeoCode extends Model
{
    //datbase table
    protected $table = 'geocode';

    //fillable information
    protected $fillable = ['lat', 'lng', 'address', 'placeid'];

    public function __construct(){

    }

    public function getGeoAddress($id = null){
      if(empty($id)){
        return array('status' => 'failure', 'error' => 'no data found');
      }

      $geoAddress = DB::table($this->table)
                  ->select('lat', 'lng', 'address', 'placeid')
                  ->where('id', $id)
                  ->first();

      if(empty($geoAddress)){
          return array('status' => 'failure', 'error' => 'no data found');
      }

      return array('status' => 'success', 'data' => $geoAddress);
    }

    public function getGeoPlaceId($placeID = null){
      if(empty($placeID)){
        return array('status' => 'failure', 'error' => 'no data found');
      }

      $geoPlaceID= DB::table($this->table)
                  ->select('id', 'lat', 'lng', 'address')
                  ->where('placeid', $placeID)
                  ->first();

      if(empty($geoPlaceID)){
          return array('status' => 'failure', 'error' => 'no data found');
      }

      return array('status' => 'success', 'data' => $geoPlaceID);
    }

    public function insertGeoCode($geoInfo=null){
      if(empty($geoInfo)){
        return array('status' => 'failure', 'error' => 'invalid data');
      }

      $geoInfo = $this->getFillableInfo($geoInfo);
      $geoInfo['updated_at'] =  date('Y-m-d G:i:s');
      $geoInfo['created_at'] =  date('Y-m-d G:i:s');

      $geoPlaceID = $this->getGeoPlaceId($geoInfo['placeid']);
      if(!empty($geoPlaceID['data'])){
        return array('status' => 'success', 'data' => $geoPlaceID['data']->id);
      }else{
        $id = DB::table($this->table)
              ->insertGetId($geoInfo);
        if(!empty($id)){
          return array('status' => 'success', 'data' => $id);
        }
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

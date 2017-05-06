<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\MapDistance;
use App\MapGeoCode;

class RouteController extends Controller
{
    private $request;

    public function __construct(Request $request){
      $this->request = $request;
    }

    public function get($token=null)
    {
      $mapDistance = new MapDistance();
      $mapDistanceData = $mapDistance->getDistance($token);

      if(empty($mapDistanceData['data'])){
        return response()->json(array('status' => 'failure', 'error' => 'no data found'));
      }

      $mapGeoCode = new MapGeoCode();
      $startAddress = $mapGeoCode->getGeoAddress($mapDistanceData['data']->start_id);

      if(empty($startAddress['data']->address)){
        return response()->json(array('status' => 'failure', 'error' => 'no start address found'));
      }

      $distancePath[] = [$startAddress['data']->lat, $startAddress['data']->lng];
      $distanceTotal = 0;
      $distanceTime = 0;

      // $distanceInfo = [];
      $endIDs = explode(",", $mapDistanceData['data']->end_ids);
      foreach ($endIDs as $key => $value) {
        $endAddress = $mapGeoCode->getGeoAddress($value);
        if(!empty($endAddress['data']->address)){
          $distancePath[] = [$endAddress['data']->lat, $endAddress['data']->lng];
          // $distanceInfo[] = $this->getDistanceMatrix($startAddress['data']->address, $endAddress['data']->address);
          $distanceInfo = $this->getDistanceMatrix($startAddress['data']->address, $endAddress['data']->address);
          if(empty($distanceInfo)){
            return response()->json(array('status' => 'failure', 'error' => 'no end address found'));
          }
          $distanceTotal = $distanceTotal + (int) $distanceInfo->rows[0]->elements[0]->distance->value;
          $distanceTime = $distanceTime + (int) $distanceInfo->rows[0]->elements[0]->duration->value;
        }
      }
      // dd($distanceTime);
      return response()->json(array('status' => 'success', 'path' => $distancePath, 'total_distance' => $distanceTotal, 'total_time' => $distanceTime));
    }

    public function insert()
    {
        $postData = json_decode($this->request->all()['param']);

        if(empty($postData)){
          return response()->json(array('status' => 'failure', 'error' => 'invalid parameter found'));
        }

        $mapGeoCode = new MapGeoCode();
        $mapDistance = new MapDistance();

        $geoEndID = ''; $geoStartID = '';

        foreach ($postData as $key => $value) {
          if(is_numeric($value[0]) && is_numeric($value[1])){
            $geoInfo = $this->getGeoCode($value[0], $value[1]);
            if(empty($geoInfo)){
              return response()->json(array('status' => 'failure', 'error' => 'no end geo location found on data'. $key + 1));
            }

            $geoInfo = array(
              'address' => $geoInfo->results[0]->formatted_address,
              'placeid' => $geoInfo->results[0]->place_id,
              'lat'     => $value[0],
              'lng'     => $value[1]
            );

            $geoId = $mapGeoCode->insertGeoCode($geoInfo);

            if(!empty($geoId['data'])){
              if($key == 0){
                $geoStartID = $geoId['data'];
              }else{
                $geoEndID = $geoEndID.$geoId['data'].',';
              }
            }
          }
        }
        if(empty($geoStartID) || empty($geoEndID)){
          return response()->json(array('status' => 'failure', 'error' => 'invalid data'));
        }

        $distanceInfo = array(
          'start_id'  => $geoStartID,
          'end_ids'   => trim($geoEndID, " ,")
        );
        $distanceToken = $mapDistance->insertDistance($distanceInfo);

        return response()->json(array('status' => 'success', 'token' => $distanceToken['data']));
    }

    private function getDistanceMatrix($org=null, $des=null){
      $response = null;
      if(!empty($org) || !empty($des)){
        $response = \GoogleMaps::load('distancematrix')
                    ->setParam([
                      "origins"            => $org,
                      "destinations"       => $des
                    ])
                    ->get();
      }
      return json_decode($response);
    }

    private function getGeoCode($lat=null, $lng=null){
      $response = null;
      if(!empty($lat) || !empty($lng)){
        $response = \GoogleMaps::load('geocoding')
                    ->setParam([
                      "latlng" => $lat.','.$lng
                    ])
                    ->get();
      }
      return json_decode($response);
    }
}

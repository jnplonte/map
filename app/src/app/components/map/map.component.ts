import { Component, Inject} from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';

import * as _ from 'underscore';

declare var google: any;

@Component({
  selector: 'map',
  templateUrl: 'map.component.html',
  styleUrls: ['map.component.css']
})

export class MapComponent {
  mapapiService;
  helperService;

  token;
  totalDistance;
  timeDistance;

  constructor(private route: ActivatedRoute, private router: Router, @Inject('mapapiService') mapapiService, @Inject('helperService') helperService){
    this.mapapiService = mapapiService;
    this.helperService = helperService;
  }

  ngOnInit() {
      this.token = this.route.snapshot.params['token'] || null;
      this.getDirection();
  }

  getDirection() {
    if(!this.token){
      this.initDefault();
    }

    this.mapapiService.getDirection(this.token).subscribe(
      response => {
         if(response.status == 'success'){
           this.totalDistance = this.helperService.meterToMiles(response.total_distance);
           this.timeDistance = this.helperService.secondsToHms(response.total_time);

           this.initMap(response.path);
         }else{
           this.initDefault();
         }
      }
    );
  }

  initDefault(){
    let pointA = new google.maps.LatLng(22.396428, 114.109497);
    let map = new google.maps.Map(document.getElementById('map'), {
          center: pointA,
          zoom: 10
        });

    new google.maps.Marker({
      position: pointA,
      title: "point A",
      label: "A",
      map: map
    });
  }

  initMap(path) {
    let wayPoints = [], pathCount = (path.length - 1), pointA, pointB;

    _.each(path, function(row, i) {
        if(i == 0){
          // first array start
          pointA = new google.maps.LatLng(row[0], row[1]);
        }else if(i == pathCount){
          //last array destination
          pointB = new google.maps.LatLng(row[0], row[1])
        }else{
          //waypoints
          wayPoints.push({
                          location: new google.maps.LatLng(row[0], row[1]),
                          stopover: true
                        });
        }
    });

    let myOptions = {
        zoom: 16,
        center: pointA
      },
      map = new google.maps.Map(document.getElementById('map'), myOptions),
      // Instantiate a directions service.
      directionsService = new google.maps.DirectionsService,
      directionsDisplay = new google.maps.DirectionsRenderer({
        map: map
      });

    this.calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB, wayPoints);
  }

  calculateAndDisplayRoute(directionsService, directionsDisplay, point1, point2, wayPoints) {
    directionsService.route({
      origin: point1,
      waypoints: wayPoints,
      destination: point2,
      travelMode: google.maps.TravelMode.DRIVING
    }, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      } else {
        console.warn('Directions request failed due to ' + status);
      }
    });
  }
}

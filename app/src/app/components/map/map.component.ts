import { Component, Inject} from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';

declare var google: any;

@Component({
  selector: 'map',
  templateUrl: 'map.component.html',
  styleUrls: ['map.component.css']
})

export class MapComponent {
  mapapiService;

  token;
  totalDistance;
  timeDistance;

  constructor(private route: ActivatedRoute, private router: Router, @Inject('mapapiService') mapapiService){
    this.mapapiService = mapapiService;
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
           this.totalDistance = response.total_distance;
           this.timeDistance = response.total_time;

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
    let pointA = new google.maps.LatLng(51.7519, -1.2578),
        pointB = new google.maps.LatLng(52.8429, -0.2578),
        pointC = new google.maps.LatLng(52.8429, -0.1350),
        wayPoints = [];

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

    wayPoints.push({
                    location: pointC,
                    stopover: true
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

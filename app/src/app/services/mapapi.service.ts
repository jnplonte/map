import { Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/map';

@Injectable()
export class MapApiService {
  // private MapApiUrl = 'http://test_map.local/route/';  // hardcoded point to my local api env
  private MapApiUrl = 'http://localhost:8080/route/';

  constructor (private http: Http){

  }

  getDirection(token){
      return this.http.get(this.MapApiUrl + token).map(this.extractData).catch(this.handleError);
  }

  private extractData(res: Response) {
    res = res || null;

    if(res){
      let body = res.json();
      return body || {};
    }else{
      return {};
    }
  }

  private handleError(error: Response | any) {
    error = error || null;
    if(error){
      let errMsg: string;
      if (error instanceof Response) {
        const body = error.json() || '';
        const err = body.error || JSON.stringify(body);
        errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
      } else {
        errMsg = error.message ? error.message : error.toString();
      }
      console.error(errMsg);
      return Observable.throw(errMsg);
    }else{
      console.error('Fatal Error');
      return Observable.throw('Fatal Error');
    }
  }
}

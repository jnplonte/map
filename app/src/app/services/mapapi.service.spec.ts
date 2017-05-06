import { inject, TestBed } from '@angular/core/testing';
import {By} from "@angular/platform-browser";

import { HttpModule, JsonpModule } from '@angular/http';

import { MapApiService } from './../services/mapapi.service';

describe('Service: MapApiService', function () {
  let service;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpModule, JsonpModule],
      providers: [ MapApiService ]
    });
  });

  beforeEach(inject([MapApiService], s => {
    service = s;
  }));

  it('should check if the api service is define', () => {
    expect(service.getDirection()).toBeDefined();
    expect(service.extractData()).toBeDefined();
    expect(service.handleError()).toBeDefined();
  });
});

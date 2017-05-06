import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { HttpModule, JsonpModule } from '@angular/http';

import { By }           from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { Router, ActivatedRoute, Params } from '@angular/router';
import { Observable } from 'rxjs';

import { MapComponent } from './map.component';
import { MapApiService } from './../../services/mapapi.service';

describe('Component: MapComponent', function () {
  let el: HTMLElement;
  let comp: MapComponent;
  let fixture: ComponentFixture<MapComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MapComponent ],
      imports: [ RouterTestingModule, HttpModule, JsonpModule ],
      providers:[
                  {provide: 'mapapiService', useClass: MapApiService},
                  {provide: ActivatedRoute, useValue: { params: Observable.of({ token: '58a5d22e877831ccd4c9053ff0e87956' })}}
                ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MapComponent);
    comp = fixture.componentInstance;
  });

  it('should create component', () => {
    expect(comp).toBeDefined();
  });
});

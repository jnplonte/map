import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { RouterModule, Routes } from '@angular/router';
import { HttpModule, JsonpModule } from '@angular/http';

import { AppComponent }  from './app.component';
import { MapComponent } from './components/map/map.component';
import { PageNotFoundComponent } from './components/pagenotfound/pagenotfound.component';

import { MapApiService } from './services/mapapi.service';
import { HelperService } from './services/helper.service';

const appRoutes: Routes = [
  { path: '',
    pathMatch: 'full',
    redirectTo: '/route'
  },
  { path: 'route',
    component: MapComponent
  },
  { path: 'route/:token',
    component: MapComponent
  },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports:      [ BrowserModule,
                  HttpModule,
                  JsonpModule,
                  RouterModule.forRoot(appRoutes) ],
  declarations: [ AppComponent, MapComponent, PageNotFoundComponent ],
  providers:    [ {provide: 'mapapiService', useClass: MapApiService},
                  {provide: 'helperService', useClass: HelperService} ],
  bootstrap:    [ AppComponent ]
})

export class AppModule { }

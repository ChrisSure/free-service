import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { HttpClientModule } from "@angular/common/http";
import { SiteModule } from "./site/site.module";
import { AppRoutingModule } from "./app-routing.module";
import { AuthService } from "./services/auth/auth.service";
import { TokenService } from "./services/auth/token.service";
import { UserInfoService } from "./services/auth/user-info.service";

@NgModule({
  declarations: [
      AppComponent
  ],
  imports: [
      BrowserModule,
      HttpClientModule,
      SiteModule,
      AppRoutingModule
  ],
  providers: [
      AuthService,
      TokenService,
      UserInfoService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { HttpClientModule } from "@angular/common/http";
import { SiteModule } from "./site/site.module";
import { AppRoutingModule } from "./app-routing.module";
import { AuthService as AuthUserService } from "./services/auth/auth.service";
import { TokenService } from "./services/auth/token.service";
import { UserInfoService } from "./services/auth/user-info.service";
import { ComparePasswordService } from "./services/auth/compare-password.service";
import { AuthServiceConfig } from 'angular-6-social-login';
import { GoogleLoginProvider, FacebookLoginProvider, AuthService } from 'angular-6-social-login';
import { UrlHelperService } from "./services/helpers/url-helper.service";
import { MessageService } from "./services/helpers/message.service";
import { ProfileService } from "./services/profile/profile.service";


export function socialConfigs() {
    const config = new AuthServiceConfig(
        [
            {
                id: FacebookLoginProvider.PROVIDER_ID,
                provider: new FacebookLoginProvider('383462765893723')
            },
            {
                id: GoogleLoginProvider.PROVIDER_ID,
                provider: new GoogleLoginProvider('773947189913-lnnd2cd1una5upf96jugghv474bp9pbc.apps.googleusercontent.com')
            }
        ]
    );
    return config;
}


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
      AuthUserService,
      TokenService,
      UserInfoService,
      ComparePasswordService,
      UrlHelperService,
      MessageService,
      ProfileService,
      AuthService,
      {
          provide: AuthServiceConfig,
          useFactory: socialConfigs
      }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

import { CommonModule } from "@angular/common";
import { NgModule } from '@angular/core';
import { RouterModule } from "@angular/router";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { HomeComponent } from "./home/home.component";
import { HeaderComponent } from "./blocks/header/header.component";
import { ConfirmRegisterComponent } from "./auth/confirm-register/confirm-register.component";
import { ForgetPasswordComponent } from "./auth/forget-password/forget-password.component";
import { NewPasswordComponent } from "./auth/new-password/new-password.component";
import { FooterComponent } from "./blocks/footer/footer.component";
import { LeftMainComponent } from "./blocks/left-main/left-main.component";

@NgModule({
    declarations: [
        HomeComponent,
        HeaderComponent,
        LeftMainComponent,
        FooterComponent,
        ConfirmRegisterComponent,
        ForgetPasswordComponent,
        NewPasswordComponent
    ],
    imports: [
        CommonModule,
        RouterModule,
        FormsModule,
        ReactiveFormsModule
    ],
    exports:
    [
        HeaderComponent,
        LeftMainComponent,
        FooterComponent
    ],
    providers: [],
    bootstrap: []
})
export class SiteModule { }
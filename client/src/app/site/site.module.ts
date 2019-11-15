import { CommonModule } from "@angular/common";
import { NgModule } from '@angular/core';
import { RouterModule } from "@angular/router";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { HomeComponent } from "./home/home.component";
import { HeaderComponent } from "./blocks/header/header.component";
import { ConfirmRegisterComponent } from "./auth/confirm-register/confirm-register.component";
import { ForgetPasswordComponent } from "./auth/forget-password/forget-password.component";
import { NewPasswordComponent } from "./auth/new-password/new-password.component";

@NgModule({
    declarations: [
        HomeComponent,
        HeaderComponent,
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
        HeaderComponent
    ],
    providers: [],
    bootstrap: []
})
export class SiteModule { }
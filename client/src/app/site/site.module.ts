import { CommonModule } from "@angular/common";
import { NgModule } from '@angular/core';
import { RouterModule } from "@angular/router";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { HomeComponent } from "./home/home.component";
import { HeaderComponent } from "./blocks/header/header.component";
import { ConfirmRegisterComponent } from "./auth/confirm-register/confirm-register.component";
import { ForgetPasswordComponent } from "./auth/forget-password/forget-password.component";
import { NewPasswordComponent } from "./auth/new-password/new-password.component";
import { LeftMainComponent } from "./blocks/left-main/left-main.component";
import { AboutComponent } from "./pages/about.component";
import { ContactsComponent } from "./pages/contacts.component";

@NgModule({
    declarations: [
        HomeComponent,
        HeaderComponent,
        LeftMainComponent,
        ConfirmRegisterComponent,
        ForgetPasswordComponent,
        NewPasswordComponent,
        AboutComponent,
        ContactsComponent
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
        LeftMainComponent
    ],
    providers: [],
    bootstrap: []
})
export class SiteModule { }

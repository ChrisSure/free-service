import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from "./site/home/home.component";
import { CabinetModule } from "./cabinet/cabinet.module";
import { CabinetGuard } from "./cabinet/cabinet.guard";
import { ConfirmRegisterComponent } from "./site/auth/confirm-register/confirm-register.component";
import { ForgetPasswordComponent } from "./site/auth/forget-password/forget-password.component";
import { NewPasswordComponent } from "./site/auth/new-password/new-password.component";
import { AboutComponent } from "./site/pages/about.component";
import { ContactsComponent } from "./site/pages/contacts.component";


const routes: Routes = [
    { path: '', component: HomeComponent },
    { path: 'confirm-register', component: ConfirmRegisterComponent},
    { path: 'forget-password', component: ForgetPasswordComponent},
    { path: 'new-password', component: NewPasswordComponent},
    { path: 'about', component: AboutComponent},
    { path: 'contacts', component: ContactsComponent},
    {
        path: 'cabinet',
        loadChildren: () => CabinetModule,
        canLoad: [CabinetGuard]
    },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule],
    providers: [CabinetGuard],
})
export class AppRoutingModule { }

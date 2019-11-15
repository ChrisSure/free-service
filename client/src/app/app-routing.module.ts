import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from "./site/home/home.component";
import { CabinetModule } from "./cabinet/cabinet.module";
import { CabinetGuard } from "./cabinet/cabinet.guard";
import { ConfirmRegisterComponent } from "./site/auth/confirm-register/confirm-register.component";


const routes: Routes = [
    { path: '', component: HomeComponent },
    { path: 'confirm-register', component: ConfirmRegisterComponent},
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
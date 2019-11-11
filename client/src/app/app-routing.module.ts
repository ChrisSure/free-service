import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from "./site/home/home.component";
import { CabinetModule } from "./cabinet/cabinet.module";
import { CabinetGuard } from "./cabinet/cabinet.guard";


const routes: Routes = [
    { path: '', component: HomeComponent },
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
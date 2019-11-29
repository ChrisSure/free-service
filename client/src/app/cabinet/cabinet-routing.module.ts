import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { CabinetGuard } from "./cabinet.guard";
import { CabinetPanelComponent } from "./cabinet-panel/cabinet-panel.component";
import { CabinetHomeComponent } from "./cabinet-home/cabinet-home.component";
import { CabinetProfileCreateComponent } from "./profile/create/cabinet-profile-create.component";
import { CabinetProfileUpdateComponent } from "./profile/update/cabinet-profile-update.component";



const routesCabinet: Routes = [
    {
        path: '', component: CabinetPanelComponent, canActivate: [CabinetGuard], children: [
            { path: '', component: CabinetHomeComponent  },
            { path: 'profile/create', component: CabinetProfileCreateComponent},
            { path: 'profile/update', component: CabinetProfileUpdateComponent},
        ]
    }
];

@NgModule({
    imports: [
        CommonModule,
        RouterModule.forChild(routesCabinet)
    ],
    exports: [RouterModule],
    declarations: []
})
export class CabinetRoutingModule { }
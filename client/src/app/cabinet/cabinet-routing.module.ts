import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes } from '@angular/router';
import { CabinetGuard } from "./cabinet.guard";
import { CabinetPanelComponent } from "./cabinet-panel/cabinet-panel.component";
import { CabinetHomeComponent } from "./cabinet-home/cabinet-home.component";



const routesCabinet: Routes = [
    {
        path: '', component: CabinetPanelComponent, canActivate: [CabinetGuard], children: [
            { path: '', component: CabinetHomeComponent  },
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
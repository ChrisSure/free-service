import { CommonModule } from "@angular/common";
import { NgModule } from '@angular/core';
import { RouterModule } from "@angular/router";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { CabinetRoutingModule } from "./cabinet-routing.module";
import { CabinetPanelComponent } from "./cabinet-panel/cabinet-panel.component";
import { CabinetHomeComponent } from "./cabinet-home/cabinet-home.component";
import { CabinetProfileCreateComponent } from "./profile/create/cabinet-profile-create.component";
import { CabinetProfileUpdateComponent } from "./profile/update/cabinet-profile-update.component";



@NgModule({
    declarations: [
        CabinetPanelComponent,
        CabinetHomeComponent,
        CabinetProfileCreateComponent,
        CabinetProfileUpdateComponent
    ],
    imports: [
        CommonModule,
        RouterModule,
        FormsModule,
        ReactiveFormsModule,
        CabinetRoutingModule
    ],
    providers: [],
    bootstrap: []
})
export class CabinetModule { }
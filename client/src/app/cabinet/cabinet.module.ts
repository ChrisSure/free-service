import { CommonModule } from "@angular/common";
import { NgModule } from '@angular/core';
import { RouterModule } from "@angular/router";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { CabinetRoutingModule } from "./cabinet-routing.module";
import { CabinetPanelComponent } from "./cabinet-panel/cabinet-panel.component";
import { CabinetHomeComponent } from "./cabinet-home/cabinet-home.component";



@NgModule({
    declarations: [
        CabinetPanelComponent,
        CabinetHomeComponent
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
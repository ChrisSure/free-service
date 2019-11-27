import { Component, OnInit } from '@angular/core';
import { ProfileService } from "../../services/profile/profile.service";
import { MessageService } from "../../services/helpers/message.service";

@Component({
    selector: 'app-cabinet-panel',
    templateUrl: './cabinet-panel.component.html'
})
export class CabinetPanelComponent implements OnInit {
    public isFillProfile: boolean = true;

    constructor(private profileService: ProfileService, public messageService: MessageService) {}

    ngOnInit() {
        this.profileService.isFillProfile()
            .subscribe((res) => {
                this.isFillProfile = res;
                },
                err => {
                    this.messageService.setErrorMessage(err);
                });
    }
}
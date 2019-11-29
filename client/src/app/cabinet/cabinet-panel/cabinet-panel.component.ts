import { Component, OnInit } from '@angular/core';
import { ProfileService } from "../../services/profile/profile.service";
import { MessageService } from "../../services/helpers/message.service";

@Component({
    selector: 'app-cabinet-panel',
    templateUrl: './cabinet-panel.component.html'
})
export class CabinetPanelComponent implements OnInit {

    public isFillProfile: boolean;

    constructor(private profileService: ProfileService, public messageService: MessageService) {}

    ngOnInit() {
        this.profileService.CreateProfile.subscribe((res) => {
           this.messageService.setSuccessMessage(res);
           this.isFillProfile = true;
        });
        this.profileService.isFillProfile()
            .subscribe((res) => {
                this.isFillProfile = res;
                if (!res) {
                    this.messageService.setWarningMessage("You have no fill profile.");
                }
                },
                err => {
                    this.messageService.setErrorMessage(err);
                });
    }
}
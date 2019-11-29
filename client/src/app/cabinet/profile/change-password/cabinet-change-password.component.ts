import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { ProfileService } from "../../../services/profile/profile.service";
import { Router } from "@angular/router";
import { MessageService } from "../../../services/helpers/message.service";
import { ComparePasswordService } from "../../../services/auth/compare-password.service";

@Component({
    selector: 'app-cabinet-change-password',
    templateUrl: './cabinet-change-password.component.html'
})
export class CabinetChangePasswordComponent {
    changePasswordForm: FormGroup;
    email: string;

    constructor(
        private profileService: ProfileService,
        public messageService: MessageService,
        private router: Router,
        private comparePasswordService: ComparePasswordService,
    ) {
        this.changePasswordForm = new FormGroup({
            'password': new FormControl('', Validators.required),
            'confirmPassword': new FormControl('', Validators.required),
        }, { validators: comparePasswordService.comparePassword });
    }

    public changePassword()
    {
        this.profileService.changePassword(this.changePasswordForm.value.password).subscribe((res) => {
            this.profileService.CreateProfile.emit(res);
            this.router.navigate(['/cabinet']);
        },err => {
            this.messageService.setErrorMessage(err);
        });
    }
}
import { Component } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { ActivatedRoute } from "@angular/router";
import { FormControl, FormGroup, Validators } from "@angular/forms";

@Component({
    selector: 'app-forget-password',
    templateUrl: './forget-password.component.html'
})
export class ForgetPasswordComponent {
    public apiMessage: string = "";
    public apiColor: string = "";
    public forgetPasswordForm: FormGroup;

    constructor(private authService: AuthService, private actRoute: ActivatedRoute) {
        this.forgetPasswordForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email])
        });
    }

    public forgetPassword()
    {
        this.authService.forgetPassword(this.forgetPasswordForm.value.email)
            .subscribe((res) => {
                this.apiMessage = res.toString();
                this.apiColor = "success";
            },
                err => {
                    if (err.error) {
                        this.apiMessage = err.error.error;
                        this.apiColor = "danger";
                    }
                });
    }

}
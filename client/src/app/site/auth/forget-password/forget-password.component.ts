import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { ActivatedRoute } from "@angular/router";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { MessageService } from "../../../services/helpers/message.service";
import { UserInfoService } from "../../../services/auth/user-info.service";

@Component({
    selector: 'app-forget-password',
    templateUrl: './forget-password.component.html'
})
export class ForgetPasswordComponent implements OnInit {
    /**
     * @type {FormGroup}
     */
    public forgetPasswordForm: FormGroup;

    /**
     * @type {boolean}
     */
    public isAuth: boolean = false;

    /**
     * @param {AuthService} authService
     * @param {ActivatedRoute} actRoute
     * @param {MessageService} messageService
     */
    constructor(
        private authService: AuthService,
        private actRoute: ActivatedRoute,
        public messageService: MessageService,
        private userService: UserInfoService
    ) {
        this.forgetPasswordForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email])
        });
    }

    ngOnInit() {
        this.isAuth = (this.userService.isUser) ? true : false;
    }

    /**
     * Forget password
     * @returns void
     */
    public forgetPassword(): void
    {
        this.authService.forgetPassword(this.forgetPasswordForm.value.email)
            .subscribe((res) => {
                        this.messageService.setSuccessMessage(res);
                    }, err => {
                        this.messageService.setErrorMessage(err);
                    }
                );
    }

}
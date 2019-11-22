import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { ActivatedRoute } from "@angular/router";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { ComparePasswordService } from "../../../services/auth/compare-password.service";
import { MessageService } from "../../../services/helpers/message.service";
import { UserInfoService } from "../../../services/auth/user-info.service";


@Component({
    selector: 'app-new-password',
    templateUrl: './new-password.component.html'
})
export class NewPasswordComponent implements OnInit {
    /**
     * @type {boolean}
     */
    public isCorrectData: boolean = true;

    /**
     * @type {FormGroup}
     */
    public newPasswordForm: FormGroup;

    /**
     * @type {number}
     */
    public id: number;

    /**
     * @type {boolean}
     */
    public isAuth: boolean = false;

    /**
     * @param {AuthService} authService
     * @param {ComparePasswordService} comparePasswordService
     * @param {ActivatedRoute} actRoute
     * @param {MessageService} messageService
     */
    constructor(
        private authService: AuthService,
        comparePasswordService: ComparePasswordService,
        private actRoute: ActivatedRoute,
        public messageService: MessageService,
        private userService: UserInfoService
    ) {
        this.newPasswordForm = new FormGroup({
            'password': new FormControl('', Validators.required),
            'confirmPassword': new FormControl('', Validators.required),
        }, { validators: comparePasswordService.comparePassword });
    }

    ngOnInit() {
        this.isAuth = (this.userService.isUser) ? true : false;
        this.id = +this.actRoute.snapshot.queryParams['id'];
        let token = this.actRoute.snapshot.queryParams['token'];
        this.authService.checkToken(this.id, token)
            .subscribe((res) => {},
                    err => {
                            this.isCorrectData = false;
                            this.messageService.setErrorMessage(err);
                        }
                );
    }

    /**
     * Set new password
     * @returns void
     */
    public newPassword(): void
    {
        this.authService.newPassword(this.id, this.newPasswordForm.value.password)
            .subscribe((res) => {
                    this.messageService.setSuccessMessage(res);
                },
                err => {
                    this.messageService.setErrorMessage(err);
                });
    }

}
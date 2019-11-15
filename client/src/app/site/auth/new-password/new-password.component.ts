import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { ActivatedRoute } from "@angular/router";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { ComparePasswordService } from "../../../services/auth/compare-password.service";


@Component({
    selector: 'app-new-password',
    templateUrl: './new-password.component.html'
})
export class NewPasswordComponent implements OnInit {
    public apiMessage: string = "";
    public apiColor: string = "";
    public isCorrectData: boolean = true;
    public newPasswordForm: FormGroup;
    public id: number;

    constructor(private authService: AuthService, comparePasswordService: ComparePasswordService, private actRoute: ActivatedRoute) {
        this.newPasswordForm = new FormGroup({
            'password': new FormControl('', Validators.required),
            'confirmPassword': new FormControl('', Validators.required),
        }, { validators: comparePasswordService.comparePassword });
    }

    ngOnInit() {
        this.id = +this.actRoute.snapshot.queryParams['id'];
        let token = this.actRoute.snapshot.queryParams['token'];
        this.authService.checkToken(this.id, token)
            .subscribe(res => , err => {
                    if (err.error) {
                        this.isCorrectData = false;
                        this.apiMessage = err.error.error;
                        this.apiColor = "danger";
                    }
                });
    }

    public newPassword()
    {
        this.authService.newPassword(this.id, this.newPasswordForm.value.password)
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
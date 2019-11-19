import {Component, OnInit} from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { AuthService } from "../../services/auth/auth.service";
import { Router } from "@angular/router";
import { UserAuth } from "../../models/auth/register";
import { ComparePasswordService } from "../../services/auth/compare-password.service";
import {UserInfoService} from "../../services/auth/user-info.service";

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
    public loginForm: FormGroup;
    public registerForm: FormGroup;
    public apiMessage: string = "";
    public apiColor: string = "";
    public isAuth: boolean = false;

    constructor(private authService: AuthService, private userService: UserInfoService, comparePasswordService: ComparePasswordService, private router: Router) {
        this.loginForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email]),
            'password': new FormControl('', Validators.required),
        });
        this.registerForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email]),
            'password': new FormControl('', Validators.required),
            'confirmPassword': new FormControl('', Validators.required),
        }, { validators: comparePasswordService.comparePassword });
    }

    ngOnInit() {
        this.isAuth = (this.userService.isUser) ? true : false;
    }

    public login() {
        let user = new UserAuth(this.loginForm.value.email, this.loginForm.value.password);
        this.authService.login(user)
            .subscribe(res => this.router.navigate(['/cabinet']),
                err => {
                    if (err.error) {
                        console.log(err);
                        this.apiMessage = err.error.error;
                        this.apiColor = "danger";
                    }
            });
    }

    public register() {
        let user = new UserAuth(this.registerForm.value.email, this.registerForm.value.password);
        this.authService.register(user)
        .subscribe((res) => {
                this.apiMessage = res;
                this.apiColor = "success";
                this.registerForm.reset();
            },err => {
                if (err.error) {
                    this.apiMessage = err.error.error;
                    this.apiColor = "danger";
                }
        });
    }

}
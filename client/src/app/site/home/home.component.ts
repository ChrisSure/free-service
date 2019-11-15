import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { AuthService } from "../../services/auth/auth.service";
import { Router } from "@angular/router";
import { UserAuth } from "../../models/auth/register";

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html'
})
export class HomeComponent {
    public loginForm: FormGroup;
    public registerForm: FormGroup;
    public apiMessage: string = "";
    public apiColor: string = "";

    constructor(private authService: AuthService, private router: Router) {
        this.loginForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email]),
            'password': new FormControl('', Validators.required),
        });
        this.registerForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email]),
            'password': new FormControl('', Validators.required),
            'confirmPassword': new FormControl('', Validators.required),
        }, { validators: this.comparePassword });
    }

    public login() {
        let user = new UserAuth(this.loginForm.value.email, this.loginForm.value.password);
        this.authService.login(user)
            .subscribe(res => this.router.navigate(['/cabinet']),
                err => {
                    if (err.error) {
                        this.apiMessage = err.error.message.message;
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

    private comparePassword(group: FormGroup) {
        const pass = group.value.password;
        const confirm = group.value.confirmPassword;

        return pass === confirm ? null : { notSame: true };
    }

}
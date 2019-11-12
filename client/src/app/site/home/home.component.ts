import { Component } from '@angular/core';
import {FormControl, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../../services/auth/auth.service";
import {Router} from "@angular/router";

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html'
})
export class HomeComponent {
    public loginForm: FormGroup;
    public apiError: string = "";

    constructor(private authService: AuthService, private router: Router) {
        this.loginForm = new FormGroup({
            'email': new FormControl('', [Validators.required, Validators.email]),
            'password': new FormControl('', Validators.required),
        });
    }

    login() {
        this.authService.login(this.loginForm.value.email, this.loginForm.value.password)
            .subscribe(data => this.router.navigate(['/cabinet']),
                err => {
                    if (err.error) {
                        this.apiError = err.error.message;
                    }
            });
    }


}
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { AuthService as AuthUserService } from "../../services/auth/auth.service";
import { Router } from "@angular/router";
import { UserAuth } from "../../models/auth/register";
import { ComparePasswordService } from "../../services/auth/compare-password.service";
import { UserInfoService } from "../../services/auth/user-info.service";
import { GoogleLoginProvider, FacebookLoginProvider, AuthService } from 'angular-6-social-login';
import { SocialUser } from "../../models/auth/social-user";
import { MessageService } from "../../services/helpers/message.service";

@Component({
    selector: 'app-home',
    templateUrl: './home.component.html'
})
export class HomeComponent implements OnInit {
    /**
     * @type {FormGroup}
     */
    public loginForm: FormGroup;

    /**
     * @type {FormGroup}
     */
    public registerForm: FormGroup;

    /**
     * @type {boolean}
     */
    public isAuth: boolean = false;

    /**
     * @param {AuthService} authService
     * @param {UserInfoService} userService
     * @param {ComparePasswordService} comparePasswordService
     * @param {Router} router
     * @param {AuthService} OAuth
     * @param {MessageService} messageService
     */
    constructor(
                private authService: AuthUserService,
                private userService: UserInfoService,
                private comparePasswordService: ComparePasswordService,
                private router: Router,
                private OAuth: AuthService,
                public messageService: MessageService
            )
    {
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
        this.authService.AuthChanged.subscribe((res) => {
            this.isAuth = (res == 'Logged in') ? true : false;
        });
    }


    // Casual auth
    /**
     * Casual login user
     * @returns void
     */
    public login(): void
    {
        let user = new UserAuth(this.loginForm.value.email, this.loginForm.value.password);
        this.authService.login(user)
            .subscribe(res => this.router.navigate(['/cabinet']),
                err => {
                    this.messageService.setErrorMessage(err);
            });
    }
    /**
     * Casual register user
     * @returns void
     */
    public register(): void
    {
        let user = new UserAuth(this.registerForm.value.email, this.registerForm.value.password);
        this.authService.register(user)
        .subscribe((res) => {
                this.messageService.setSuccessMessage(res);
                this.registerForm.reset();
            },err => {
                this.messageService.setErrorMessage(err);
            });
    }
    // Casual auth


    // Social auth
    /**
     * Take social user data
     * @returns void
     */
    public socialSignIn(socialProvider: string): void
    {
        let socialPlatformProvider = (socialProvider === 'facebook') ? FacebookLoginProvider.PROVIDER_ID : GoogleLoginProvider.PROVIDER_ID;
        this.OAuth.signIn(socialPlatformProvider).then(socialUser => {
            this.socialLogin(socialUser);
        });
    }
    /**
     * Take social user login - register
     * @returns void
     */
    private socialLogin(socialusers: SocialUser): void
    {
        this.authService.socialLogin(socialusers)
            .subscribe(res => this.router.navigate(['/cabinet']),
                    err => {
                        this.messageService.setErrorMessage(err);
                    }
            );
    }
    // Social auth
}
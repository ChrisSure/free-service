import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { AuthService as AuthUserService } from "../../services/auth/auth.service";
import { Router } from "@angular/router";
import { UserAuth } from "../../models/auth/register";
import { ComparePasswordService } from "../../services/auth/compare-password.service";
import { UserInfoService } from "../../services/auth/user-info.service";
import { GoogleLoginProvider, FacebookLoginProvider, AuthService } from 'angular-6-social-login';
import { SocialUser } from "../../models/auth/social-user";

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
    public socialUser: SocialUser  = new SocialUser();


    constructor(private authService: AuthUserService,
                private userService: UserInfoService,
                private comparePasswordService: ComparePasswordService,
                private router: Router,
                private OAuth: AuthService
    ) {
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


    // Casual auth
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
    // Casual auth


    // Social auth
    public socialSignIn(socialProvider: string) {
        let socialPlatformProvider = (socialProvider === 'facebook') ? FacebookLoginProvider.PROVIDER_ID : GoogleLoginProvider.PROVIDER_ID;

        this.OAuth.signIn(socialPlatformProvider).then(socialUser => {
            this.fillSocialUser(socialUser);
            this.socialLogin(this.socialUser);
        });
    }
    private socialLogin(socialusers: SocialUser) {
        this.authService.socialLogin(socialusers)
            .subscribe(res => this.router.navigate(['/cabinet']),
                    err => {
                        if (err.error) {
                            console.log(err);
                            this.apiMessage = err.error.error;
                            this.apiColor = "danger";
                        }
                    }
            );
    }
    private fillSocialUser(socialUser) {
        this.socialUser.email = socialUser.email;
        this.socialUser.social_id = socialUser.id;
        this.socialUser.provider = socialUser.provider;
        this.socialUser.social_name = socialUser.name;
        this.socialUser.social_image = socialUser.image;
        this.socialUser.social_token = socialUser.token;
    }
    // Social auth
}
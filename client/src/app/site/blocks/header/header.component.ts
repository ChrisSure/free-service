import {Component, OnInit} from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { Router } from "@angular/router";
import { UserInfoService } from "../../../services/auth/user-info.service";

@Component({
    selector: 'app-header',
    templateUrl: './header.component.html'
})
export class HeaderComponent implements OnInit {
    /**
     * @type {boolean}
     */
    public isAuth: boolean = false;

    /**
     * @param {AuthService} authService
     * @param {Router} router
     * @param {UserInfoService} userInfoService
     */
    constructor(private authService: AuthService, private router: Router, private userInfoService: UserInfoService)
    {
    }

    ngOnInit()
    {

    }

    /**
     * Logout user
     * @returns void
     */
    logout(): void
    {
        this.authService.logout();
        this.router.navigate(['/']);
    }
}
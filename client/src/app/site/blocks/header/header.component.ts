import {Component, OnInit} from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { Router } from "@angular/router";
import { UserInfoService } from "../../../services/auth/user-info.service";

@Component({
    selector: 'app-header',
    templateUrl: './header.component.html'
})
export class HeaderComponent implements OnInit {

    public isAuth: boolean = false;

    constructor(private authService: AuthService, private router: Router, private userInfoService: UserInfoService) {
    }

    ngOnInit() {

    }

    logout() {
        this.authService.logout();
        this.router.navigate(['/']);
    }
}
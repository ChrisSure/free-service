import { JwtToken } from '../../models/auth/jwt-token';
import * as jwt_decode from 'jwt-decode';
import { Injectable, EventEmitter, Output } from '@angular/core';
import { UserInfoService } from './user-info.service';

@Injectable()
export class TokenService {

    private accessToken = 'accessToken';

    @Output() AccessTokenExpired: EventEmitter<any> = new EventEmitter();

    constructor(private userInfoService: UserInfoService) {
    }

    public writeToken(jwtToken: JwtToken): void {
        localStorage.setItem(this.accessToken, jwtToken.accessToken);
        this.userInfoService.SaveUserInfo(jwt_decode(jwtToken.accessToken));
    }

    public readJwtToken(): JwtToken {
        const accessToken = localStorage.getItem(this.accessToken);
        let token: JwtToken = null;

        if (accessToken != null) {
            token = {
                accessToken: accessToken
            };
        }
        return token;
    }

    public deleteToken(): void {
        localStorage.removeItem(this.accessToken);
        this.userInfoService.DeleteUserInfo();
    }
}
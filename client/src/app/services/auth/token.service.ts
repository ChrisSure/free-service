import { JwtToken } from '../../models/auth/jwt-token';
import * as jwt_decode from 'jwt-decode';
import { Injectable, EventEmitter, Output } from '@angular/core';
import { UserInfoService } from './user-info.service';

@Injectable()
export class TokenService {

    /**
     * @type {string}
     */
    private accessToken = 'accessToken';

    /**
     * @type {EventEmitter<any>}
     */
    @Output() AccessTokenExpired: EventEmitter<any> = new EventEmitter();

    /**
     * @param {UserInfoService} userInfoService
     */
    constructor(private userInfoService: UserInfoService) {
    }

    /**
     * Write token to localStorage
     * @param response
     * @return void
     */
    public writeToken(response: any): void {
        const token: JwtToken = new JwtToken(
            response['token']
        );
        localStorage.setItem(this.accessToken, token.accessToken);
        this.userInfoService.SaveUserInfo(jwt_decode(token.accessToken));
    }

    /**
     * Return jwt token
     * @return {JwtToken}
     */
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

    /**
     * Delete jwt token
     * @return void
     */
    public deleteToken(): void {
        localStorage.removeItem(this.accessToken);
        this.userInfoService.DeleteUserInfo();
    }
}
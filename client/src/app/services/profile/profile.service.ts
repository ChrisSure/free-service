import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BASE_API_URL } from '../../globals';
import { Observable } from "rxjs/index";
import { map } from "rxjs/operators";
import { TokenService } from "../auth/token.service";
import { UserInfoService } from "../auth/user-info.service";
import {AuthService} from "../auth/auth.service";
import {JwtToken} from "../../models/auth/jwt-token";


@Injectable()
export class ProfileService {
    /**
     * @type {string}
     */
    private baseUrl: string;

    /**
     * @type {number}
     */
    private userId: number;

    /**
     * @type {JwtToken}
     */
    private accessToken: JwtToken;

    /**
     * @type {HttpHeaders}
     */
    private headers = new HttpHeaders({
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json'
    });


    constructor(
        private http: HttpClient,
        private tokenService: TokenService,
        private userInfoService: UserInfoService
    )
    {
        this.userId = +this.userInfoService.userId;
        this.accessToken = this.tokenService.readJwtToken();
        this.headers = this.headers.append('Authorization', 'Bearer ' + this.accessToken.accessToken);

        this.tokenService.ChangeToken.subscribe((res) => {
            this.userId = +this.userInfoService.userId;
            this.accessToken = this.tokenService.readJwtToken();
            this.headers = this.headers.delete('Authorization');
            this.headers = this.headers.append('Authorization', 'Bearer ' + this.accessToken.accessToken);
        });

        this.baseUrl = BASE_API_URL;
    }

    /**
     * Check if fill user profile
     * @return {Observable<any>}
     */
    public isFillProfile(): Observable<any>
    {
        return this.http.get(
            this.baseUrl + '/cabinet/profile/' + this.userId + '/is-filled', {  headers: this.headers}
        ).pipe(map((response: Response) => response));
    }


}
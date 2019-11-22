import { Injectable, Output, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BASE_API_URL } from '../../globals';
import { map } from 'rxjs/operators';
import { TokenService } from './token.service';
import { UserInfoService } from './user-info.service';
import { Observable } from 'rxjs';
import { UserAuth } from "../../models/auth/register";
import { SocialUser } from "../../models/auth/social-user";
import { UrlHelperService } from "../helpers/url-helper.service";


@Injectable()
export class AuthService {
    /**
     * @type {string}
     */
    private baseUrl: string;

    /**
     * @type {HttpHeaders}
     */
    private headers = new HttpHeaders({
        'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'
    });

    /**
     * @type {EventEmitter<any>}
     */
    @Output() AuthChanged: EventEmitter<any> = new EventEmitter();

    /**
     * @param {HttpClient} http
     * @param {TokenService} tokenService
     * @param {UserInfoService} userInfoService
     * @param {UrlHelperService} urlService
     */
    constructor(
            private http: HttpClient,
            private tokenService: TokenService,
            private userInfoService: UserInfoService,
            private urlService: UrlHelperService
            )
    {
        this.baseUrl = BASE_API_URL;
    }

    /**
     * Login user
     * @param {UserAuth} user
     * @returns {Observable<any>}
     */
    public login(user: UserAuth): Observable<any>
    {
        return this.http.post(
            this.baseUrl + '/auth/login-user', this.urlService.getFormUrlEncoded(user), {  headers: this.headers}
        ).pipe(map(data => {
            this.tokenService.writeToken(data);
            this.AuthChanged.emit('Logged in');
        }));
    }

    /**
     * Social login user
     * @param {SocialUser} socialusers
     * @returns {Observable<any>}
     */
    public socialLogin(socialusers: SocialUser): Observable<any>
    {
        return this.http.post(
            this.baseUrl + '/auth/login-social-user', this.urlService.getFormUrlEncoded(socialusers), {  headers: this.headers}
        ).pipe(map(data => {
            this.tokenService.writeToken(data);
            this.AuthChanged.emit('Logged in');
        }));
    }

    /**
     * Register user
     * @param {UserAuth} user
     * @returns {Observable<any>}
     */
    public register(user: UserAuth): Observable<any>
    {
        return this.http.post(
            this.baseUrl + '/auth/register', this.urlService.getFormUrlEncoded(user), { headers: this.headers }
        );
    }

    /**
     * Confirm user registration
     * @param {number} id
     * @param {string} token
     * @returns {Observable<any>}
     */
    public confirmRegister(id: number, token:string): Observable<any>
    {
        return this.http.get(
            this.baseUrl + '/auth/confirm?id=' + id + '&token=' + token, { headers: this.headers }
        ).pipe(map((response: Response) => response));
    }

    /**
     * Forget user password send email
     * @param {string} email
     * @returns {Observable<any>}
     */
    public forgetPassword(email: string): Observable<any>
    {
        return this.http.post(
            this.baseUrl + '/auth/forget', this.urlService.getFormUrlEncoded({email: email}), { headers: this.headers }
        );
    }

    /**
     * Check user token when he set new password
     * @param {number} id
     * @param {string} token
     * @returns {Observable<any>}
     */
    public checkToken(id: number, token:string): Observable<any>
    {
        return this.http.get(
            this.baseUrl + '/auth/check-token?id=' + id + '&token=' + token, { headers: this.headers }
        ).pipe(map((response: Response) => response));
    }

    /**
     * Set new user password
     * @param {number} id
     * @param {string} password
     * @returns {Observable<any>}
     */
    public newPassword(id: number, password:string): Observable<any>
    {
        return this.http.post(
            this.baseUrl + '/auth/new-password/' + id, this.urlService.getFormUrlEncoded({password: password}), { headers: this.headers }
        );
    }

    /**
     * Logout user
     * @returns void
     */
    public logout(): void
    {
        this.tokenService.deleteToken();
        this.AuthChanged.emit('Logged out');
    }

}
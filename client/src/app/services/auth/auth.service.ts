import { Injectable, Output, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BASE_API_URL } from '../../globals';
import { JwtToken } from '../../models/auth/jwt-token';
import { map, finalize } from 'rxjs/operators';
import { TokenService } from './token.service';
import { UserInfoService } from './user-info.service';
import { Observable } from 'rxjs';
import { UserAuth } from "../../models/auth/register";


@Injectable()
export class AuthService {

    private baseUrlLogin: string;
    private baseUrlRegister: string;
    private baseUrlConfirmRegister: string;
    private headers = new HttpHeaders({
        'Content-Type': 'application/x-www-form-urlencoded', 'Accept': 'application/json'
    });
    @Output() AuthChanged: EventEmitter<any> = new EventEmitter();

    constructor(private http: HttpClient, private tokenService: TokenService, private userInfoService: UserInfoService) {
        this.baseUrlLogin = BASE_API_URL + '/auth/login';
        this.baseUrlRegister = BASE_API_URL + '/auth/register';
        this.baseUrlConfirmRegister = BASE_API_URL + '/auth/confirm';
    }
    /**
     * Login user
     * @param {UserAuth} user
     * @returns {Observable<void>}
     */
    public login(user: UserAuth) {
        return this.http.post(
            this.baseUrlLogin, user, { headers: {
                    'Content-Type': 'application/json'
                } }
        ).pipe(map(data => {
            this.writeTokenFromResponse(data);
            this.AuthChanged.emit('Logged in');
        }));
    }

    /**
     * Register user
     * @param {UserAuth} user
     * @returns {Observable<any>}
     */
    public register(user: UserAuth): Observable<any> {
        return this.http.post(
            this.baseUrlRegister, this.getFormUrlEncoded(user), { headers: this.headers }
        );
    }

    /**
     * Confirm user registration
     * @param {number} id
     * @param {string} token
     * @returns {Observable<Response>}
     */
    public confirmRegister(id: number, token:string) {
        return this.http.get(
            this.baseUrlConfirmRegister + '?id=' + id + '&token=' + token, { headers: this.headers }
        ).pipe(map((response: Response) => response));
    }

    /**
     * Logout user
     */
    public logout() {
        this.tokenService.deleteToken();
        this.AuthChanged.emit('Logged out');
    }

    /**
     * Write info in token
     * @param response
     */
    writeTokenFromResponse(response: any) {
        const token: JwtToken = new JwtToken(
            response['token']
        );
        this.tokenService.writeToken(token);
    }

    /**
     * Encode url
     * @param toConvert
     * @returns {string}
     */
    getFormUrlEncoded(toConvert) {
        const formBody = [];
        for (const property in toConvert) {
            const encodedKey = encodeURIComponent(property);
            const encodedValue = encodeURIComponent(toConvert[property]);
            formBody.push(encodedKey + '=' + encodedValue);
        }
        return formBody.join('&');
    }

}
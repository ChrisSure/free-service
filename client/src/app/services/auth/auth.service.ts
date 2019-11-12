import { Injectable, Output, EventEmitter } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BASE_API_URL } from '../../globals';
import { JwtToken } from '../../models/auth/jwt-token';
import { map, finalize } from 'rxjs/operators';
import { TokenService } from './token.service';
import { UserInfoService } from './user-info.service';

@Injectable()
export class AuthService {
    private baseUrlLogin: string;
    private baseUrlLogout: string;
    private baseUrlRefresh: string;
    private headers = new HttpHeaders({
        'Content-Type': 'application/json', 'Accept': 'application/json'
    });
    @Output() AuthChanged: EventEmitter<any> = new EventEmitter();

    constructor(private http: HttpClient, private tokenService: TokenService, private userInfoService: UserInfoService) {
        this.baseUrlLogin = BASE_API_URL + '/auth/login';
        this.baseUrlLogout = BASE_API_URL + '/auth/logout';
        this.baseUrlRefresh = BASE_API_URL + '/auth/refresh';
    }

    public login(email: string, password: string) {
        return this.http.post(
            this.baseUrlLogin,
            JSON.stringify({ password: password, email: email }),
            { headers: this.headers }
        ).pipe(map(data => {
            this.writeTokenFromResponse(data);
            this.AuthChanged.emit('Logged in');
        }));
    }

    public logout() {
        const jwtToken: JwtToken = this.tokenService.readJwtToken();
        this.http.post(
            this.baseUrlLogout,
            JSON.stringify({
                accessToken: jwtToken.accessToken
            }),
            { headers: this.headers }
        ).subscribe(data => { }, err => console.log(err));
        this.tokenService.deleteToken();
        this.AuthChanged.emit('Logged out');
    }

    public refresh() {
        const jwtToken: JwtToken = this.tokenService.readJwtToken();
        return this.http.post(
            this.baseUrlRefresh,
            JSON.stringify({
                accessToken: jwtToken.accessToken
            }),
            { headers: this.headers }
        ).pipe(map(data => {
            this.writeTokenFromResponse(data);
        }));
    }

    writeTokenFromResponse(response: any) {
        const token: JwtToken = new JwtToken(
            response['token']
        );
        this.tokenService.writeToken(token);
    }

}
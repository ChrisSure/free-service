import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable()
export class SocialAuthService {
    public url: string;
    constructor(private http: HttpClient) { }

    public socialLogin(responce) {
        this.url =  'http://localhost:64726/Api/Login/Savesresponse';
        return this.http.post(this.url, responce);
    }
}
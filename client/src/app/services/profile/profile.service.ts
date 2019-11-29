import {EventEmitter, Injectable, Output} from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BASE_API_URL } from '../../globals';
import { Observable } from "rxjs/index";
import { map } from "rxjs/operators";
import { TokenService } from "../auth/token.service";
import { UserInfoService } from "../auth/user-info.service";
import { JwtToken } from "../../models/auth/jwt-token";
import { Profile } from "../../models/profile/profile";
import { UrlHelperService } from "../helpers/url-helper.service";
import {ProfileDto} from "../../dtos/profile/profile-create-dto";


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

    /**
     * @type {EventEmitter<any>}
     */
    @Output() CreateProfile: EventEmitter<any> = new EventEmitter();


    constructor(
        private http: HttpClient,
        private tokenService: TokenService,
        private userInfoService: UserInfoService,
        private urlService: UrlHelperService
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

    /**
     * Get profile by user_id
     * @return {Observable<any>}
     */
    public getProfileByUserId(): Observable<any>
    {
        return this.http.get(
            this.baseUrl + '/cabinet/profile/' + this.userId + '/user', {  headers: this.headers}
        ).pipe(map((response: Response) => response));
    }

    /**
     * Create user profile
     * @param {Profile} profile
     * @return {Observable<any>}
     */
    public createProfile(profile: ProfileDto): Observable<any>
    {
        profile.user = +this.userId;
        return this.http.post(
            this.baseUrl + '/cabinet/profile', this.urlService.getFormUrlEncoded(profile), { headers: this.headers }
        ).pipe(map((response: Response) => response));
    }

    /**
     * Update user profile
     * @param {ProfileDto} profile
     * @param {number} id
     * @return {Observable<any>}
     */
    public updateProfile(profile: ProfileDto, id: number): Observable<any>
    {
        profile.user = +this.userId;
        return this.http.post(
            this.baseUrl + '/cabinet/profile/' + id, this.urlService.getFormUrlEncoded(profile), { headers: this.headers }
        ).pipe(map((response: Response) => response));
    }


}
import { Injectable } from '@angular/core';


@Injectable()
export class UserInfoService {
    uID = 'uID';
    uRole = 'uRole';

    public SaveUserInfo(decodedAT: any) {
        localStorage.setItem(this.uID, decodedAT.id);
        localStorage.setItem(this.uRole, decodedAT.roles[0]);
    }

    public DeleteUserInfo() {
        localStorage.removeItem(this.uID);
        localStorage.removeItem(this.uRole);
    }

    public get userId(): string {
        return localStorage.getItem(this.uID);
    }

    public get role(): string {
        return localStorage.getItem(this.uRole);
    }

    public get isAuth(): boolean {
        let token = localStorage.getItem('accessToken');
        return (token != null) ? true : false;
    }

    public get isUser(): boolean {
        let role = localStorage.getItem(this.uRole);
        return (role == 'ROLE_USER') ? true : false;
    }

}
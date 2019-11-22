import { Injectable } from '@angular/core';


@Injectable()
export class UserInfoService {
    /**
     * @type {string}
     */
    private uID = 'uID';

    /**
     * @type {string}
     */
    private uRole = 'uRole';

    /**
     * Save user info
     * @param decodedAT
     * @returns void
     */
    public SaveUserInfo(decodedAT: any): void
    {
        localStorage.setItem(this.uID, decodedAT.id);
        localStorage.setItem(this.uRole, decodedAT.roles[0]);
    }

    /**
     * Delete user info
     * @returns void
     */
    public DeleteUserInfo(): void
    {
        localStorage.removeItem(this.uID);
        localStorage.removeItem(this.uRole);
    }

    /**
     * Get user id
     * @return {string}
     */
    public get userId(): string
    {
        return localStorage.getItem(this.uID);
    }

    /**
     * Get user role
     * @return {string}
     */
    public get role(): string
    {
        return localStorage.getItem(this.uRole);
    }

    /**
     * Get is user auth
     * @return {boolean}
     */
    public get isAuth(): boolean
    {
        let token = localStorage.getItem('accessToken');
        return (token != null) ? true : false;
    }

    /**
     * Get is user
     * @return {boolean}
     */
    public get isUser(): boolean
    {
        let role = localStorage.getItem(this.uRole);
        return (role == 'ROLE_USER') ? true : false;
    }

}
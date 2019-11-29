import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { BASE_API_URL } from '../../globals';
import { Observable } from "rxjs/index";
import { map } from "rxjs/operators";


@Injectable()
export class RegionService {
    /**
     * @type {string}
     */
    private baseUrl: string;


    /**
     * @type {HttpHeaders}
     */
    private headers = new HttpHeaders({
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json'
    });


    constructor(
        private http: HttpClient
    )
    {
        this.baseUrl = BASE_API_URL;
    }

    /**
     * Get list regions
     * @return {Observable<any>}
     */
    public getRegions(): Observable<any>
    {
        return this.http.get(
            this.baseUrl + '/region', {  headers: this.headers}
        ).pipe(map((response: Response) => response));
    }


}
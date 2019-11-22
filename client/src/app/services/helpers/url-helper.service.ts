import { Injectable } from '@angular/core';

@Injectable()
export class UrlHelperService {
    /**
     * Encode url
     * @param {any} toConvert
     * @returns {string}
     */
    public getFormUrlEncoded(toConvert: any): string
    {
        const formBody = [];
        for (const property in toConvert) {
            const encodedKey = encodeURIComponent(property);
            const encodedValue = encodeURIComponent(toConvert[property]);
            formBody.push(encodedKey + '=' + encodedValue);
        }
        return formBody.join('&');
    }
}
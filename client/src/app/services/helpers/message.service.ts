import { Injectable } from '@angular/core';
import { HttpErrorResponse } from "@angular/common/http";

@Injectable()
export class MessageService {
    public apiMessage: string = "";
    public apiColor: string = "";

    /**
     * Set danger error message
     * @param {HttpErrorResponse} errorResponse
     */
    public setErrorMessage(errorResponse: HttpErrorResponse): void
    {
        if (errorResponse.error) {
            this.apiMessage = errorResponse.error.error;
            this.apiColor = "danger";
        }
        this.swithOff();
    }

    /**
     * Set success message
     * @param {string} result
     */
    public setSuccessMessage(result: string): void
    {
        this.apiMessage = result;
        this.apiColor = "success";
        this.swithOff();
    }

    /**
     * Set warning message
     * @param {string} result
     */
    public setWarningMessage(result: string): void
    {
        this.apiMessage = result;
        this.apiColor = "warning";
        this.swithOff();
    }

    /**
     * Switch off message
     */
    private swithOff(): void
    {
        setTimeout(() => {
            this.apiMessage = "";
            this.apiColor = "";
        }, 3000);
    }

}
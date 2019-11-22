import { Injectable } from '@angular/core';
import { HttpErrorResponse } from "@angular/common/http";

@Injectable()
export class MessageService {
    public apiMessage: string = "";
    public apiColor: string = "";

    public setErrorMessage(errorResponse: HttpErrorResponse): void
    {
        if (errorResponse.error) {
            this.apiMessage = errorResponse.error.error;
            this.apiColor = "danger";
        }
    }

    public setSuccessMessage(result: string): void
    {
        this.apiMessage = result;
        this.apiColor = "success";
    }
}
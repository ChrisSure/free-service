import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { ActivatedRoute } from "@angular/router";
import { MessageService } from "../../../services/helpers/message.service";

@Component({
    selector: 'app-confirm-register',
    templateUrl: './confirm-register.component.html'
})
export class ConfirmRegisterComponent implements OnInit {

    /**
     * @param {AuthService} authService
     * @param {ActivatedRoute} actRoute
     * @param {MessageService} messageService
     */
    constructor(private authService: AuthService, private actRoute: ActivatedRoute, public messageService: MessageService) { }

    ngOnInit() {
        let id = +this.actRoute.snapshot.queryParams['id'];
        let token = this.actRoute.snapshot.queryParams['token'];
        this.authService.confirmRegister(id, token)
            .subscribe((res) => {
                        this.messageService.setSuccessMessage(res);
                    },
                err => {
                        this.messageService.setErrorMessage(err);
                    }
                );
    }

}
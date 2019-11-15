import { Component, OnInit } from '@angular/core';
import { AuthService } from "../../../services/auth/auth.service";
import { ActivatedRoute } from "@angular/router";

@Component({
    selector: 'app-confirm-register',
    templateUrl: './confirm-register.component.html'
})
export class ConfirmRegisterComponent implements OnInit {
    public apiMessage: string = "";
    public apiColor: string = "";

    constructor(private authService: AuthService, private actRoute: ActivatedRoute) { }

    ngOnInit() {
        let id = +this.actRoute.snapshot.queryParams['id'];
        let token = this.actRoute.snapshot.queryParams['token'];
        this.authService.confirmRegister(id, token)
            .subscribe((res) => {
                this.apiMessage = res.toString();
                this.apiColor = "success";
            },
                err => {
                    if (err.error) {
                        this.apiMessage = err.error.error;
                        this.apiColor = "danger";
                    }
                });
    }

}
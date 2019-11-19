import { Injectable } from '@angular/core';
import { FormGroup } from "@angular/forms";


@Injectable()
export class ComparePasswordService {

    public comparePassword(group: FormGroup) {
        const pass = group.value.password;
        const confirm = group.value.confirmPassword;

        return pass === confirm ? null : { notSame: true };
    }

}
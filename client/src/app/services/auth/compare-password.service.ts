import { Injectable } from '@angular/core';
import { FormGroup } from "@angular/forms";


@Injectable()
export class ComparePasswordService {

    /**
     * Compare passsword validation
     * @param {FormGroup} group
     * @return {any}
     */
    public comparePassword(group: FormGroup): any
    {
        const pass = group.value.password;
        const confirm = group.value.confirmPassword;

        return pass === confirm ? null : { notSame: true };
    }

}
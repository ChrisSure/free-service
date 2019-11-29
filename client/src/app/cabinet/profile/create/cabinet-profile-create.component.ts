import { Component, OnInit } from '@angular/core';
import { ProfileService } from "../../../services/profile/profile.service";
import { MessageService } from "../../../services/helpers/message.service";
import { FormControl, FormGroup, Validators } from "@angular/forms";
import { Region } from "../../../models/data/region";
import { RegionService } from "../../../services/data/region.service";
import { City } from "../../../models/data/city";
import { CityService } from "../../../services/data/city.service";
import { Profile } from "../../../models/profile/profile";
import { Router } from "@angular/router";
import {ProfileDto} from "../../../dtos/profile/profile-create-dto";


@Component({
    selector: 'app-cabinet-profile-create',
    templateUrl: './cabinet-profile-create.component.html'
})
export class CabinetProfileCreateComponent implements OnInit {

    createProfileForm: FormGroup;
    regions: Region[];
    cities: City[];

    constructor(
        private profileService: ProfileService,
        public messageService: MessageService,
        private regionService: RegionService,
        private cityService: CityService,
        private router: Router
    ) {
        this.createProfileForm = new FormGroup({
            'firstname': new FormControl('', [Validators.required, Validators.minLength(2), Validators.maxLength(255)]),
            'lastname': new FormControl('', [Validators.required, Validators.minLength(2), Validators.maxLength(255)]),
            'surname': new FormControl('', [Validators.minLength(2), Validators.maxLength(255)]),
            'region': new FormControl('', Validators.required),
            'city': new FormControl('', Validators.required),
            'sex': new FormControl('1', Validators.required),
            'birthday': new FormControl('2000-01-01T00:00:00', Validators.required),
            'phone': new FormControl('', [Validators.required, Validators.pattern('^[0-9]{10}$')]),
            'about': new FormControl('')
        });
    }

    ngOnInit() {
        this.regionService.getRegions().subscribe((res) => {
            this.regions = res;
        },err => {
                this.messageService.setErrorMessage(err);
            });
    }

    public createProfile()
    {
        let profileDto = new ProfileDto(
            this.createProfileForm.value.firstname,
            this.createProfileForm.value.lastname,
            this.createProfileForm.value.city,
            this.createProfileForm.value.phone,
            this.createProfileForm.value.sex,
            this.createProfileForm.value.birthday,
            this.createProfileForm.value.about,
            this.createProfileForm.value.surname,
        );

        this.profileService.createProfile(profileDto).subscribe((res) => {
            this.profileService.CreateProfile.emit(res);
            this.router.navigate(['/cabinet']);
        },err => {
            this.messageService.setErrorMessage(err);
        });
    }

    public onRegionChange(region_id)
    {
        this.cityService.getCitiesByRegionId(region_id).subscribe((res) => {
            this.cities = res;
        },err => {
            this.messageService.setErrorMessage(err);
        });
    }
}
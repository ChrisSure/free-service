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
import { ProfileDto } from "../../../dtos/profile/profile-create-dto";


@Component({
    selector: 'app-cabinet-profile-update',
    templateUrl: './cabinet-profile-update.component.html'
})
export class CabinetProfileUpdateComponent implements OnInit {

    updateProfileForm: FormGroup;
    regions: Region[];
    cities: City[];
    profile: Profile = new Profile(null, '', '', null, null, null,  null);

    constructor(
        private profileService: ProfileService,
        public messageService: MessageService,
        private regionService: RegionService,
        private cityService: CityService,
        private router: Router
    ) {
        this.initializeForm();
        this.profileService.getProfileByUserId().subscribe((res: Profile) => {
            this.profile = res;
            this.onRegionChange(this.profile.city.region.id);
            this.initializeForm();
        });

    }

    private initializeForm() {
        this.updateProfileForm = new FormGroup({
            'firstname': new FormControl(this.profile.firstname, [Validators.required, Validators.minLength(2), Validators.maxLength(255)]),
            'lastname': new FormControl(this.profile.lastname, [Validators.required, Validators.minLength(2), Validators.maxLength(255)]),
            'surname': new FormControl(this.profile.surname, [Validators.minLength(2), Validators.maxLength(255)]),
            'region': new FormControl((this.profile.city != null) ? this.profile.city.region.id : null, Validators.required),
            'city': new FormControl((this.profile.city != null) ? this.profile.city.id : null, Validators.required),
            'sex': new FormControl(this.profile.sex, Validators.required),
            'birthday': new FormControl(this.profile.birthday, Validators.required),
            'phone': new FormControl(this.profile.phone, [Validators.required, Validators.pattern('^[0-9]{10}$')]),
            'about': new FormControl(this.profile.about)
        });
    }

    ngOnInit() {
        this.regionService.getRegions().subscribe((res) => {
            this.regions = res;
        },err => {
            this.messageService.setErrorMessage(err);
        });
    }

    public updateProfile()
    {
        let profileDto = new ProfileDto(
            this.updateProfileForm.value.firstname,
            this.updateProfileForm.value.lastname,
            this.updateProfileForm.value.city,
            this.updateProfileForm.value.phone,
            this.updateProfileForm.value.sex,
            this.updateProfileForm.value.birthday,
            this.updateProfileForm.value.about,
            this.updateProfileForm.value.surname,
        );

        this.profileService.updateProfile(profileDto, this.profile.id).subscribe((res) => {
            this.profileService.CreateProfile.emit(res);
            this.router.navigate(['/cabinet']);
        },err => {
            console.log(err);
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
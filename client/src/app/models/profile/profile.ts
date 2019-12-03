import { City } from "../data/city";
import { User } from "../auth/user";

export class Profile {
    constructor(
        public id: number,
        public firstname: string,
        public lastname: string,
        public phone: number,
        public sex: number,
        public birthday: string,
        public city: City,
        public about?: string,
        public surname?: string,
        public user?: User
    ) { }
}
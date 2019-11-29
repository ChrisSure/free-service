export class User {
    constructor(
        public id: number,
        public email: string,
        public password: string,
        public profile: number,
        public roles: [],
        public social: [],
        public status: string
    ) { }
}
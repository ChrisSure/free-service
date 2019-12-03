export class User {
    constructor(
        public id: number,
        public email: string,
        public password: string,
        public profile: number,
        public roles: object,
        public social: object,
        public status: string
    ) { }
}
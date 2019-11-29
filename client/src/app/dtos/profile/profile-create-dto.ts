export class ProfileDto {
    constructor(
        public firstname: string,
        public lastname: string,
        public city: number,
        public phone: number,
        public sex: number,
        public birthday: string,
        public about?: string,
        public surname?: string,
        public user?: number
    ) { }
}
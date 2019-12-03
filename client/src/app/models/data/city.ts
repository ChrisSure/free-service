import { Region } from "./region";

export class City {
    constructor(
        public id: number,
        public region: Region,
        public name: string
    ) { }
}
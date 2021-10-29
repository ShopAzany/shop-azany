export class UserRatings {
    constructor(
        public data: any,
        public counts: number,
        public earned: number,
        public employer: string,
        public photo: string,
        public total: number,
        public review: string,
        public created_at: Date
    ) { }
}

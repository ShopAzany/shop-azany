export class User {
    length: number;
    constructor(
        public login_id: number,
        public publication: number,
        public username: string,
        public email: string,
        public password: string,
        public first_name: string,
        public last_name: string,
        public phone: string,
        public photo: string,
        public title: string,
        public category: string,
        public additional_category: string,
        public fee: number,
        public day_fee: number,
        public month_fee: number,
        public on_contract: string,
        public city: string,
        public state: string,
        public country: string,
        public country_iso: string,
        public referral: string,
        public about: string,
        public skills: string,
        public status: number,
        public status_type: string,
        public status_reasons: string,
        public signup_ip: string,
        public created_at: Date,
        public update_at: Date,
        public lastseen_at: Date,
        public lastseen_ip: string,
        public token: string,
        public exp: string,
        public loginAsUser: boolean,
        public rating: any,
    ) { }

}

export class Freelancers {
    constructor(
        public login_id: number,
        public username: string,
        public photo: string,
        public title: string,
        public fee: number,
        public fee_per: string,
        public day_fee: number,
        public month_fee: number,
        public on_contract: string,
        public state: string,
        public country: string,
        public country_iso: string,
        public about: string,
        public skills: string,
        public lastseen_at: Date,
        public isFavorite: any,
    ) { }
}

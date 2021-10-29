import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { VisitorService } from './visitor.service';
import { Subject, Observable, BehaviorSubject } from 'rxjs';
import { User } from '../model/user';
import { AuthService } from './auth.service';
import { ConfigService } from './config.service';
import { AdminAuthService } from './admin-auth.service';
import { delay, tap } from 'rxjs/operators';

@Injectable({ providedIn: 'root' })
export class CurrencyService {
    private serverUrl: string;
    private token: string;
    private subject = new Subject<any>();
    private _currency = new BehaviorSubject<any>(null);

    constructor(
        private http: HttpClient,
        private config: ConfigService,
        private adminAuthService: AdminAuthService
    ) {
        this.serverUrl = this.config.base_url();
        this.adminAuthService.admin.subscribe(auth => {
            if (auth) { this.token = auth.token; }
        });
    }

    get getCurrency() {
        return this._currency;
    }

    currencyDefault() {
        return this.http.get<any>(this.serverUrl + 'currency')
            .pipe(tap(resData => {
                if (resData) { this._currency.next(resData); }
            }), delay(2000));
    }

    add(postData: string) {
        return this.http.post<any>(
            this.serverUrl + 'currency/add/' + this.token,
            { data: postData }
        );
    }

    setDefault(postData: string) {
        return this.http.post<any>(
            this.serverUrl + 'currency/setDefault/' + this.token,
            { data: postData }
        );
    }


}

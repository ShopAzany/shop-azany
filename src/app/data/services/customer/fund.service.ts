import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Fund } from '../../model/fund';
import { AuthService } from '../auth.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable({ providedIn: 'root' })
export class FundService {
  private serverUrl: string;
  private token: string;
  private _userFunds = new BehaviorSubject(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService,
    private storageService: StorageService,
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  get myFund() {
    return this._userFunds.asObservable();
  }

  userFunds;

  get funds() {
    return this.userFunds;
  }

  localFundsCheck() {
    if (this.storageService.hasKey('userBalance')) {
      let userBal = JSON.parse(this.storageService.getString('userBalance'));
      let savedDate = userBal.savedDate;
      let aDay = 6 * 60 * 60 * 1000;
      if ((Date.now() - savedDate) >= aDay) {
        this.getFunds().subscribe();
      } else {
        this._userFunds.next(userBal.data);
      }
    } else {
      this.getFunds().subscribe();
    }
  }

  // get user earnings
  getFunds() {
    return this.http.get(this.serverUrl + 'user/funds/' + this.token)
      .pipe(
        tap(resData => {
          if (resData) {
            this._userFunds.next(resData);
            let prepDate = Date.now();
            let savedProd = { savedDate: prepDate, data: resData };
            let savedProdJSON = JSON.stringify(savedProd);
            this.storageService.storeString('userBalance', savedProdJSON);
          }
        }));
  }

  getUserTransactions(limit = 10, page = 1) {
    return this.http.get<any>(this.serverUrl + 'user/funds/transactions/' + this.token + '/' + limit + '/' + page)
  }

  payoutInformation() {
    return this.http.get<any>(`${this.serverUrl}user/funds/payout_information/${this.token}`);
  }

  payoneer(data) {
    return this.http.post<any>(`${this.serverUrl}user/funds/update_payoneer/${this.token}`, data);
  }

  payPal(data) {
    return this.http.post<any>(`${this.serverUrl}user/funds/update_paypal/${this.token}`, data);
  }

  bank(data) {
    return this.http.post<any>(`${this.serverUrl}user/funds/update_bank/${this.token}`, data);
  }

  verifyAccNo(data) {
    return this.http.post<any>(`${this.serverUrl}user/funds/verify_account_number/${this.token}`, data);
  }

  withdraw(payMethod) {
    return this.http.get<any>(`${this.serverUrl}user/funds/withdrawal_request/${this.token}/${payMethod}`);
  }

  getWalletHistory(limit = 10, page = 1) {
    return this.http.get<any>(this.serverUrl + 'user/funds/walletHistory/' + this.token + '/' + limit + '/' + page)
  }

  getCoupons(limit = 10, page = 1) {
    return this.http.get<any>(this.serverUrl + 'user/my_coupon/' + this.token + '/' + limit + '/' + page)
  }

  genCoupon(postData) {
    return this.http.post<any>(this.serverUrl + 'user/my_coupon/generate_coupon/' + this.token, postData);
  }

  updateCoupon(postData) {
    return this.http.post<any>(`${this.serverUrl}user/my_coupon/update_coupon/${this.token}`, postData);
  }

  deleteCoupon(id) {
    return this.http.get<any>(`${this.serverUrl}user/my_coupon/generate_coupon/${this.token}/${id}`);
  }

  searchEarning(keyword) {
    return this.http.get<any>(this.serverUrl + 'user/my_coupon/search/' + this.token + '/' + keyword)
  }
}

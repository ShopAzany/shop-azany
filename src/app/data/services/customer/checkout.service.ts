import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Checkout } from '../../model/checkout';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class CheckoutService {
  private serverUrl: string;
  private token: string;
  private _checkout = new BehaviorSubject<any>(null);
  private _checkoutOption = new BehaviorSubject<Checkout>(null);
  private _checkoutItems = new BehaviorSubject<Checkout>(null);
  private _thankYouData = new BehaviorSubject<any>(null);


  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  // get myFund() {
  //   return this._checkout.asObservable();
  // }

  get thankYouData() {
    return this._thankYouData.asObservable();
  }

  get getCheckoutOption() {
    return this._checkoutOption.asObservable();
  }

  get getCheckoutInfo() {
    return this._checkout.asObservable();
  }

  postSelectedItems(ids) {
    return this.http.post<any>(
      `${this.serverUrl}user/checkout/${this.token}`, ids
    ).pipe(tap(res => {
      if (res) {
        this._checkout.next(res);
      }
    }));
  }

  // checkoutOption() {
  //   return this.http.get<any>(
  //     this.serverUrl + 'user/checkout/' + this.token
  //   ).pipe(tap(resData => {
  //     if (resData) {
  //       this._checkoutOption.next(resData);
  //     }
  //   }));
  // }

  // place order
  placeOrder(address, cardIds, payMethod, ref = null) {
    return this.http.post<any>(
      this.serverUrl + 'user/checkout/place_order/'
      + this.token + '/' + ref,
      {
        address: address,
        cartIDs: cardIds,
        payMethod: payMethod
      }
    ).pipe(tap(res => {
      if (res.status == 'success') {
        this._thankYouData.next({ products: res.products, orderNo: res.data, payment_method: res.payMethod, bankInfo: res.bankInfo, thankYouMsg: res.thankYouMsg });
      }
    }));
  }

  // Verify checkout payment
  verifyPayment(ref: string, postData: any, m = 0) {
    return this.http.post<any>(
      this.serverUrl + 'user/checkout/verifyPayment/'
      + this.token + '/' + ref + '/' + m, postData
    );
  }

  // pay with balance
  payWithBalance(postData: any) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/checkout/payWithBalance/'
        + this.token, postData
      );
  }

  verify_coupon(coupon: any) {
    return this.http.get<any>(
      this.serverUrl + 'user/checkout/verify_coupon/'
      + this.token + '/' + coupon
    );
  }
}

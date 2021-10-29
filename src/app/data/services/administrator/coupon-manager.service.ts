import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject, Subject, Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class CouponManagerService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;
  private subject = new Subject<any>();
  private _product = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private adminAuthService: AdminAuthService
  ) {
    this.serverUrl = this.config.base_url();
    this.adminUrl = this.config.adminURL;
    this.adminAuthService.admin.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  setURLstringVal(data: any) {
    this.subject.next(data);
  }

  get getURLstringVal(): Observable<any> {
    return this.subject.asObservable();
  }

  get getProduct(): Observable<any> {
    return this._product.asObservable();
  }

  coupons(limit = 10, page = 1, sortbyName = 'DESC') {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/coupon_manager/' +
      this.token + '/' + limit + '/' + page + '/' + sortbyName
    );
  }

  generate_coupon(postData: string) {
    return this.http.post<any>(
      this.serverUrl + this.adminUrl + '/coupon_manager/generate_coupon/'
      + this.token, { data: postData }
    );
  }

  search(keyword) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/coupon_manager/search/' +
      this.token + '/' + keyword
    );
  }

  delete(id) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/coupon_manager/delete/' +
      this.token + '/' + id
    );
  }

  // /administrator/coupon_manager/update_coupon/token

  updateCoupon(data) {
    return this.http.post<any>(`${this.serverUrl}${this.adminUrl}/coupon_manager/update_coupon/${this.token}`, { data: data });
  }


}

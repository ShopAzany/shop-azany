import { Inject, Injectable, PLATFORM_ID } from '@angular/core';
import { HttpClient, ɵHttpInterceptingHandler } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';
import { throwError, BehaviorSubject, of } from 'rxjs';

import { ConfigService } from '../config.service';
import { User } from '../../model/user';
import { RoutingService } from '../../helpers/routing.service';
import { StorageService } from '../../helpers/storage.service';
import { VisitorService } from '../visitor.service';
import { UserService } from '../guest/user.service';
import { AdminAuthService } from '../admin-auth.service';
import { FundService } from '../customer/fund.service';

@Injectable({ providedIn: 'root' })
export class SellerAuthService {
  private serverUrl: string;
  private _seller = new BehaviorSubject<any>(null);
  private token: string;


  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private http: HttpClient,
    private config: ConfigService,
    private routingService: RoutingService,
    private storageService: StorageService,
    private visitorService: VisitorService,
    private userService: UserService,
    private adminAuthService: AdminAuthService,
  ) {
    this.serverUrl = this.config.base_url();
  }

  get seller() {
    return this._seller.asObservable();
  }


  signup(postData: string) {
    // let location;
    // this.visitorService.userLocation.subscribe(resp => {
    //   location = resp;
    // });
    return this.http.post<any>(
      //`${this.serverUrl}seller/register`, { data: postData }
      `https://manage.shopazany.com/seller/register`, { data: postData }
    ).pipe(tap(res => {
      if (res.status && res.status == 'success') {
        this.token = res.data.token;
        console.log(this.token)
        this.storeAuthData(res.data);
      }
    }));
  }

  //updated
  signupBizInfo(data: string, seller_id: number) {
    console.log(this.token);
    return this.http.post<any>(
      `${this.serverUrl}seller/account_settings/register_business_info_alt/${seller_id}`, { data: data }
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.updateSellerData('biz_info_status', 1);
        this.updateSellerData('biz_info', res.data);
      }
    }));
  }

  //updated
  updateBizInfo(data: string, seller_id: number) {
    console.log(this.token);
    return this.http.post<any>(
      `${this.serverUrl}seller/account_settings/update_business_info_alt/${seller_id}`, { data: data }
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.updateSellerData('biz_info_status', 1);
        this.updateSellerData('biz_info', res.data);
      }
    }))
  }

  //updated
  signupBankInfo(data: string, seller_id:number) {
    return this.http.post<any>(
      //`${this.serverUrl}seller/account_settings/update_bank_info/${this.token}`, { data: data }
      `${this.serverUrl}seller/account_settings/update_bank_info_alt/${seller_id}`, { data: data }
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.updateSellerData('bank_info_status', 1);
        this.updateSellerData('bank_info', res.data);
      }
    }))
  }

  //updated
  deleteBank(id, seller_id: number) {
    return this.http.get<any>(
      `${this.serverUrl}seller/account_settings/delete_bank_info_alt/${seller_id}/${id}`
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.updateSellerData('bank_info', res.data);
      }
    }));
  }

  //updated
  updateProfile(data: string, seller_id: number) {
    return this.http.post<any>(
      //`${this.serverUrl}seller/account_settings/updateProfile/${this.token}`, { data: data }
      `${this.serverUrl}seller/account_settings/updateProfile_alt/${seller_id}`, { data: data }
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.storeAuthData(res.data);
      }
    }));
  }

  updateSellerData(key: string, value) {
    const sellerData = this._seller.value;
    sellerData[key] = value;
    this._seller.next(sellerData);
    this.storageService.storeString('sellerData', JSON.stringify(sellerData));
  }

  signUpEmail(email: string) {
    return this.http
      .post<string>(
        this.serverUrl + 'register/validate_email', email
      );
  }

  signUpUsername(postData: string, email: string) {
    let location;
    this.visitorService.userLocation.subscribe(resp => {
      location = resp;
    });
    return this.http
      .post<any>(
        this.serverUrl + 'register/process_signup',
        { data: postData, email: email, location: location }
      );
  }

  socialSignup(postData: string, socialData: string, email: string) {
    let location;
    this.visitorService.userLocation.subscribe(resp => {
      location = resp;
    });
    return this.http
      .post<any>(
        this.serverUrl + 'register/social_signup',
        { data: postData, socialData: socialData, email: email, location: location }
      );
  }

  login(data: string) {
    return this.http
      .post<any>(
        `${this.serverUrl}seller/login`,
        data
      ).pipe(tap(res => {
        if (res && res.status == 'success') {
          this.storeAuthData(res.data);
        }
      }));
  }

  socialLogin(userData: string) {
    return this.http
      .post<any>(
        this.serverUrl + 'login/socialLogin/', userData
      );
  }

  logout() {
    this._seller.next(null);
    localStorage.clear();
    this.routingService.replace(['/seller/login']);
  }

  logoutAlt() {
    this._seller.next(null);
    this.storageService.remove('sellerData');
  }

  resetPass(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}seller/forget_password/validate_email`,
      { data: postData }
    );
  }

  verifyToken(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}seller/forget_password/verify_token`,
      { data: postData }
    );
  }

  verifyEmail(postData: string) {
    return this.http.post<any>(
      //`${this.serverUrl}seller/register/verify_token`,
      `https://manage.shopazany.com/seller/register/verify_token`,
      { data: postData }
    );
  }


  changePassword(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}seller/forget_password/change_password`,
      { data: postData }
    );
  }

  autoLogin() {
    if (!this.storageService.hasKey('sellerData')) {
      return of(false);
    }
    const sellerData = JSON.parse(this.storageService.getString('sellerData'));

    if (sellerData) {
      // if (!this.checkAuthStatus(sellerData)) {
      //   return of(false);
      // }
      // this.checkOnlineStatus(sellerData);
      this.token = sellerData.token;
      this._seller.next(sellerData);
      return of(true);
    }
    return of(false);
  }

  checkAuthStatus(auth): boolean {
    if (auth.hasOwnProperty('authAge')) {
      let authAge = auth['authAge'];
      let hourMs = 60 * 60 * 1000;
      if (Date.now() - authAge >= hourMs) {
        return false;
      }
      return true;
    }
    return true;

  }



  // Used within and outside
  storeAuthData(auth) {
    // if (auth.status == 0) {
    //   auth['authAge'] = Date.now();
    // } else {
    //   if (auth.hasOwnProperty('authAge')) {
    //     delete auth['authAge'];
    //   }
    // }
    this.storageService.storeString('sellerData', JSON.stringify(auth));
    // this.adminAuthService.storeAdminAuthData(null);
    this._seller.next(auth);
  }

  private checkOnlineStatus(user) {
    const isOnline = this.userService.isOnline(user.lastseen_at);
    if (isOnline !== 'isOnline') {
      // Update lastseen if not already online
      this.updateOnlineStatus(user.token).subscribe();
    }
  }

  //
  private updateOnlineStatus(token: string) {
    return this.http
      .get<any>(
        this.serverUrl + 'user/profile/onlineStatus/' + token
      );
  }
}

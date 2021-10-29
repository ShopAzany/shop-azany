import { Inject, Injectable, PLATFORM_ID } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { catchError, tap } from 'rxjs/operators';
import { throwError, BehaviorSubject, of } from 'rxjs';

import { ConfigService } from './config.service';
import { User } from '../model/user';
import { RoutingService } from '../helpers/routing.service';
import { StorageService } from '../helpers/storage.service';
import { VisitorService } from './visitor.service';
import { UserService } from './guest/user.service';
import { AdminAuthService } from './admin-auth.service';
import { FundService } from './customer/fund.service';
import { ShoppingCartService } from './guest/shopping-cart.service';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private serverUrl: string;
  private _customer = new BehaviorSubject<any>(null);
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

  get customer() {
    return this._customer.asObservable();
  }

  // Become freelancer
  signup(postData: string) {
    let location;
    this.visitorService.userLocation.subscribe(resp => {
      location = resp;
    });
    return this.http.post<any>(
      this.serverUrl + 'register/signup',
      { data: postData, location: location }
    );
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

  login(email: string, password: string) {
    return this.http
      .post<User>(
        this.serverUrl + 'login/authenticate/',
        { user: email, password: password }
      ).pipe(tap(auth => {
        if (auth && auth.login_id) {
          this.storeAuthData(auth);
        }
      }));
  }

  socialLogin(userData: string) {
    return this.http
      .post<any>(
        this.serverUrl + 'login/socialLogin', userData
      ).pipe(tap(auth => {
        if (auth && auth.login_id) {
          this.storeAuthData(auth);
        }
      }));
  }

  logout() {
    this._customer.next(null);
    console.log(this._customer.value);
    localStorage.clear();
    this.routingService.replace(['/']);
  }

  logoutAlt() {
    this._customer.next(null);
    this.storageService.remove('userData');
  }

  autoLogin() {
    if (!this.storageService.hasKey('userData')) {
      return of(false);
    }
    const userData = JSON.parse(this.storageService.getString('userData'));

    if (userData) {
      if (!this.checkAuthStatus(userData)) {
        return of(false);
      }
      this._customer.next(userData);
      return of(true);
    }
    return of(false);
  }

  resetPass(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'forget_password/validate_email/',
      { data: postData }
    );
  }

  verifyToken(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'forget_password/verify_token/',
      { data: postData }
    );
  }


  changePassword(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'forget_password/change_password/',
      { data: postData }
    );
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
  storeAuthData(auth: User) {
    // if (auth.status == 0) {
    //   auth['authAge'] = Date.now();
    // } else {
    //   if (auth.hasOwnProperty('authAge')) {
    //     delete auth['authAge'];
    //   }
    // }
    this.storageService.storeString('userData', JSON.stringify(auth));
    this._customer.next(auth);
  }

  private checkOnlineStatus(user: User) {
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

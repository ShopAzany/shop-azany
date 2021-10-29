import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Fund } from '../../model/fund';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class UserReferralService {
  private serverUrl: string;
  private token: string;
  // private _userFunds = new BehaviorSubject<Fund>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.user.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  myReferrals(limit=10, page =1) {
    return this.http.get<any>(this.serverUrl + 'user/my_referrals/users/' + this.token + '/' + limit + '/' + page);
  }

  myReferralEarnings(limit=10, page =1) {
    return this.http.get<any>(this.serverUrl + 'user/my_referrals/earnings/' + this.token + '/' + limit + '/' + page);
  }

  myReferralInfo() {
    return this.http.get<any>(this.serverUrl + 'user/my_referrals/' + this.token);
  }
}

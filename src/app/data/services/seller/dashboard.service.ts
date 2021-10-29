import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, Subject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { ConfigService } from '../config.service';
import { SellerAuthService } from './seller-auth.service';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  private serverUrl: string;
  private sellerUrl: string;
  private token: string;
  private _product = new BehaviorSubject<any>(null);
  private subject = new Subject<any>();

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private sellerAuthService: SellerAuthService
  ) {
    this.serverUrl = this.config.base_url();
    this.sellerUrl = this.config.sellerURL;
    // this.sellerAuthService.
    this.sellerAuthService.seller.subscribe(auth => {
      if (auth) {
        this.token = auth.token;
      }
    });
  }


  dashboardInfo(duration) {
    return this.http.get<any>(
      `${this.serverUrl}${this.sellerUrl}/account_settings/dashboard_info/${this.token}/${duration}`
    );
  }

  // getTransactions() {
  //   return this.http.get<any>(
  //     `${this.serverUrl}${this.sellerUrl}/wallet/wallet_info/${this.token}`,
  //   );
  // }

  // withdraw(postData: string) {
  //   return this.http.post<any>(
  //     `${this.serverUrl}${this.sellerUrl}/withdrawal_manager/request/${this.token}`, { data: postData }
  //   );
  // }

}

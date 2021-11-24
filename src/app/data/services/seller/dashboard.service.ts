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
  private seller_id: number;

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
        this.seller_id = auth.seller_id;
      }
    });
  }


  dashboardInfo(duration) {
    console.log(this.token)
    return this.http.get<any>(
      //`${this.serverUrl}${this.sellerUrl}/account_settings/dashboard_info/${this.token}/${duration}`
      `${this.serverUrl}${this.sellerUrl}/account_settings/dashboard_info_alt/${this.seller_id}/${duration}`
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

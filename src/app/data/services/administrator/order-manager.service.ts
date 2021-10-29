import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class OrderManagerService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;

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

  orders(limit = 20, page = 1, status = 'none', role = 'none') {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/order_manager/' +
      this.token + '/' + limit + '/' + page + '/' + status + '/' + role
    );
  }

  searchOrders(keyword, limit = 10, page = 1) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/order_manager/search/' + this.token + '/' + keyword + '/' + limit + '/' + page
    )
  }

  dashboard(limit = 5) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl +
      '/order_manager/dashboard/' + this.token + '/' + limit
    );
  }

  cancelOrder(ordernum) {
    return this.http.get<any>(
      `${this.serverUrl}${this.adminUrl}/order_manager/cancel/${this.token}/${ordernum}`
    );
  }

  getOrder(ordernum) {
    return this.http.get<any>(
      `${this.serverUrl}${this.adminUrl}/order_manager/single/${this.token}/${ordernum}`
    );
  }

}

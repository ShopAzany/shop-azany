import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject, Observable, Subject } from 'rxjs';

import { ConfigService } from '../config.service';
import { Order } from '../../model/order';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class OrderService {
  private serverUrl: string;
  private token: string;
  private _salesOrder = new BehaviorSubject<Order>(null);
  private _orders = new BehaviorSubject<Order>(null);
  private _order = new BehaviorSubject<Order>(null);
  private _deliveries = new BehaviorSubject<any>(null);
  private _approve = new BehaviorSubject<any>(null);
  private subject = new Subject<any>();

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



  get orders() {
    return this._orders.asObservable();
  }

  get order() {
    return this._order.asObservable();
  }

  getOrders(limit: number = 30, page: number = 1) {
    return this.http.get<any>(this.serverUrl + 'user/order/' +
      this.token + '/' + limit + '/' + page
    )
      .pipe(tap(resData => {
        if (resData) {
          this._orders.next(resData);
        }
      }));
  }

  getOrder(orderNumer) {
    return this.http.get<any>(
      this.serverUrl + 'user/order/single/' + this.token + '/' + orderNumer
    )
      .pipe(tap(resData => {
        if (resData) {
          this._order.next(resData);
        }
      }));
  }

  getCancelledOrders(limit: number = 30, page: number = 1) {
    return this.http.get<any>(this.serverUrl + 'user/order/getCancelledOrder/' +
      this.token + '/' + limit + '/' + page
    )
      .pipe(tap(resData => {
        if (resData) {
          this._orders.next(resData);
        }
      }));
  }

  cancelOrder(orderNumer) {
    return this.http.get<any>(
      this.serverUrl + 'user/order/cancelOrder/' + this.token + '/' + orderNumer
    )
      .pipe(tap(resData => {
        if (resData) {
          this._order.next(resData);
        }
      }));
  }

  trackOrder(id, orderNum) {
    return this.http.get<any>(
      `${this.serverUrl}user/order/trackOrder/${this.token}/${id}/${orderNum}`
    )
  }





}

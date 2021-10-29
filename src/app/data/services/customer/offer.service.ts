import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Offer } from '../../model/offer';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class OfferService {
  private serverUrl: string;
  private token: string;
  private _quotes = new BehaviorSubject<Offer>(null);
  private _quote = new BehaviorSubject<Offer>(null);

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

  // Get quotes
  getQuotes(
    limit: number = 10,
    page: number = 1,
    jobID: any = 0
  ) {
    return this.http.get<any>(
      this.serverUrl + 'user/quotes/'
      + this.token + '/' + limit + '/' + page + '/' + jobID
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._quotes.next(resData);
        }
    }));
  }

   // get single quote
   getQuote(
    quoteID: any // Its number actually
  ) {
    return this.http.get<any>(
      this.serverUrl + 'user/quotes/single/' + this.token + '/' + quoteID
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._quote.next(resData);
        }
    }));
  }

  // Post or update job
  sendQuote( postData: string, receiverUsername='', jobID = 0) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/quotes/send/' +
        this.token + '/' + receiverUsername + '/' + jobID,
        { data: postData }
      );
  }

  chargeRates() {
    return this.http.get<any>(`${this.serverUrl}user/quotes/charge_rates/${this.token}`);
  }

  // action
  updateAction( quoteID: number, action: string) {
    return this.http
      .get<any>(
        this.serverUrl + 'user/quotes/action/'
        + this.token + '/' + quoteID + '/' + action
      );
  }

}

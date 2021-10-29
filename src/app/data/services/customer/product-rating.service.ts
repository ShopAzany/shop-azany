import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { ConfigService } from '../config.service';

@Injectable({
  providedIn: 'root'
})
export class ProductRatingService {

  private serverUrl: string;
  private token: string;
  private _pendingReviews = new BehaviorSubject<any>(null);

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

  get getPendingReviews() {
    return this._pendingReviews.asObservable();
  }

  pendingReviews(limit: number = 30, page: number = 1) {
    return this.http.get<any>(
      this.serverUrl + 'user/rating/' + this.token + '/' + limit + '/' + page
    ).pipe(tap(resData => {
      if (resData) {
        this._pendingReviews.next(resData);
      }
    }));
  }
  

  singleReview(orderID) {
    return this.http.get<any>(
      this.serverUrl + 'user/rating/rate/' + this.token + '/' + orderID
    );
  }

  addReview(postData) {
    return this.http.post<any>(
        this.serverUrl + 'user/rating/post_rate/' + this.token,
        { data: postData }
    );
  }



}

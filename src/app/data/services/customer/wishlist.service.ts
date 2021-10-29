import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { ConfigService } from '../config.service';
import { GuestHomeService } from '../guest/guest-home.service';
import { ProductService } from '../guest/products.service';

@Injectable({
  providedIn: 'root'
})
export class WishlistService {

  private serverUrl: string;
  private token: string;
  private _thewishlist = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService,
    private productService: ProductService,
    private guestHomeService: GuestHomeService,
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  get getTheWishList() {
    return this._thewishlist.asObservable();
  }

  getWishList(limit: number = 30, page: number = 1) {
    return this.http.get<any>(this.serverUrl + 'user/wishlist/' +
      this.token + '/' + limit + '/' + page
    )
      .pipe(tap(resData => {
        if (resData) {
          this._thewishlist.next(resData);
        }
      }));
  }

  removeWishList(id) {
    return this.http.get<any>(
      this.serverUrl + 'user/wishlist/remove_wishlist/' + this.token + '/' + id
    );
  }

  removeFavorite(pid) {
    return this.http.get<any>(
      `${this.serverUrl}user/wishlist/remove_wishlist/${this.token}/${pid}`
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.productService.updateRecentViewedFav(pid, 0);
        this.guestHomeService.updateHomeInfoFav(pid, 0);
      }
    }));
  }

  addFavorite(pid: number) {
    return this.http.get<any>(
      `${this.serverUrl}user/wishlist/add_wishlist/${this.token}/${pid}`
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.productService.updateRecentViewedFav(pid, 1);
        this.guestHomeService.updateHomeInfoFav(pid, 1);
      }
    }));;
  }

}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap, delay } from 'rxjs/operators';
import { BehaviorSubject, Subject, Observable } from 'rxjs';

import { ConfigService } from '../config.service';
import { Freelancers, User } from '../../model/user';
import { VisitorService } from '../visitor.service';
import { StorageService } from '../../helpers/storage.service';
import { AuthService } from '../auth.service';
import { ProductService } from './products.service';

@Injectable({ providedIn: 'root' })
export class GuestHomeService {
  private serverUrl: string;
  private _searchResults = new BehaviorSubject<Freelancers>(null);
  private _slideBanners = new BehaviorSubject<any>(null);
  private _homeData = new BehaviorSubject<any>(null);
  private _recommendedCat = null;
  private token;

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private storageService: StorageService,
    private authService: AuthService,
    private productService: ProductService,
  ) {
    this.serverUrl = this.config.base_url();
    authService.customer.subscribe(auth => {
      if (auth) {
        this.token = auth.token;
      } else {
        this.token = null;
      }
    });
    productService.recentlyViewed.subscribe(res => {
      if (res) {
        let catArr = [];
        for (let prod of res) {
          let eachCat = prod.category.split(',')[0];
          if (!catArr.includes(eachCat)) {
            catArr.push(eachCat);
          }
        }
        this._recommendedCat = JSON.stringify(catArr);
        this.getOtherData().subscribe();
      }
    });
  }

  get homeOthers() {
    return this._homeData;
  }

  get searchResults() {
    return this._searchResults.asObservable();
  }

  get homeBannerSliders() {
    return this._slideBanners;
  }

  home() {
    return this.http.get<any>(this.serverUrl + 'home/popular');
  }

  updateHomeInfoFav(pid, fav) {
    let homeData = this._homeData.value;
    if (homeData) {
      // let recentlyAdd = homeData;
      homeData.featProBan.products.forEach(each => {
        if (each.pid == pid) {
          each.isFavorite = fav;
        }
      });
      homeData.recentlyAdded.forEach((each) => {
        if (each.pid == pid) {
          each.isFavorite = fav;
        }
      });
      homeData.recommended.forEach((each) => {
        if (each.pid == pid) {
          each.isFavorite = fav;
        }
      });
      homeData.shopByCountry.forEach(each => {
        each.selectedPro.forEach(each2 => {
          if (each2.pid == pid) {
            each2.isFavorite = fav;
          }
        });
      });
      homeData.todayDeals.forEach(each => {
        if (each.pid == pid) {
          each.isFavorite = fav;
        }
      });
      homeData.topSelling.forEach(each => {
        if (each.pid == pid) {
          each.isFavorite = fav;
        }
      });
      this._homeData.next(homeData);
    }
  }

  getHomeSliders() {
    return this.http.get<any>(
      `${this.serverUrl}/sliders`
    ).pipe(tap(res => {
      // console.log(res);
      this._slideBanners.next(res);
    }));
  }

  getOtherData() {
    return this.http.get<any>(
      `${this.serverUrl}categories/home_info/${this.token}/${this._recommendedCat}`
    ).pipe(tap(res => {
      // console.log(res);
      this._homeData.next(res);
    }));
  }

}

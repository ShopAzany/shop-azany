import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { delay, tap } from 'rxjs/operators';
import { pipe, Subject, Observable, BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';
import { AuthService } from '../auth.service';
import { AdminAuthService } from '../admin-auth.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable({ providedIn: 'root' })
export class ProductService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;
  private adminToken: string;
  private subject = new BehaviorSubject<any>(null);
  waitCtrl = new BehaviorSubject<any>(false);
  private _products = new BehaviorSubject<any>(null);
  private _recentViewed = new BehaviorSubject<any>(null);
  private _product = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService,
    private adminAuthService: AdminAuthService,
    private storageService: StorageService,
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
    this.adminUrl = this.config.adminURL;
    this.adminAuthService.admin.subscribe(auth => {
      if (auth) { this.adminToken = auth.token; }
    });
  }

  private requestHeader() {
    const headers = new HttpHeaders({
      /* 'AuthKey': 'my-key',
      'AuthToken': 'my-token', */
      'Content-Type': 'application/json',
    });
    return headers;
  }

  get recentlyViewed() {
    return this._recentViewed.asObservable();
  }

  get waitCtrlGet() {
    return this.waitCtrl.asObservable();
  }

  // get getProduct(): Observable<any> {
  //   return this._product.asObservable();
  // }

  // products(category = 'all', limit = 24, page = 1, token = '') {
  //   return this.http.get<any>(
  //     this.serverUrl + 'products/' + token + '/' +
  //     category + '/' + limit + '/' + page
  //   )
  //     .pipe(tap(resData => {
  //       if (resData) { this._product.next(resData); }
  //     }), delay(1000));
  // }

  retrieveRecentViewed() {
    if (this.storageService.hasKey('recentlyViewedProducts')) {
      const recent = JSON.parse(this.storageService.getString('recentlyViewedProducts'));
      this._recentViewed.next(recent);
    }
  }

  removeRecent(pid) {
    let prods = this._recentViewed.value;
    prods.filter((each, i) => {
      if (each.pid == pid) {
        prods.splice(i, 1);
      }
    });
    this.storageService.storeString('recentlyViewedProducts', JSON.stringify(prods));
    this.retrieveRecentViewed();
  }

  search(category, keyword, limit = 12, page = 1, sort = null, queryStr = '') {
    return this.http.get<any>(
      `${this.serverUrl}search/${category}/${keyword}/${limit}/${page}/${this.token}/${sort}${queryStr}`
    )
  }

  storeRecentViewed(prod) {
    if (this._recentViewed.value) {
      let products = this._recentViewed.value;
      let prodInd = -1;
      products.forEach((each, i) => {
        if (each.pid == prod.pid) {
          prodInd = i;
        }
      });
      if (prodInd > -1) {
        products.splice(prodInd, 1, prod);
      } else {
        products.push(prod);
      }
      this.storageService.storeString('recentlyViewedProducts', JSON.stringify(products));
      this.retrieveRecentViewed();
    } else {
      this._recentViewed.next([prod]);
      this.storageService.storeString('recentlyViewedProducts', JSON.stringify([prod]));
      this.retrieveRecentViewed();
    }
  }

  updateRecentViewedFav(pid, fav) {
    if (this._recentViewed.value) {
      let products = this._recentViewed.value;
      let proId = -1;
      this._recentViewed.value.forEach((each, i) => {
        if (each.pid == pid) {
          proId = i;
        }
      });
      if (proId > -1) {
        products[proId].isFavorite = fav;
        // this._recentViewed.next(products);
        this.storageService.storeString('recentlyViewedProducts', JSON.stringify(products));
        this.retrieveRecentViewed();
      }
    }
  }

  storeTempProducts(prod) {
    if (this._products.value) {
      let products = this._products.value;
      let prodInd = -1;
      products.forEach((each, i) => {
        if (each.pid == prod.pid) {
          prodInd = i;
        }
      });
      if (prodInd > -1) {
        products.splice(prodInd, 1, prod);
      } else {
        products.push(prod);
      }
      this._products.next(products);
    } else {
      this._products.next([prod]);
    }
  }

  localCheckProduct(pid): Observable<any> {
    if (this._recentViewed.value) {
      let prodExist = this._recentViewed.value.filter(each => each.pid == pid);
      if (prodExist.length) {
        this._product.next(prodExist[0]);
        return this._product.asObservable();
      }
      return this.product(pid);
    } else {
      return this.product(pid);
    }
  }

  product(pid) {
    return this.http.get<any>(
      `${this.serverUrl}category_products/product/${pid}/${this.token}`
    ).pipe(tap(res => {
      if (res) {
        this.storeRecentViewed(res);
        this.storeTempProducts(res);
      }
    }));
  }

  relatedProducts(pid, limit = 5, page = 1) {
    return this.http.get<any>(
      this.serverUrl + 'products/related/' + this.token + '/' + pid + '/' + limit + '/' + page
    );
  }

  product_single_user(pid) {
    return this.http.get<any>(
      this.serverUrl + 'products/userSingle/' + this.token + '/' + pid
    )
      .pipe(tap(resData => {
        if (resData) { this._product.next(resData); }
      }), delay(1000));
  }

  getAllDeals(page = 1, limit = 12) {
    // return this.http.get<any>()
  }

  getOtherProds(pageTitle, limit = 12, page = 1, sort = '', queryStr = '') {
    let cats = null;
    if (this._recentViewed.value) {
      let updCats = [];
      for (let cat of this._recentViewed.value) {
        let eachCat = cat.category.split(',')[0];
        if (!updCats.includes(eachCat)) {
          updCats.push(eachCat);
        }
      }
      cats = JSON.stringify(updCats);
    }
    return this.http.get<any>(
      `${this.serverUrl}all_deals/deals/${pageTitle}/${this.token}/${limit}/${page}/${sort}/${cats}${queryStr}`
    );
  }

  getCatProd(cat, page = 1, limit = 12, sort = '', queryStr = '') {
    return this.http.get<any>(
      `${this.serverUrl}category_products/${this.token}/${cat}/${limit}/${page}/${sort}${queryStr}`
    );
  }

}



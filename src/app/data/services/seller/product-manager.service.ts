import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, Subject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { ConfigService } from '../config.service';
import { SellerAuthService } from './seller-auth.service';

@Injectable({
  providedIn: 'root'
})
export class ProductManagerService {

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


  get getProduct(): Observable<any> {
    return this._product.asObservable();
  }

  get getURLstringVal(): Observable<any> {
    return this.subject.asObservable();
  }


  addProduct(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/add_pro_detail/${this.token}`, { data: postData }
    );
  }

  single(pid, url = null) {
    return this.http.get<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/single/${this.token}/${pid}/${url}`
    )
      .pipe(tap(resData => {
        if (resData) { this._product.next(resData); }
      }));
  }

  delete(pid) {
    return this.http.get<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/remove_product/${this.token}/${pid}`
    )
  }

  getProducts() {
    return this.http.get<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/${this.token}`,
    );
  }


  updatePricing(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/update_pricing/${this.token}`, { data: postData }
    );
  }



  updateShipping(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/update_shipping/${this.token}`, { data: postData }
    );
  }


  priceVariation(postData: string) {
    return this.http.post<any>(
      `${this.serverUrl}${this.sellerUrl}/product_manager/priceVariation/${this.token}`, { data: postData }
    );
  }

}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { tap } from 'rxjs/operators';
import { BehaviorSubject, of } from 'rxjs';
import { AdminAuthService } from '../admin-auth.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable({ providedIn: 'root' })
export class StaticContentService {
  private serverUrl: string;
  private token: string;
  private _contents = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private adminAuthService: AdminAuthService,
    private storageService: StorageService
  ) {
    this.serverUrl = this.config.base_url();
    this.adminAuthService.admin.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  retrieveContent(page) {
    if (this.storageService.hasKey(page)) {
      return of(JSON.parse(this.storageService.getString(page)));
    }
    return this.contents(page);
  }

  get retrieveAbout() {
    if (this.storageService.hasKey('aboutUs')) {
      return of(JSON.parse(this.storageService.getString('aboutUs')));
    }
    return this.aboutUs();;
  }

  get retrieveFaq() {
    if (this.storageService.hasKey('faq')) {
      return of(JSON.parse(this.storageService.getString('faq')));
    }
    return this.faq();
  }

  get retrieveSellerContent() {
    if (this.storageService.hasKey('sellerContent')) {
      return of(JSON.parse(this.storageService.getString('sellerContent')));
    }
    return this.sellerContent();
  }

  sellerContent() {
    return this.http.get<any>(
      `${this.serverUrl}content/seller_content`
    ).pipe(tap(res => {
      if (res) {
        this.storageService.storeString('sellerContent', JSON.stringify(res));
      }
    }));
  }

  contents(page) {
    return this.http.get<any>(
      `${this.serverUrl}content/single/${page}`
    ).pipe(tap(res => {
      if (res) {
        this.storageService.storeString(page, JSON.stringify(res));
      }
    }));
  }

  aboutUs() {
    return this.http.get<any>(
      `${this.serverUrl}content`)
      .pipe(tap(resData => {
        if (resData) {
          this.storageService.storeString('aboutUs', JSON.stringify(resData));
        }
      }));
  }

  faq() {
    return this.http.get<any>(
      `${this.serverUrl}content/faq`)
      .pipe(tap(resData => {
        if (resData) {
          this.storageService.storeString('faq', JSON.stringify(resData));
        }
      }));
  }

  updateContent(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'pages/update/' + this.token, { data: postData }
    );
  }

}

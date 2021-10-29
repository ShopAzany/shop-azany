import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import {take, tap, filter, delay } from 'rxjs/operators';
import { Subject, Observable, BehaviorSubject } from 'rxjs';

import { Category, SubCategory } from '../../model/category';
import { ConfigService } from '../config.service';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class SupportService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private adminAuthService: AdminAuthService,
  ) {
    this.serverUrl = this.config.base_url();
    this.adminUrl = this.config.adminURL;

    this.adminAuthService.admin.subscribe(auth => {
      if (auth) { this.token = auth.token; }
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

  open(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'support/create/', postData
    );
  }

  allRecords(limit = 15, page = 1) {
    return this.http.get<any>(this.serverUrl + 'support/' +
      this.token + '/' + limit + '/' + '/' + page
    );
  }

  delete(id) {
    return this.http.get<any>(
      this.serverUrl + 'support/delete/' + this.token + '/' + id
    );
  }

  single(id) {
    return this.http.get<any>(
      this.serverUrl + 'support/single/' + this.token + '/' + id
    );
  }


}

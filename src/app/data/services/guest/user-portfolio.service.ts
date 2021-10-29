import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';
import { UserPortfolio } from '../../model/user-portfolio';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class UserPortfolioService {
  private serverUrl: string;
  private token: string;
  private _portfolios = new BehaviorSubject<UserPortfolio>(null);

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

  // Get freelancer porfolio by login_id
  getPortfolios(loginID: number) {
    return this.http.get<UserPortfolio>(this.serverUrl + 'freelancer/portfolio/' + loginID)
    .pipe(
      tap(resData => {
        if (resData) {
          this._portfolios.next(resData);
        }
    }));
  }

  // Upload image first
  imgUpload(fileObj: any, title: string) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/portfolio/imgUpload/'
        + this.token + '/' + title, fileObj
      );
  }

  // Add
  add(postData: string, imgUrl: string) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/portfolio/add/' + this.token,
        {data: postData, url: imgUrl}
      );
  }

}

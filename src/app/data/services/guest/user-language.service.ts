import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';
import { UserLanguage } from '../../model/user-language';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class UserLanguageService {
  private serverUrl: string;
  private token: string;
  private _languagues = new BehaviorSubject<UserLanguage>(null);

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

  // Get freelancer languages by login_id
  getLanguages(loginID: number) {
    return this.http.get<UserLanguage>(
      this.serverUrl + 'freelancer/languages/' + loginID
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._languagues.next(resData);
        }
    }));
  }

  // Add user language
  updateLanguage(postData) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/language/add/' + this.token,
        { data: postData }
      );
  }

  // Delete user language
  deleteLanguage(langID: number) {
    return this.http
      .get<any>(
        this.serverUrl + 'user/language/delete/' + this.token + '/' + langID
      );
  }

}

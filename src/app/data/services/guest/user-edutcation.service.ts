import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';
import { UserEducation } from '../../model/user-education';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class UserEducationService {
  private serverUrl: string;
  private token: string;
  private _educations = new BehaviorSubject<UserEducation>(null);

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
  getEducations(loginID: number) {
    return this.http.get<UserEducation>(
      this.serverUrl + 'freelancer/education/' + loginID
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._educations.next(resData);
        }
    }));
  }

  // Add user education
  add(postData) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/education/add/' + this.token,
        { data: postData }
      );
  }

  // Edit user education
  edit(postData) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/education/edit/' + this.token,
        { data: postData }
      );
  }

  // delete user education
  delete(edutID: number) {
    return this.http
      .get<any>(
        this.serverUrl + 'user/education/delete/' + this.token + '/' + edutID
      );
  }

}

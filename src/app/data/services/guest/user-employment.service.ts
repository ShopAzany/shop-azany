import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';
import { UserEmployment } from '../../model/user-employment';
import { AuthService } from '../auth.service';

@Injectable({ providedIn: 'root' })
export class UserEmploymentService {
  private serverUrl: string;
  private token: string;
  private _employments = new BehaviorSubject<UserEmployment>(null);

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

  get employments() {
    return this._employments.asObservable();
  }

  // Get freelancer porfolio by login_id
  getEmployments(loginID: number) {
    return this.http.get<UserEmployment>(
      this.serverUrl + 'freelancer/experience/' + loginID
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._employments.next(resData);
        }
    }));
  }

  // Add
  add(postData) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/employment/add/' + this.token,
        { data: postData }
      );
  }

  // Edit
  edit(postData) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/employment/edit/' + this.token,
        { data: postData }
      );
  }

  // delete
  delete(edutID: number) {
    return this.http
      .get<any>(
        this.serverUrl + 'user/employment/delete/' + this.token + '/' + edutID
      );
  }

}

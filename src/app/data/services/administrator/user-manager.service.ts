import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject, Observable, Subject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class UserManagerService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;
  private _users = new BehaviorSubject<any>(null);
  private _user = new BehaviorSubject<any>(null);
  private subject = new Subject<any>();

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private adminAuthService: AdminAuthService
  ) {
    this.serverUrl = this.config.base_url();
    this.adminUrl = this.config.adminURL;
    this.adminAuthService.admin.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  get users() {
    return this._users.asObservable();
  }

  get user() {
    return this._user.asObservable();
  }

  getUsers(role = 'all', limit = 10, page = 1, sortBy = 'DESC') {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/user_manager/' +
      this.token + '/' + role + '/' + limit + '/' + page + '/' + sortBy
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._users.next(resData);
        }
    }));
  }

  search(keyword, limit = 10, page = 1, sortby = 'DESC') {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/user_manager/search/' +
      this.token + '/' + keyword + '/' + limit + '/' + page + '/' + sortby
    );
  }

  getUser(username: string) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/user_manager/single/' +
      this.token + '/' + username
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._user.next(resData);
        }
    }));
  }

  accountAction(userID: number, action: string) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/user_manager/accountActions/' +
      this.token + '/' + userID + '/' + action
    );
  }

  updateUser( msgData: string) {
    return this.http
      .post<any>(
        this.serverUrl + this.adminUrl + '/user_manager/updateUser/' +
        this.token, { data: msgData }
      );
  }

  loginAsUser(username: string) {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/user_manager/loginAsUser/' +
      this.token + '/' + username
    );
  }


  setStatus(status: string) {
    this.subject.next(status);
  }

  get getStatus(): Observable<any> {
    return this.subject.asObservable();
  }

}

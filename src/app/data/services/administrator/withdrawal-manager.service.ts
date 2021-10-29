import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { ConfigService } from '../config.service';
import { BehaviorSubject, Observable, Subject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class WithdrawalManagerService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;
  private _withdrawals = new BehaviorSubject<any>(null);
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

  get withdrawals() {
    return this._withdrawals.asObservable();
  }

  getWithdrawals(limit = 10, page = 1, sortBy = 'DESC') {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/withdrawal_manager/' +
      this.token + '/' + limit + '/' + page + '/' + sortBy
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._withdrawals.next(resData);
        }
    }));
  }

  search(keyword, limit = 10, page = 1, sortby = 'DESC') {
    return this.http.get<any>(
      this.serverUrl + this.adminUrl + '/user_manager/search/' +
      this.token + '/' + keyword + '/' + limit + '/' + page + '/' + sortby
    );
  }

  setStatus(status: string) {
    this.subject.next(status);
  }

  approveWithdrawal(id) {
    return this.http.get<any>(`${this.serverUrl}${this.adminUrl}/withdrawal_manager/approve/${this.token}/${id}`);
  }

  deleteWithdrawal(id) {
    return this.http.get<any>(`${this.serverUrl}${this.adminUrl}/withdrawal_manager/delete/${this.token}/${id}`);
  }

  get getStatus(): Observable<any> {
    return this.subject.asObservable();
  }

}

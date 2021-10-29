import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap, delay } from 'rxjs/operators';
import { BehaviorSubject, Subject, Observable } from 'rxjs';

import { ConfigService } from '../config.service';
import { Freelancers, User } from '../../model/user';
import { VisitorService } from '../visitor.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable({ providedIn: 'root' })
export class TopmostNotificationService {
  private serverUrl: string;
  private _notification = new BehaviorSubject(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private visitorService: VisitorService,
    private storageService: StorageService
  ) {
    this.serverUrl = this.config.base_url();
  }

  get notification() {
    return this._notification.asObservable();
  }

  clearNotification() {
    this._notification.next(null);
  }

  getNotification() {
    //http request would be made here;
    this._notification.next({ 
      message: `Sign up now to get courses for as low as $12.99 each. New users only.`, 
      bg: '#d4edda', 
      fg: '#155724', 
      actionCol: '#155724', 
      timeTo: '2021-05-23 12:30:23'
    });
  }

  // home() {
  //   return this.http.get<any>(this.serverUrl + 'home/popular');
  // }


}

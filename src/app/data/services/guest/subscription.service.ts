import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';

@Injectable({ providedIn: 'root' })
export class SubscriptionService {
  private serverUrl: string;
  private _skills = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService
  ) {
    this.serverUrl = this.config.base_url();
  }

  // Get all skills
  unsubscribe(email) {
    console.log(this.serverUrl);
    return this.http.get<any>(`${this.serverUrl}unsubscribe/${email}`);
  }

}

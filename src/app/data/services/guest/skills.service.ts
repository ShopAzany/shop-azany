import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { BehaviorSubject } from 'rxjs';

import { ConfigService } from '../config.service';

@Injectable({ providedIn: 'root' })
export class SkillsService {
  private serverUrl: string;
  private _skills = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService
  ) {
    this.serverUrl = this.config.base_url();
  }

  get skills() {
    return this._skills;
  }

  // Get all skills
  getSkills() {
    return this.http.get<any>(this.serverUrl + 'skills/')
    .pipe(
      tap(resData => {
        if (resData) {
          this._skills.next(resData);
        }
    }));
  }

}

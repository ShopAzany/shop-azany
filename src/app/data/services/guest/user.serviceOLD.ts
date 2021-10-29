import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap, delay } from 'rxjs/operators';
import { BehaviorSubject, Subject, Observable } from 'rxjs';

import { ConfigService } from '../config.service';
import { Freelancers, User } from '../../model/user';
import { VisitorService } from '../visitor.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable({ providedIn: 'root' })
export class UserService {
  private serverUrl: string;
  private _freelancers = new BehaviorSubject<Freelancers>(null);
  private _username = new BehaviorSubject<User>(null);
  private _userID = new BehaviorSubject<User>(null);
  private _recentActive = new BehaviorSubject<Freelancers>(null);
  private _searchResults = new BehaviorSubject<Freelancers>(null);
  private subject = new Subject<any>();

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private visitorService: VisitorService,
    private storageService: StorageService
  ) {
    this.serverUrl = this.config.base_url();
  }

  get searchResults() {
    return this._searchResults.asObservable();
  }

  // Get freelancers by category
  getFreelancers(
    category: string,
    subcategory: string = 'none',
    limit: number = 10,
    page: number = 1,
    token = '' // This is to avoid "Circular dependency detected" error
  ) {
    return this.http.get<any>(
      this.serverUrl + 'freelancers/' + category + '/' + subcategory
      + '/' + limit + '/' + page + '/' + token
    )
    .pipe(tap(resData => {
      if (resData) {
        this._freelancers.next(resData);
      }
    }), delay(1000));
  }

  // Get freelancers by keywords
  getSearchResults(
    keywords: string,
    limit: number = 10,
    page: number = 1
  ) {
    return this.http.get<any>(
      this.serverUrl + 'search/' + keywords + '/' + limit + '/' + page
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._searchResults.next(resData);
        }
    }),
    delay(1000)
    );
  }

  setSearchKeyword(keyword: string) {
    this.subject.next(keyword);
  }

  getSearchKeyword(): Observable<any> {
    return this.subject.asObservable();
  }

  // Get freelancer by username
  getFreelancer(username: string, token = null) {
    return this.http.get<User>(
      this.serverUrl + 'freelancer/' + username + '/' + token
    )
    .pipe(
      tap(resData => {
        if (resData) {
          this._username.next(resData);
        }
    }),
    delay(1000)
    );
  }

  // Get user by login_id
  getUser(loginID: number) {
    return this.http.get<User>(this.serverUrl + 'freelancer/user/' + loginID)
    .pipe(
      tap(resData => {
        if (resData) {
          this._userID.next(resData);
        }
    }));
  }

  // Get Recent active freelancers
  getRecent(limit: number = 4, page: number = 1 ) {
    return this.http.get<Freelancers>(this.serverUrl + 'freelancers/to_recent/' + '/' + limit + '/' + page + '/')
    .pipe(
      tap(resData => {
        if (resData) {
          this._recentActive.next(resData);
        }
    }));
  }
  

  isFreelancer(auth: User) {
    if ((auth.skills.length > 2) &&
      (auth.title.length > 5) &&
      (auth.category.length > 5) &&
      (
        auth.fee > 0 ||
        auth.month_fee > 0 ||
        auth.month_fee > 0
      )
    ) {
      return true;
    }
    return false;
  }

  isOnline(lastseen: Date) {
    const currentDate = new Date().getTime();
    const lastseenTime = new Date(lastseen).getTime();
    const minAgo = new Date(currentDate - 30 * 60000).getTime();
    if (lastseenTime > minAgo) {
      return 'isOnline';
    }
    return this.isIdle(lastseen);
  }

  private isIdle(lastseen: Date) {
    const currentDate = new Date().getTime();
    const lastseenTime = new Date(lastseen).getTime();
    const timeAgo = new Date(currentDate - 1440 * 60000).getTime();
    if (lastseenTime > timeAgo) {
      return 'isIdle';
    }
    return this.isOffline(lastseen);
  }

  private isOffline(lastseen: Date) {
    const currentDate = new Date().getTime();
    const lastseenTime = new Date(lastseen).getTime();
    const daysAgo = new Date(currentDate - 4321 * 60000).getTime();
    if (lastseenTime > daysAgo) {
      return 'isOffline';
    }
    return null;
  }

  viewUpdate(freelancerID: number, loginID = 0) {
    // grab user location details
    this.visitorService.userLocation.subscribe(resp => {
      // valid for record
      if (this.isViewed(freelancerID)) {
        const country = resp ? resp.country_name : null;
        return this.http.get<any>(
          this.serverUrl + 'freelancer/updateView/' +
          freelancerID + '/' + loginID + '/' + country
        ).subscribe(res => {
          this.storageService.storeString(
            'viewData', JSON.stringify(res)
          );
        });
      }
    });
    return null;
  }

  private isViewed(freelancerID: number) {
    const viewData = JSON.parse(
      this.storageService.getString('viewData')
    );

    if (viewData) {
      const currentDate = new Date().getTime();
      const nextUpdate = new Date(viewData.timeViewed + 180 * 60000).getTime();
      if (
        (currentDate > nextUpdate) ||
        // tslint:disable-next-line: radix
        (parseInt(viewData.FreelancerViewed) !== freelancerID)
      ) {
        return true; // record the same view again
      }
      return false; // the same view record is still active
    }
    return true; // Storage is empty, proceed to update
  }

  // Get Recent active freelancers
  guestUserProducts(loginID, limit = 6, page = 1 ) {
    return this.http.get<any>(
      this.serverUrl + 'freelancer/products' + '/' + loginID + '/' + limit + '/' + page + '/'
    );
  }
}

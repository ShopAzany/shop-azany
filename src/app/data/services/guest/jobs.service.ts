import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap, delay } from 'rxjs/operators';
import { BehaviorSubject, Subject, Observable } from 'rxjs';

import { ConfigService } from '../config.service';
import { JobsModel } from '../../model/jobs-model';
import { AuthService } from '../auth.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable({ providedIn: 'root' })
export class JobsService {
  private serverUrl: string;
  private token: string;
  private _jobs = new BehaviorSubject<JobsModel>(null);
  private _job = new BehaviorSubject<JobsModel>(null);
  private _jobCategories = new BehaviorSubject<any>(null);
  // private subject = new Subject<any>();
  private subject = new BehaviorSubject<string>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService,
    private storageService: StorageService
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  // Get all jobs
  getJobs(category = 'all-jobs', limit = 10, page = 1, token = '', sort = "DESC", queryStr = '') {
    return this.http.get<any>(
      `${this.serverUrl}jobs/${category}/${limit}/${page}/${token}/${sort}${queryStr}`
    )
      .pipe(
        tap(resData => {
          if (resData) {
            this._jobs.next(resData);
          }
        }), delay(1000));
  }

  searchJobs(keyword, category = 'all-jobs', limit = 10, page = 1, token = '', sort = "DESC", queryStr = '') {
    return this.http.get<any>(
      `${this.serverUrl}jobs/search/${category}/${limit}/${page}/${token}/${keyword}/${sort}${queryStr}`
    )
      .pipe(
        tap(resData => {
          if (resData) {
            this._jobs.next(resData);
          }
        }), delay(1000));
  }

  // Get User by login_id jobs
  getUserJobs(page: number = 1) {
    return this.http.get<any>(
      this.serverUrl + 'user/manage_job_post/' + this.token + '/' + page + '/'
    ).pipe(tap(resData => {
      if (resData) { this._jobs.next(resData); }
    }),
    /* delay( 1000 ) */);
  }

  // Get job single
  getJob(id: any, token = null) {
    return this.http.get<any>(this.serverUrl + 'jobs/single/' + id + '/' + token)
      .pipe(
        tap(resData => {
          if (resData) {
            this._job.next(resData);
          }
        }),
        /* delay(1000) */
      );
  }

  // Post or update job
  postORupdate(postData, attachment = '') {
    return this.http
      .post<any>(
        this.serverUrl + 'user/manage_job_post/postORupdate/' + this.token,
        { data: postData, attachment: attachment }
      )
      .pipe(tap(resData => {
        if (resData) { this._job.next(resData); }
      }),
        delay(1000));
  }



  reportAbuse(postData) {
    return this.http
      .post<any>(
        this.serverUrl + 'user/manage_job_post/report/' + this.token,
        postData
      );
  }

  likeJob(jobId) {
    return this.http
      .get<any>(
        `${this.serverUrl}user/manage_job_post/like/${this.token}/${jobId}`
      );
  }




  // action
  updateAction(jobID: number, action: string) {
    return this.http
      .get<JobsModel>(
        this.serverUrl +
        'user/manage_job_post/action/'
        + this.token + '/' + jobID + '/' + action
      );
  }

  // Count quotes per job
  getCountBYjobID(resquestID: number) {
    return this.http
      .get<number>(
        this.serverUrl + 'user/manage_job_post/action/' + resquestID + '/'
      );
  }

  // get job categories
  getJobCategories() {
    return this.http.get<any>(this.serverUrl + 'jobs/categories')
      .pipe(
        tap(resData => {
          if (resData) {
            this._jobCategories.next(resData);
          }
        }),
        delay(1000)
      );
  }

  get categories() {
    return this._jobCategories.asObservable();
  }

  setJobCategory(category: string) {
    this.subject.next(category);
  }

  get getJobCategory(): Observable<any> {
    return this.subject.asObservable();
  }
}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap, delay } from 'rxjs/operators';
import { BehaviorSubject, Subject, Observable } from 'rxjs';

import { ConfigService } from '../config.service';
import { JobsModel } from '../../model/jobs-model';
import { AuthService } from '../auth.service';
import { StorageService } from '../../helpers/storage.service';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class HomeSliderService {
  private serverUrl: string;
  private token: string;
  
  private _contents = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService,
    private adminAuthService: AdminAuthService,
    private storageService: StorageService
  ) {
    this.serverUrl = this.config.base_url();
    this.authService.user.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
    this.adminAuthService.admin.subscribe(auth => {
        if (auth) { this.token = auth.token; }
    });
  }

  
  get getSliders() {
    return this._contents;
  }

  sliders(role) {
    return this.http.get<any>(this.serverUrl + 'home_sliders/' + role);
  }

  slidersByAdmin(role: string) {
    return this.http.get<any>(
      this.serverUrl + 'home_sliders/byAdmin/' + this.token + '/' +  role
    );
  }

  addSlide(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'home_sliders/add/' + this.token,
      {data: postData}
    );
  }

  edit(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'home_sliders/edit/' + this.token,
      {data: postData}
    );
  }

  singleSlide(id) {
    return this.http.get<any>(
      this.serverUrl + 'home_sliders/single/' + this.token + '/' + id
    );
  }

  delete(id) {
    return this.http.get<any>(
      this.serverUrl + 'home_sliders/delete/' + this.token + '/' + id
    );
  }

//   updateHomeBanner(postData: string) {
//     return this.http.post<any>(
//       this.serverUrl + 'sliders/edit_home_banner/' + this.token,
//       {data: postData}
//     );
//   }
}

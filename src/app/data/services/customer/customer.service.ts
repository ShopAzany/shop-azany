import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { ConfigService } from '../config.service';

@Injectable({
  providedIn: 'root'
})
export class CustomerService {

  private serverUrl: string;
  private token: string;
  private _addresses = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private authService: AuthService
  ) { 
    this.serverUrl = this.config.base_url();
    this.authService.customer.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
   }



  updateProfile(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'user/account_settings/updateProfile/' + this.token,
      {data: postData}
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.authService.storeAuthData(res.data);
      }
    }));
  }
  
  changePassword(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'user/account_settings/change_password/' + this.token,
      {data: postData}
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.authService.storeAuthData(res.data);
      }
    }));
  }
  
  
  tokenForEmail(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'user/account_settings/verifyEmailToken/' + this.token,
      {data: postData}
    ).pipe(tap(res => {
      if (res && res.status == 'success') {
        this.authService.storeAuthData(res.data);
      }
    }));
  }

  changeEmail(postData: any) {
    return this.http.post<any>(
      this.serverUrl + 'user/account_settings/updateProfile/' + this.token,
      {data: postData}
    );
  }
}

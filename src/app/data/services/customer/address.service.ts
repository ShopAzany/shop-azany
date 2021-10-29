import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { ConfigService } from '../config.service';

@Injectable({
  providedIn: 'root'
})
export class AddressService {

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

  get getAddresses() {
    return this._addresses.asObservable();
  }

  addresses() {
    return this.http.get<any>(
      this.serverUrl + 'user/address/' + this.token
    ).pipe(tap(resData => {
      if (resData) {
        this._addresses.next(resData);
      }
    }));
  }

  address(id) {
    return this.http.get<any>(
      this.serverUrl + 'user/address/single/' + this.token + '/' + id
    );
  }
  
  defaulAdd() {
    return this.http.get<any>(
      this.serverUrl + 'user/address/defaulAdd/' + this.token
    );
  }

  add(postData) {
    return this.http.post<any>(
        this.serverUrl + 'user/address/add/' + this.token,
        { data: postData }
    );
  }

  edit(postData) {
    return this.http.post<any>(
        this.serverUrl + 'user/address/edit/' + this.token,
        { data: postData }
    );
  }

  setDefault(id) {
    return this.http.get<any>(
      this.serverUrl + 'user/address/setDefault/' + this.token + '/' + id
    );
  }

  delete(id) {
    return this.http.get<any>(
      this.serverUrl + 'user/address/delete/' + this.token + '/' + id
    );
  }
}

import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { tap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { ConfigService } from '../config.service';

@Injectable({
  providedIn: 'root'
})
export class ManagerService {

  private serverUrl: string;
  private token: string;
  private _manager = new BehaviorSubject<any>(null);

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

  get getManager() {
    return this._manager.asObservable();
  }

  managers() {
  }

  manager(id) {

  }

  defaulAdd() {

  }

  add(postData) {

  }

  edit(postData) {

  }
  
  setDefault(id) {

  }

  delete(id) {

  }
}

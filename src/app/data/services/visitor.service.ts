import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { Observable, BehaviorSubject, of } from 'rxjs';
import { StorageService } from '../helpers/storage.service';
import { ConfigService } from './config.service';
import { GeneralSettingsService } from './general-settings.service';

@Injectable({ providedIn: 'root' })
export class VisitorService {
  serverUrl: string;
  private _locationData = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private storageService: StorageService,
    private generalSettingsService: GeneralSettingsService,
  ) {
    this.generalSettingsService.genSettings.subscribe(res => {
      if (res) {
        this._locationData.next(res.visitorData);
      }
    })
    this.serverUrl = this.config.base_url();
  }

  get userLocation (): Observable<any> {
    return this._locationData.asObservable();
  }

}

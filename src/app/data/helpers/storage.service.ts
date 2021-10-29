import { isPlatformBrowser } from '@angular/common';
import { Inject, Injectable, PLATFORM_ID } from '@angular/core';
import { CookieManagerService } from '../services/cookie-manager.service';

@Injectable({ providedIn: 'root' })
export class StorageService {

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private cookieManagerService: CookieManagerService) { }

  storeString(key: string, value: string) {
    if (isPlatformBrowser(this.platformId)) {
      localStorage.setItem(key, value);
      if (key == 'userData') {
        this.cookieManagerService.setStringCookies(key, value);
      }
    }
  }

  hasKey(key: string) {
    return isPlatformBrowser(this.platformId) ? !!localStorage.getItem(key) : this.cookieManagerService.hasKey(key);
  }

  getString(key: string) {
    return isPlatformBrowser(this.platformId) ? localStorage.getItem(key) : this.cookieManagerService.getStringCookie(key);
  }

  remove(key: string) {
    if (isPlatformBrowser(this.platformId)) {
      localStorage.removeItem(key);
    }
    this.cookieManagerService.removeCookieString(key);
  }
}

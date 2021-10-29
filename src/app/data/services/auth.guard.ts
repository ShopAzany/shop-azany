import { CanLoad, NavigationCancel, NavigationEnd, Route, RouterEvent, UrlSegment } from '@angular/router';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, of, timer } from 'rxjs';
import { take, switchMap, tap } from 'rxjs/operators';

import { AuthService } from './auth.service';
import { RoutingService } from '../helpers/routing.service';
import { StorageService } from '../helpers/storage.service';

@Injectable()
export class AuthGuard implements CanLoad {
  constructor(
    private authService: AuthService,
    private router: Router,
    private routingService: RoutingService,
    private storageService: StorageService,
  ) { }

  canLoad(
    route: Route,
    segments: UrlSegment[]
  ): Observable<boolean> | Promise<boolean> | boolean {
    return this.authService.customer.pipe(
      take(1),
      switchMap(currentUser => {
        if (!currentUser) {
          this.router.events.subscribe(event => {
            if (event instanceof NavigationCancel) {
              if (!currentUser) {
                this.storageService.storeString('returnUrl', event.url);
              }
            }
          });
          return this.authService.autoLogin();
        }
        return of(true);
      }),
      tap(isAuth => {
        this.checkToken();
        if (!isAuth) {
          this.router.navigate(['/login']);
        }
      })
    );
  }

  private checkToken() {
    this.authService.customer.subscribe(resp => {
      if (resp && resp.token) {
        const currentDate = new Date().getTime();
        const tokenDate = new Date(resp.exp).getTime();
        if (tokenDate > currentDate) {
          return true;
        } else {
          // this.authService.logout();
          return false;
        }
      } else {
        // this.authService.logout();
        return false;
      }
    });
  }

}

import { ActivatedRouteSnapshot, CanActivate, CanLoad, NavigationCancel, NavigationEnd, Route, RouterEvent, RouterStateSnapshot, UrlSegment } from '@angular/router';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, of, timer } from 'rxjs';
import { take, switchMap, tap } from 'rxjs/operators';

import { SellerAuthService } from './seller-auth.service';
import { RoutingService } from '../../helpers/routing.service';
import { StorageService } from '../../helpers/storage.service';

@Injectable()
export class SellerAuthGuard implements CanLoad {
  constructor(
    private authService: SellerAuthService,
    private router: Router,
    private routingService: RoutingService,
    private storageService: StorageService,
  ) { }

  canLoad(
    route: Route,
    segments: UrlSegment[]
  ): Observable<boolean> | Promise<boolean> | boolean {
    return this.authService.seller.pipe(
      switchMap(isAuth => {
        if (!isAuth) {
          this.router.events.subscribe(event => {
            console.log(event);
            if (event instanceof NavigationCancel) {
              if (!isAuth) {
                this.storageService.storeString('returnUrl', event.url);
              }
            }
          });
          this.router.navigate(['/seller/login']);
          return of(false);
        }
        if (isAuth.biz_info_status == 0) {
          this.router.navigateByUrl('/seller/register/business-info');
          return of(false);
        } else if (isAuth.bank_info_status == 0) {
          this.router.navigateByUrl('/seller/register/additional-info');
          return of(false);
        }
        return of(true);
      }),
    );
  }

  private checkToken() {
    this.authService.seller.subscribe(isAuth => {
      if (!isAuth) {
        this.router.navigate(['/seller/login']);
      } else {
        if (isAuth.biz_info_status == 0) {
          this.router.navigateByUrl('/seller/register/business-info');
        } else if (isAuth.bank_info_status == 0) {
          this.router.navigateByUrl('/seller/register/additional-info');
        }
      }
    });
  }

}

import { Component, OnInit, NgZone, Input, Inject, PLATFORM_ID, Output, EventEmitter } from '@angular/core';
import { Router } from '@angular/router';
import { RoutingService } from '../../../data/helpers/routing.service';
import { AuthService } from '../../../data/services/auth.service';
import { StorageService } from '../../../data/helpers/storage.service';
import { isPlatformBrowser } from '@angular/common';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-fb-login',
  templateUrl: './fb-login.component.html',
  styleUrls: ['./fb-login.component.scss']
})
export class FbLoginComponent implements OnInit {
  @Input() page: string;
  @Input() refUsername;
  @Output() sellerLogoutEv = new EventEmitter();
  sellerAuth;

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private routingService: RoutingService,
    private router: Router,
    private ngZone: NgZone,
    private authService: AuthService,
    private storageService: StorageService,
    private guestHomeService: GuestHomeService,
    private shoppinCartService: ShoppingCartService,
  ) { }

  ngOnInit() {
    if (isPlatformBrowser(this.platformId)) {
      this.fbLibrary();
    }
  }

  logInWithFacebook() {
    window['FB'].login((response) => {
      if (response.authResponse) {
        window['FB'].api('/me', {
          fields: 'id,first_name,last_name,email,link,gender,locale,picture'
        }, (userInfo) => {
          const fbProfile = {
            'provider': 'facebook',
            'id_token': userInfo.id,
            'email': userInfo.email,
            'first_name': userInfo.first_name,
            'last_name': userInfo.last_name,
            'picture': userInfo.picture.data.url,
            'refUsername': this.refUsername,
          };
          const data = JSON.stringify(fbProfile);
          this.authService.socialLogin(data).subscribe(resp => {
            if (resp && resp.status == 'failed') {
              this.storageService.storeString('SocialUser', data);
              this.redirectTo('/register');
            } else if (resp && resp.login_id) {
              this.sellerLogoutEv.emit();
              this.guestHomeService.getOtherData().subscribe();
              this.shoppinCartService.shoppingCart().subscribe();
              this.redirectTo('/customer');
            } else {
            }
          });
        });
      } else {
        console.log('User login failed');
      }
    },
      { scope: 'email' });
  }

  private redirectTo(url: string) {
    // this.routingService.replace([url]);
    this.ngZone.run(() => this.router.navigate([url])).then();
  }

  private fbLibrary() {
    (window as any).fbAsyncInit = function () {
      window['FB'].init({
        appId: '996914964208454',
        cookie: true,
        xfbml: true,
        version: 'v3.1'
      });
      window['FB'].AppEvents.logPageView();
    };

    (function (d, s, id) {
      // tslint:disable-next-line: prefer-const
      let js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) { return; }
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  }

}

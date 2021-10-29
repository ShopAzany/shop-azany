
import { Component, OnInit, NgZone, AfterViewInit, Input, Output, EventEmitter, Inject, PLATFORM_ID } from '@angular/core';
import { Router } from '@angular/router';
import { RoutingService } from '../../../data/helpers/routing.service';
import { AuthService } from '../../../data/services/auth.service';
import { StorageService } from '../../../data/helpers/storage.service';
import { isPlatformBrowser } from '@angular/common';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';
// import { JobsService } from 'src/app/data/services/guest/jobs.service';

@Component({
  selector: 'app-google-login',
  templateUrl: './google-login.component.html',
  styleUrls: ['./google-login.component.scss']
})

export class GoogleLoginComponent implements OnInit, AfterViewInit {
  @Input() page: string;
  @Input() refUsername;
  @Output() sellerLogoutEv = new EventEmitter();
  isClciked = false;
  sellerAuth;

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private routingService: RoutingService,
    private router: Router,
    private ngZone: NgZone,
    private authService: AuthService,
    private storageService: StorageService,
    private guestHomeService: GuestHomeService,
    private shoppingCartService: ShoppingCartService,
  ) { }

  ngOnInit() {
  }


  ngAfterViewInit() {
    if (isPlatformBrowser(this.platformId)) {
      setTimeout(() => {
        this.ngZone.run(() => {
          window['gapi'].signin2.render('my-signin2', {
            'scope': 'profile email',
            'width': 453,
            'height': 77,
            'longtitle': true,
            'theme': 'light',
            'onsuccess': param => this.onSignIn(param)
          });
        });
      });
    }
  }

  onSignIn(googleUser) {
    // if (this.isClciked) {
    const profile = googleUser.getBasicProfile();
    const id_token = googleUser.getAuthResponse().id_token;
    const gProfile = {
      'provider': 'google',
      'id_token': id_token,
      'email': profile.getEmail(),
      'first_name': profile.getGivenName(),
      'last_name': profile.getFamilyName(),
      'picture': profile.getImageUrl(),
      'refUsername': this.refUsername,
    };
    this.gLoginVerify(gProfile);
    // }
  }

  googleLogin() {
    this.isClciked = true;
  }

  private gLoginVerify(profile) {
    const data = JSON.stringify(profile);
    this.authService.socialLogin(data).subscribe(resp => {
      if (resp && resp.provider === 'google') {
        this.storageService.storeString('SocialUser', JSON.stringify(resp));
      } else if (resp && resp.login_id) {
        this.sellerLogoutEv.emit();
        this.shoppingCartService.shoppingCart().subscribe();
        this.guestHomeService.getOtherData();
        this.redirectTo('/customer');
      } else {
        console.log(resp);
      }
    });
    this.isClciked = false;
  }



  private redirectTo(url: string) {
    // this.routingService.replace([url]);
    this.ngZone.run(() => this.router.navigate([url])).then();
  }
}

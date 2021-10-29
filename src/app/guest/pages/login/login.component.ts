import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/data/services/auth.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  @ViewChild('errorEL') authError: ElementRef;

  isSubmitting = false;
  authErrorMssg: any;
  sellerAuth;

  form = new FormGroup({
    user: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required])
  });

  get user() {
    return this.form.get('user');
  }

  get password() {
    return this.form.get('password');
  }

  constructor(
    private authService: AuthService,
    private sellerAuthService: SellerAuthService,
    private router: Router,
    private shoppingCart: ShoppingCartService,
    private guestHomeService: GuestHomeService,
  ) { }

  ngOnInit(): void {
    this.checkAuth();
    this.checkSellerAuth();
  }

  private checkSellerAuth() {
    this.sellerAuthService.seller.subscribe(auth => {
      this.sellerAuth = auth;
    })
  }

  logoutSeller() {
    this.sellerAuthService.logoutAlt();
  }

  private checkAuth() {
    this.authService.customer.subscribe(auth => {
      if (auth) {
        this.router.navigateByUrl('/customer');
      }
    });
  }

  submit() {
    this.isSubmitting = true;
    const username = this.form.value.user;
    const password = this.form.value.password;
    this.authService.login(username, password).subscribe(res => {
      if (res && res.login_id) {
        this.authError = null;
        if (this.sellerAuth) {
          this.logoutSeller();
        }
        this.shoppingCart.shoppingCart().subscribe();
        this.guestHomeService.getOtherData().subscribe();
        this.router.navigateByUrl('/customer');
      } else {
        this.authErrorMssg = res;
        this.isSubmitting = false;
        this.authError.nativeElement.scrollIntoView();
      }
      this.isSubmitting = false;
    },
      err => {
        console.log(err);
        this.isSubmitting = false;
      });
  }

}

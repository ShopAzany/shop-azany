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
  isLogginin = false;
  form = new FormGroup({
    user: new FormControl('', Validators.required),
    password: new FormControl('', Validators.required)
  });
  @ViewChild('userEl') userEl: ElementRef;
  @ViewChild('passEl') passEl: ElementRef;

  userServerErr;
  passwordServerErr;
  customerAuth;

  get user() {
    return this.form.get('user');
  }
  get password() {
    return this.form.get('password');
  }

  constructor(
    private authService: SellerAuthService,
    private customerAuthService: AuthService,
    private guestHomeService: GuestHomeService,
    private shoppingCartService: ShoppingCartService,
    private router: Router
  ) { }

  ngOnInit(): void {
    this.checkAuth();
    this.getCustomerAuth();
  }

  private checkAuth() {
    this.authService.seller.subscribe(auth => {
      if (auth) {
        this.router.navigateByUrl('/seller/auth');
      }
    });
  }

  private getCustomerAuth() {
    this.customerAuthService.customer.subscribe(auth => {
      this.customerAuth = auth;
    })
  }

  submit() {
    this.isLogginin = true;
    this.userServerErr = null;
    this.passwordServerErr = null;
    const data = JSON.stringify(this.form.value);
    this.authService.login(data).subscribe(res => {
      if (res) {
        if (res.status == 'success') {
          if (this.customerAuth) {
            this.customerAuthService.logoutAlt();
            this.shoppingCartService.shoppingCart().subscribe();
            this.guestHomeService.getOtherData().subscribe();
          }
          //this.router.navigateByUrl('/seller/auth');
          console.log("success");
        } else {
          if (res.data.toLowerCase().includes('record') || res.data.toLowerCase().includes('blocked')) {
            this.userServerErr = res.data;
            this.userEl.nativeElement.scrollIntoView();
          } else {
            this.passwordServerErr = res.data;
            this.passEl.nativeElement.scrollIntoView();
          }
        }
      }
      this.isLogginin = false;
    });
  }

}

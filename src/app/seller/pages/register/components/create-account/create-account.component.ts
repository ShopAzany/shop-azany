import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { StorageService } from 'src/app/data/helpers/storage.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-create-account',
  templateUrl: './create-account.component.html',
  styleUrls: ['./create-account.component.scss']
})
export class CreateAccountComponent implements OnInit {

  @ViewChild('emailEl') emailGroup: ElementRef;
  @ViewChild('phoneEl') phoneGroup: ElementRef;

  emailServerError;
  phoneServerError;

  agreement = false;
  isSubmitting = false;

  form = new FormGroup({
    first_name: new FormControl('', [
      Validators.required
    ]),
    last_name: new FormControl('', [
      Validators.required
    ]),
    email: new FormControl('', [
      Validators.required
    ]),
    country_code: new FormControl('', [Validators.required]),
    phone: new FormControl('', [
      Validators.required
    ]),
    password: new FormControl('', [
      Validators.required,
      Validators.minLength(8)
    ]),
    retPass: new FormControl('', [
      Validators.required,
    ]),
  });

  constructor(
    private route: Router,
    private authService: SellerAuthService,
    private countryService: CountryService,
    private storageService: StorageService,
  ) { }

  ngOnInit(): void {
    this.checkAuth();
  }

  private checkAuth() {
    this.authService.seller.subscribe(auth => {
      if (auth) {
        if (auth.biz_info_status == 0) {
          this.route.navigateByUrl('/seller/register/business-info');
        } else if (auth.bank_info_status == 0) {
          this.route.navigateByUrl('/seller/register/additional-info');
        } else {
          this.route.navigateByUrl('/seller/auth');
        }
      }
    });
  }

  get firstName() {
    return this.form.get('first_name');
  }
  get lastName() {
    return this.form.get('last_name');
  }
  get email() {
    return this.form.get('email');
  }
  get phone() {
    return this.form.get('phone');
  }
  get password() {
    return this.form.get('password');
  }
  get retPass() {
    return this.form.get('retPass');
  }
  get countryCode() {
    return this.form.get('country_code');
  }

  get validateEmail() {
    if (this.email.valid) {
      if (this.email.value.match(/^[^a-z]/i)) return false;
      let match = this.email.value.match(/[a-z0-9]+[-_\.]{0,1}[a-z0-9]+@[a-z]+\.[a-z]{2,}(?!.)/i);
      return match ? true : false;
    }
    return false;
  }

  get invalidCountryCode() {
    if (this.countryCode.touched && this.countryCode.valid) {
      let countryMatch = this.countryService.getCountryWithDialing(this.countryCode.value);
      if (countryMatch.length) {
        return false;
      }
      return true;
    }
    return false;
  }

  get passMismatch() {
    return this.retPass?.valid && this.password.value != this.retPass.value ? true : false;
  }

  submit() {
    this.emailServerError = null;
    this.phoneServerError = null;
    this.isSubmitting = true;
    delete this.form.value.retPass;
    const data = JSON.stringify(this.form.value);
    this.authService.signup(data).subscribe(res => {
      if (res.status) {
        if (res.status == 'success') {
          this.route.navigateByUrl('/seller/register/business-info');
        } else {
          if (res.data.toLowerCase().includes('email')) {
            this.emailServerError = res.data;
            this.emailGroup.nativeElement.scrollIntoView();
          } else {
            this.phoneServerError = res.data;
            this.phoneGroup.nativeElement.scrollIntoView();
          }
        }
      }
      this.isSubmitting = false;
    });
  }

}

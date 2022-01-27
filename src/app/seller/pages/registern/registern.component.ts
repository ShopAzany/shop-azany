import { Country } from './../../../data/model/country';
import { Component, ElementRef, OnInit, ViewChild, Input } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router, ActivatedRoute, RouterStateSnapshot } from '@angular/router';
import { StorageService } from 'src/app/data/helpers/storage.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';
import { CookieService } from 'ngx-cookie';
import { UserService } from 'src/app/data/services/guest/user.service';

@Component({
  selector: 'app-registern',
  templateUrl: './registern.component.html',
  styleUrls: ['./registern.component.scss']
})
export class RegisternComponent implements OnInit {

  @ViewChild('emailEl') emailGroup: ElementRef;
  @ViewChild('phoneEl') phoneGroup: ElementRef;

  //public p: string;
  Country;
  plan;
  auth;
  private cookieValue: string;

  emailServerError;
  phoneServerError;
  countries;
  code;

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
    password: new FormControl('', [
      Validators.required,
      Validators.minLength(8)
    ]),
    phone: new FormControl('', [
      Validators.required
    ]),
    store_name: new FormControl('', [
      Validators.required
    ]),
    country: new FormControl(this.routee.snapshot.paramMap.get('country'), [
      Validators.required
    ]),
    country_code: new FormControl(this.lookCountryCode(), [Validators.required]),
    retPass: new FormControl('', [
      Validators.required,
    ]),
    payment_plan: new FormControl(this.routee.snapshot.paramMap.get('plan'), [
      Validators.required,
    ]
    ),
  });

  @Input() activeLink;

  constructor(
    private route: Router, 
    private routee: ActivatedRoute,
    private authService: SellerAuthService,
    private countryService: CountryService,
    private storageService: StorageService,
    private CookieService: CookieService,
    private userService: UserService
  ) { }

  countriesList: any;

  ngOnInit() {
    // this.lookCountryCode();
    // this.checkAuth();
    // this.checkPlan();
    // this.checkCountry();
    // this.countries = this.countryService.getCountries();
    // this.lookCountryCode();

    this.userService.getVendorCountries().subscribe(
      (data: any) => {
        this.countries = data.data;
      }
    );
  }

  private checkPlan() {
    // this.plan = this.routee.snapshot.paramMap.get('plan');
    //console.log(this.plan);
  }
  private checkCountry() {
    // this.Country = this.routee.snapshot.paramMap.get('country');
  }
  private lookCountryCode() {
    // var code = this.countryService.getCountry(this.routee.snapshot.paramMap.get('country')).dailing;
    // return code;
  }

  /*private checkAuth() {
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
  }*/

  private checkAuth() {
    this.authService.seller.subscribe(auth => {
      if (auth) {
        this.route.navigateByUrl('/seller/auth');
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
  get password() {
    return this.form.get('password');
  }
  get phone() {
    return this.form.get('phone');
  }
  get country() {
    return this.form.get('country');
  }
  get storeName() {
    return this.form.get('store_name');
  }
  get retPass() {
    return this.form.get('retPass');
  }
  get countryCode() {
    return this.form.get('country_code');
  }
  get planName() {
    return this.form.get('payment_plan');
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
    const data = JSON.stringify(this.form.value);
    this.isSubmitting = true;
    this.userService.registerSeller(data).subscribe(
      (data) => {
        window.localStorage.setItem('email', this.form.value.email);
        this.route.navigateByUrl('/seller/verify');
      },
      (error) => {
        this.isSubmitting = false;
        if (error.status == 422) {
          this.emailServerError = error.error.errors.email;
          this.phoneServerError = error.error.errors.phone;
        }
      }
    );
  }

}
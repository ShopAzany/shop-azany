import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { BehaviorSubject } from 'rxjs';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { DashboardService } from 'src/app/data/services/seller/dashboard.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
  countries
  isSaving = false;
  emailServerError;
  phoneServerError;
  totalSales = 0;
  totalWishList = 0;
  totalActiveProducts = 0;
  totalInactiveProducts = 0;
  totalRevenue = 0;
  totalProductsSold = 0;
  totalCustomers = 0;
  infoLoading = true;
  currency;
  durationObj = { txt: 'Daily', value: 'days' };
  optionLoading = false;
  rawData = [
    [], []
    // [
    //   {
    //     created_at: '2021-08-06 03:21:03',
    //     product_name: 'product 1',
    //     quantity: 1
    //   },
    //   {
    //     created_at: '2021-08-06 03:21:03',
    //     product_name: 'product 1',
    //     quantity: 1
    //   },
    //   {
    //     created_at: '2021-08-06 03:21:03',
    //     product_name: 'product 1',
    //     quantity: 1
    //   },
    //   {
    //     created_at: '2021-08-09 03:21:03',
    //     product_name: 'product 1',
    //     quantity: 1
    //   },
    //   {
    //     created_at: '2021-08-10 03:21:03',
    //     product_name: 'product 1',
    //     quantity: 1
    //   },
    // ],
    // [
    //   {
    //     created_at: '2021-08-06 03:21:03',
    //     product_name: 'product 1',
    //   },
    //   {
    //     created_at: '2021-08-07 03:21:03',
    //     product_name: 'product 1',
    //   },
    //   {
    //     created_at: '2021-08-09 03:21:03',
    //     product_name: 'product 1',
    //   },
    // ],
  ];

  graphData = [];

  revenuGraph = [];
  customerGraph = [];

  closeModal = new BehaviorSubject<boolean>(false);

  auth;

  fullNameForm = new FormGroup({
    first_name: new FormControl('', Validators.required),
    last_name: new FormControl('', Validators.required),
  });
  bizTypeForm = new FormGroup({
    biz_type: new FormControl('', Validators.required),
  });
  bizNameForm = new FormGroup({
    biz_name: new FormControl('', Validators.required),
  });
  emailForm = new FormGroup({
    email: new FormControl('', Validators.required),
  });
  phoneForm = new FormGroup({
    phone: new FormControl('', Validators.required),
    country_code: new FormControl('', Validators.required),
  });
  bizAddrForm = new FormGroup({
    biz_address: new FormControl('', Validators.required),
  });
  bizCityForm = new FormGroup({
    city: new FormControl('', Validators.required),
  });
  bizRegNumForm = new FormGroup({
    biz_reg_number: new FormControl('', Validators.required),
  });
  get firstName() {
    return this.fullNameForm.get('first_name');
  }
  get lastName() {
    return this.fullNameForm.get('last_name');
  }
  get bizType() {
    return this.bizTypeForm.get('biz_type');
  }
  get bizName() {
    return this.bizNameForm.get('biz_name');
  }
  get bizAddress() {
    return this.bizAddrForm.get('biz_address');
  }
  get city() {
    return this.bizCityForm.get('city');
  }
  get bizReg() {
    return this.bizRegNumForm.get('biz_reg_number');
  }
  get email() {
    return this.emailForm.get('email');
  }
  get countryCode() {
    return this.phoneForm.get('country_code');
  }
  get phone() {
    return this.phoneForm.get('phone');
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
  get countryIso() {
    let country = this.countryService.getCountryWithDialing(this.countryCode.value);
    if (country.length) {
      return country[0].iso.toLowerCase();
    }
    return null;
  }
  constructor(
    private countryService: CountryService,
    private authService: SellerAuthService,
    private dashboardService: DashboardService,
    private generalSettings: GeneralSettingsService,
  ) { }

  ngOnInit(): void {
    this.countries = this.countryService.getCountries();
    this.getAuth();
    this.getDashboardInfo();
    this.getCurrency();
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    });
  }

  setDuration(el, value) {
    if (value == this.durationObj.value) return;
    this.optionLoading = true;
    this.durationObj = { txt: el.innerHTML, value: value };
    this.getDashboardInfo();
    // setTimeout(() => {
    //   this.optionLoading = false;
    // }, 1000);
  }

  private getDashboardInfo() {
    this.dashboardService.dashboardInfo(this.durationObj.value).subscribe(res => {
      // console.log(res);
      if (res) {
        this.rawData = [res.lastSevenDayWish, res.lastSevenDayOrder];
        this.totalSales = res.lastSevenSold;
        this.totalWishList = res.lastSevenWishCount;
        this.totalActiveProducts = res.totalProductActive;
        this.totalInactiveProducts = res.totalProductInactive;
        this.totalRevenue = res.totalRevenue;
        this.totalProductsSold = res.last30DaySold;
        this.totalCustomers = res.totalCustomer;
        this.revenuGraph = res.last30DayProductSold;
        this.customerGraph = res.listOfCustomers;
      }
      this.infoLoading = false;
      this.optionLoading = false;
    });
  }

  private getAuth() {
    this.authService.seller.subscribe(auth => {
      this.auth = auth;
      if (this.auth) {
        this.initiateFormValues();
      }
    });
  }

  private initiateFormValues() {
    const bizInfo = this.auth.biz_info;
    this.bizName.setValue(bizInfo.biz_name);
    this.bizAddress.setValue(bizInfo.biz_address);
    this.bizReg.setValue(bizInfo.biz_reg_number);
    this.bizType.setValue(bizInfo.biz_type);
    this.city.setValue(bizInfo.city);

    this.email.setValue(this.auth.email);
    this.firstName.setValue(this.auth.first_name);
    this.lastName.setValue(this.auth.last_name);
    this.phone.setValue(this.auth.phone);
    this.countryCode.setValue(this.auth.country_code);
  }

  setCountryCode(i) {
    this.countryCode.setValue(this.countries[i].dailing);
  }

  submit(fg, personal) {
    this.isSaving = true;
    const data = JSON.stringify(fg.value);
    if (personal) {
      this.authService.updateProfile(data).subscribe(res => {
        if (res) {
          if (res.status == 'success') {
            this.closeModal.next(true);
          } else {

          }
        }
        this.isSaving = false;
      });
    } else {
      this.authService.updateBizInfo(data).subscribe(res => {
        if (res) {
          if (res.status == 'success') {
            this.closeModal.next(true);
          }
        }
        this.isSaving = false;
      })
    }
  }

}

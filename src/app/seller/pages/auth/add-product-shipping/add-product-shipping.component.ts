import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { CurrencyService } from 'src/app/data/services/currency.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { ProductManagerService } from 'src/app/data/services/seller/product-manager.service';

@Component({
  selector: 'app-add-product-shipping',
  templateUrl: './add-product-shipping.component.html',
  styleUrls: ['./add-product-shipping.component.scss']
})
export class AddProductShippingComponent implements OnInit {
  lastRoute;
  product: any;
  titleUrl: any;
  countries: any;
  isSubmitting = false;
  currency;

  form = new FormGroup({
    pid: new FormControl(''),
    pro_location_country: new FormControl(null),
    pro_location_state: new FormControl(''),
    shipping_fee: new FormControl('', Validators.required),
    shipping_method: new FormControl('', Validators.required),
    allow_shipping_outside: new FormControl(''),
  });

  constructor(
    private productManagerService: ProductManagerService,
    private routingService: RoutingService,
    private configService: ConfigService,
    private countryService: CountryService,
    private route: ActivatedRoute,
    private generalSettingsService: GeneralSettingsService,
    private guestHomeService: GuestHomeService,
  ) { }

  get shipping_fee() {
    return this.form.get('shipping_fee');
  }

  get shipping_method() {
    return this.form.get('shipping_method');
  }

  get sellerUrl() {
    return this.configService.sellerURL;
  }

  ngOnInit(): void {
    const proID = this.route.snapshot.paramMap.get('pid');
    this.lastRoute = this.routingService.activeRoute;
    if (proID) {
      this.getProduct(proID);
    } else {
      this.routingService.replace([
        '/' + this.sellerUrl + '/product-manager'
      ]);
    }
    this.getProduct(proID);
    this.getCountry();
    this.getCurrency();

  }


  private getCountry() {
    this.countries = this.countryService.getCountries();
  }
  private getCurrency() {
    this.generalSettingsService.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    });
  }

  private getProduct(proID) {
    this.productManagerService.single(proID).subscribe(res => {
      if (res && res.pid) {
        this.product = res;
        this.form.get('pid').setValue(res.pid);
        this.form.get('pro_location_country').setValue(res.pro_location_country);
        this.form.get('pro_location_state').setValue(res.pro_location_state);
        this.form.get('shipping_fee').setValue(res.shipping_fee);
        this.form.get('shipping_method').setValue(res.shipping_method);
        this.form.get('allow_shipping_outside').setValue(res.allow_shipping_outside);
      }
    });
  }


  submit() {
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.productManagerService.updateShipping(data).subscribe(res => {
      if (res.status == 'success') {
        this.guestHomeService.getHomeSliders().subscribe();
        this.guestHomeService.getOtherData().subscribe();;
        if (res.data.pid) {
          this.titleUrl = this.configService.clearnUrl(this.product.name);
          this.routingService.replace([
            this.sellerUrl + '/auth/product-manager/' + res.data.pid + '/preview/' + this.titleUrl + '/success'
          ], false);
        }
      } else {
        alert('Oops! Something went wrong, please try it again.');
      }
      this.isSubmitting = false;
    });
  }

}

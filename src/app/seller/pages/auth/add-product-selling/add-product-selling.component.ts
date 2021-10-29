import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Route } from '@angular/router';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ProductManagerService } from 'src/app/data/services/seller/product-manager.service';

@Component({
  selector: 'app-add-product-selling',
  templateUrl: './add-product-selling.component.html',
  styleUrls: ['./add-product-selling.component.scss']
})
export class AddProductSellingComponent implements OnInit {
  lastRoute;
  currency;

  // FROM HERE
  isLoading = false;
  isSaving = false;

  product: any;
  variations: any;
  variationValues: any;
  selectedvariation = [];
  urlData: any;

  // moreDescription: FormArray;
  form = new FormGroup({
    pid: new FormControl(''),
    domestic_policy: new FormControl(''),
    inter_policy: new FormControl(''),
    morePriceVariations: new FormArray([
      new FormGroup({
        id: new FormControl(null),
        variation: new FormControl(null),
        sku: new FormControl(null),
        quantity: new FormControl(1),
        regular_price: new FormControl(null),
        sales_price: new FormControl(null, Validators.required),
      })
    ]),
  });

  get moreDescriptionFormGroup() {
    return this.form.get('morePriceVariations') as FormArray;
  }

  titleUrl: any


  constructor(
    private productManagerService: ProductManagerService,
    private routingService: RoutingService,
    private configService: ConfigService,
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private generalSettings: GeneralSettingsService,
    private guestHomeService: GuestHomeService,
  ) { }

  get sellerUrl() {
    return this.configService.sellerURL;
  }

  // FROM HERE
  get sku() {
    return this.form.get('sku');
  }
  get sales_price() {
    return this.form.get('sales_price');
  }
  get variation() {
    return this.form.get('variation');
  }
  // ENDS HERE

  ngOnInit(): void {
    this.getCurrency();
    const proID = this.route.snapshot.paramMap.get('pid');
    this.lastRoute = this.routingService.activeRoute;
    if (proID) {
      this.getProduct(proID);
    } else {
      this.routingService.replace([
        `/${this.sellerUrl}/auth/product-manager`
      ]);
    }
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    })
  }

  private getProduct(proID) {
    this.productManagerService.single(proID).subscribe(res => {
      if (res && res.pid) {
        if (!this.product) {
          this.product = res;
          this.form.get('pid').setValue(res.pid);
          this.form.get('domestic_policy').setValue(res.domestic_policy);
          this.form.get('inter_policy').setValue(res.inter_policy);
          this.variations = res.category_variation;
          const dataVariation = res.variation;
          if (dataVariation && dataVariation.length > 0) {
            const selected = dataVariation[0].name;

            if (this.variations) {
              this.variationValues = this.variations.filter((item) => item.name == selected)[0];
            }
            this.removeDescription(0);
            for (let i = 0; i < dataVariation.length; i++) {
              this.moreDescriptionFormGroup.push(this.updateMoreDescription(dataVariation[i]));
            }
          }
        }
      }
    });
  }

  updateeMorePriceVariation(obj): FormGroup {
    return this.fb.group({
      variation: obj.variation,
      sku: obj.sku,
      quantity: obj.quantity,
      regular_price: obj.regular_price,
      sales_price: obj.sales_price,
    });
  }

  createMoreDescription(): FormGroup {
    return this.fb.group({
      id: new FormControl(null),
      variation: new FormControl(null),
      sku: new FormControl(null),
      quantity: new FormControl(null),
      regular_price: new FormControl(null),
      sales_price: new FormControl(null, Validators.required),
    });
  }

  updateMoreDescription(obj): FormGroup {
    return this.fb.group({
      id: obj.id,
      variation: obj.name ? `${obj.name}|${obj.value}` : null,
      sku: obj.hasOwnProperty('sku') ? obj.sku : null,
      quantity: obj.quantity,
      regular_price: obj.regular_price,
      sales_price: obj.sales_price,
    });
  }

  addDescription() {
    let fg = this.fb.group({
      id: new FormControl(null),
      variation: new FormControl(null, Validators.required),
      sku: new FormControl(null),
      quantity: new FormControl(null),
      regular_price: new FormControl(null),
      sales_price: new FormControl(null, Validators.required),
    });
    this.moreDescriptionFormGroup.push(fg);

  }

  removeDescription(index) {
    this.moreDescriptionFormGroup.removeAt(index);
  }

  submit() {
    this.isSaving = true;
    const variationWrap = [{
      name: this.selectedvariation,
      value: this.form.value.morePriceVariations
    }];
    const data = JSON.stringify(this.form.value);
    this.productManagerService.priceVariation(data).subscribe(res => {
      if (res.status === 'success') {
        this.guestHomeService.getHomeSliders().subscribe();
        this.guestHomeService.getOtherData().subscribe();
        this.titleUrl = this.configService.clearnUrl(this.product.name);
        this.routingService.replace([
          `${this.sellerUrl}/auth/product-manager/${this.product.pid}/shipping/${this.titleUrl}/edit`
        ], false);
      } else {
        alert('Oops! Something went wrong, please try it again.');
      }
      this.isSaving = false;
    });
  }

  mainVariationChange(event, index) {
    const target = event.target.value;
    const name = target.split('|')[0];
    const value = target.split('|')[1];
    this.selectedvariation = name;
    if (this.variations) {
      this.variationValues = this.variations.filter((item) => item.name === name)[0];
    }
  }

}

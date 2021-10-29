import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { BehaviorSubject } from 'rxjs';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { AddressService } from 'src/app/data/services/customer/address.service';
import { CheckoutService } from 'src/app/data/services/customer/checkout.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ProductService } from 'src/app/data/services/guest/products.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';

@Component({
  selector: 'app-checkout',
  templateUrl: './checkout.component.html',
  styleUrls: ['./checkout.component.scss']
})
export class CheckoutComponent implements OnInit {
  isAdding = false;
  subTotal = 135000;
  shipping = 20000;
  cardAdding = false;
  customerAddress;
  curr = '₦';
  countries;
  payStackKey;

  paymentFailed;

  auth;

  orderItems = [];

  paymentMethods;

  orderNumber;

  get total() {
    return this.subTotal + this.shipping;
  }

  deliveryOptions = [
    {
      date: '2021-06-26',
      price: 20000,
      name: 'Azany Standard Shipping'
    },
    {
      date: '2021-07-09',
      price: 10000,
      name: 'Azany Global Economy Shipping'
    },
  ];

  isplacingOrder = false;

  activePayMethod;

  addAddressForm = new FormGroup({
    street_addr: new FormControl('', Validators.required),
    city: new FormControl('', Validators.required),
    state: new FormControl('', Validators.required),
    country: new FormControl('', Validators.required),
  });

  cardForm = new FormGroup({
    card_no: new FormControl('', Validators.required),
    full_name: new FormControl('', Validators.required),
    expiry_date: new FormControl('', Validators.required),
    cvv: new FormControl('', Validators.required),
  });

  get card_no() {
    return this.cardForm.get('card_no');
  }
  get full_name() {
    return this.cardForm.get('full_name');
  }
  get expiry_date() {
    return this.cardForm.get('expiry_date');
  }
  get cvv() {
    return this.cardForm.get('cvv');
  }

  get street_addr() {
    return this.addAddressForm.get('street_addr');
  }
  get city() {
    return this.addAddressForm.get('city');
  }
  get state() {
    return this.addAddressForm.get('state');
  }
  get country() {
    return this.addAddressForm.get('country');
  }

  closeModal = new BehaviorSubject(false);

  constructor(
    private authService: AuthService,
    private countryService: CountryService,
    private router: Router,
    private generalSettings: GeneralSettingsService,
    private checkoutService: CheckoutService,
    private configService: ConfigService,
    private addressService: AddressService,
    private shoppingCartService: ShoppingCartService,
    private guestHomeService: GuestHomeService,
    private productService: ProductService,
  ) { }

  ngOnInit(): void {
    this.countries = this.countryService.getCountries();
    this.getCurrency();
    this.getCheckoutInfo();
    this.getAuth();
  }

  private getAuth() {
    this.authService.customer.subscribe(auth => {
      this.auth = auth;
    })
  }

  private getCheckoutInfo() {
    this.checkoutService.getCheckoutInfo.subscribe(res => {
      if (res) {
        this.orderItems = res.selectedItems.items;
        this.paymentMethods = res.paymentMethods;
        this.customerAddress = res.userAddress;
        this.payStackKey = res.payStackKey;
        this.subTotal = res.selectedItems.sum;
        this.orderNumber = res.orderNumber;
        let shipping = 0;
        this.orderItems.forEach((order) => {
          shipping += order.shipping_fee * order.quantity;
        });
        this.shipping = shipping;
      } else {
        this.router.navigateByUrl('/shopping-cart');
      }
    });
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.curr = res.currency.symbol;
      }
    });
  }

  addAddress() {
    this.isAdding = true;
    const data = JSON.stringify(this.addAddressForm.value);
    this.addressService.add(data).subscribe(res => {
      if (res && res.status == 'success') {
        this.customerAddress = res.data;
        this.isAdding = false;
        this.closeModal.next(true);
      }
    });
  }

  // addAddress() {
  //   this.isAdding = true;
  //   console.log(this.addAddressForm.value);
  //   this.isAdding = false;
  //   this.closeModal.next(true);
  // }
  addCard() {
    this.cardAdding = true;
    this.cardAdding = false;
    this.closeModal.next(true);
  }

  // placeOrder() {
  //   if (this.activePayMethod == 'paystack') {

  //   }
  //   this.router.navigateByUrl('/customer/thank-you');
  // }

  paymentCancel() {
    this.paymentFailed = true;
  }

  placeOrder(errorEl: HTMLElement[], ref = null) {
    if (this.errorCheck(errorEl)) return;
    this.isplacingOrder = true;
    const defaultAddress = JSON.stringify(this.customerAddress);
    // const shippingMethod = this.storageService.getString('checkoutShippingCost');
    // const couponCode = this.couponInfo ? this.couponInfo.name : null;
    const ids = JSON.stringify(this.orderItems.map(item => item.id));
    // console.log(ids);
    const activePayMethod = this.activePayMethod;
    // console.log(defaultAddress, ids, activePayMethod);
    this.checkoutService.placeOrder(
      defaultAddress, ids, activePayMethod, ref
    )
      .subscribe(res => {
        if (res && res.status === 'success') {
          this.orderItems.forEach((each) => {
            this.productService.product(each.pid).subscribe();
          });
          this.shoppingCartService.shoppingCart().subscribe();
          this.guestHomeService.getOtherData().subscribe();
          this.router.navigateByUrl('/customer/thank-you');
        } else {
          // this.orderFailed = true;
        }
        this.isplacingOrder = false;
      });
  }

  toggle(inp, errElAr, gateway) {
    // if (gateway == 'paystack') {
    //   if (!this.customerAddress) {
    //     let error = this.errorCheck(errElAr);
    //     if (error && error != 'payment') {
    //       setTimeout(() => inp.checked = false);
    //       return;
    //     }
    //   }
    // }
    this.activePayMethod = gateway;
  }

  paymentDone(errElArr, event) {
    if (this.errorCheck(errElArr)) return;
    if (event.status === 'success') {
      this.placeOrder(errElArr, event.reference);
    } else {
      // this.paymentFailed = true;
    }
  }

  errorCheck(errorEl: HTMLElement[]) {
    if (!this.customerAddress) {
      // this.errorMsg.owner = 'address';
      // this.errorMsg.msg = 'Please add a default shipping address';
      errorEl[0].scrollIntoView();
      return 'address';
    }
    // if (!this.shippingCostSTatus.status) {
    //   this.errorMsg.owner = 'delivery';
    //   this.errorMsg.msg = 'Please select a delivery method';
    //   errorEl[1].scrollIntoView();
    //   return 'delivery';
    // }
    if (!this.activePayMethod) {
      // this.errorMsg.owner = 'payment';
      // this.errorMsg.msg = 'Please select a preferred payment method';
      errorEl[1].scrollIntoView();
      return 'payment';
    }
    return null;
  }

}

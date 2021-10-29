import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { CheckoutService } from 'src/app/data/services/customer/checkout.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';

@Component({
  selector: 'app-thank-you',
  templateUrl: './thank-you.component.html',
  styleUrls: ['./thank-you.component.scss']
})
export class ThankYouComponent implements OnInit {
  subTotal = 135000;
  shipping = 20000;
  tax = 999.99;
  curr = '₦';
  orderNo;
  thankYouMsg;
  accounts = [
    {
      "id": 1,
      "currency": "USD",
      "bank": "Zenith Bank",
      "account_name": "Azany Limited",
      "account_number": "2569085322",
      "account_type": "Current",
      "created_at": "2021-04-02 18:06:29",
      "updated_at": "2021-05-27 15:08:18"
    },
    {
      "id": 2,
      "currency": "NGN",
      "bank": "First bank",
      "account_name": "Azany Stock Shop",
      "account_number": "6733334560",
      "account_type": "Current Account",
      "created_at": "2021-04-02 18:07:01",
      "updated_at": "2021-04-02 18:07:01"
    }
  ];
  payMethod = 'bank';

  auth;

  orders = [];

  get total() {
    return this.subTotal + this.shipping;
  }

  constructor(
    private authService: AuthService,
    private generalSettings: GeneralSettingsService,
    private checkoutService: CheckoutService,
    private configService: ConfigService,
    private router: Router,
  ) { }

  ngOnInit(): void {
    this.getCurrency();
    this.getData();
    this.getAuth();
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      this.auth = res;
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

  private getData() {
    this.checkoutService.thankYouData.subscribe(res => {
      console.log(res);
      if (res) {
        this.orders = res.products;
        this.orderNo = res.orderNo;
        this.accounts = res.bankInfo;
        this.payMethod = res.payment_method;
        this.thankYouMsg = res.thankYouMsg;
        let subtotal = 0;
        let shipping = 0;
        this.orders.forEach(each => {
          subtotal += each.sales_price * each.quantity;
          shipping += each.shipping_fee * each.quantity;
        });
        this.subTotal = subtotal;
        this.shipping = shipping;
      } else {
        this.router.navigateByUrl('/shopping-cart');
      }
    });
  }

}

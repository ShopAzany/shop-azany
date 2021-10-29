import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { BehaviorSubject } from 'rxjs';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { CurrencyService } from 'src/app/data/services/currency.service';
import { OrderService } from 'src/app/data/services/customer/order.service';

@Component({
  selector: 'app-order-detail',
  templateUrl: './order-detail.component.html',
  styleUrls: ['./order-detail.component.scss']
})
export class OrderDetailComponent implements OnInit {

  auth;
  message = false;
  isCancelling = false;
  isLoading = true;
  orders: any;
  order: any;
  shipAddress: any;
  shippingMethods: any;
  orderCounts: any;
  currencyObj: string;

  closeModal = new BehaviorSubject<boolean>(false);

  constructor(
    private authService: AuthService,
    private orderService: OrderService,
    private route: ActivatedRoute,
    private routingService: RoutingService,
    private currencyService: CurrencyService,
    private configService: ConfigService,
  ) { }

  ngOnInit(): void {
    const orderNum = this.route.snapshot.paramMap.get('orderNum');
    this.getOrderDetail(orderNum);
    this.getAuth();
    this.getCurrency()
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) {
        this.auth = res;
      }
    });
  }

  private getCurrency() {
    this.currencyService.currencyDefault().subscribe(res => {
      if (res) { this.currencyObj = res; }
    });
  }



  private getOrderDetail(orderNum) {
    this.orderService.getOrder(orderNum).subscribe(res => {
      if (res) {
        this.delayResults(res);
      } else {
        this.routingService.replace(['/customer/orders']);
      }
    });
  }

  private delayResults(response) {
    // setTimeout(() => {
    if (response) {
      this.orders = response.orders
      this.order = response.order;
      this.orderCounts = response.countOrders;
      this.shipAddress = response.shipping_addr;
      this.shippingMethods = this.isJSON(response.order.shipping_method);
    }
    this.isLoading = false;
    // }, 1500);
  }

  private isJSON(jsonString) {
    try {
      const obj = JSON.parse(jsonString);
      if (obj && typeof obj === 'object') {
        return obj;
      }
    } catch (e) {
      return null;
    }

    return null;
  }

  closeCancelOrder() {
    this.closeModal.next(true);
  }

  cancelOrderNow(orderNum) {
    this.isCancelling = true;
    this.orderService.cancelOrder(orderNum).subscribe(res => {
      if (res) {
        this.getOrderDetail(orderNum)
        this.message = true;
      }
      this.isCancelling = false;
      this.closeModal.next(true);

    });
  }

  removeMessage() {
    this.message = false;
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }




}

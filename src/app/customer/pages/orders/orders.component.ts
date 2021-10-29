import { Component, OnInit } from '@angular/core';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { OrderService } from 'src/app/data/services/customer/order.service';

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.scss']
})
export class OrdersComponent implements OnInit {

  auth;
  isLoading = true;
  openOrder = true;
  cancelOrder = false;
  isLoadingMore = false;
  orders = [];
  orderCounts = 0;
  limit = 30;
  currPage = 1;

  cancelledOrderCounts = 0;
  cancelledOrders: any;

  constructor(
    private authService: AuthService,
    private orderService: OrderService,
    private configService: ConfigService,
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.getOrders();
    this.cancelOrders();
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) {
        this.auth = res;
      }
    });
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }

  private getOrders(isMore = false) {
    if (isMore) {
      this.isLoading = false;
    } else {
      this.isLoading = true;
    }
    this.orderService.getOrders(this.limit, this.currPage).subscribe(res => {
      this.delayResults(res, isMore);
    });
  }


  private cancelOrders() {
    this.isLoading = true;
    this.orderService.getCancelledOrders(this.limit, this.currPage).subscribe(res => {
      this.cancelledOrders = res.data;
      this.cancelledOrderCounts = res.count;
    });
  }

  private delayResults(response, isMore) {
    // setTimeout(() => {
    if (response) {
      this.orderCounts = response.count;
      if (isMore && response.data) {
        for (let i = 0; i < response.data.length; i++) {
          this.orders.push(response.data[i]);
        }
      } else {
        this.orders = response.data;
      }
    }
    this.isLoading = false;
    this.isLoadingMore = false;
    // }, 1500);
  }

  loadMore() {
    this.isLoadingMore = true;
    if (this.orderCounts > this.orders.length) {
      this.currPage++;
      this.getOrders(true);
    }
  }



  orderOption(option) {
    if (option == 'open') {
      this.openOrder = true;
      this.cancelOrder = false;
    } else if (option = 'cancel') {
      this.openOrder = false;
      this.cancelOrder = true;
    }
  }

}

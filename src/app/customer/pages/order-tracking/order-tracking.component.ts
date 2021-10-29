import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { OrderService } from 'src/app/data/services/customer/order.service';

@Component({
  selector: 'app-order-tracking',
  templateUrl: './order-tracking.component.html',
  styleUrls: ['./order-tracking.component.scss']
})
export class OrderTrackingComponent implements OnInit {
  isLoading = false;
  orderNum;
  orderStatus = 'Shipped';
  orderId;
  order = {
    pending_date: '2021-09-21 12:32:11',
    processed_date: '2021-09-21 12:32:11',
    shipped_date: '2021-09-21 12:32:11',
    delivered_date: null,
    returned_date: null,
  };

  constructor(
    private route: ActivatedRoute,
    private orderService: OrderService,
  ) { }

  ngOnInit(): void {
    this.orderNum = this.route.snapshot.paramMap.get('orderNum');
    this.orderId = this.route.snapshot.paramMap.get('id');
    this.getTrackingDetails();
  }

  private getTrackingDetails() {
    this.orderService.trackOrder(this.orderId, this.orderNum).subscribe(res => {
      if (res && res.status == 'success') {
        this.order = res.data;
        this.orderStatus = res.data.status;
      }
    });
  }

}

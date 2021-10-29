import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { AuthService } from 'src/app/data/services/auth.service';
import { ProductRatingService } from 'src/app/data/services/customer/product-rating.service';

@Component({
  selector: 'app-rate-now',
  templateUrl: './rate-now.component.html',
  styleUrls: ['./rate-now.component.scss']
})
export class RateNowComponent implements OnInit {

  auth: any;
  rateNow: any;
  isSubmitting = false;

  form = new FormGroup({
    sellerID: new FormControl('', []),
    full_name: new FormControl('', []),
    pid: new FormControl('', []),
    orderID: new FormControl('', []),
    rating: new FormControl('', []),
    title: new FormControl('', []),
    comment: new FormControl('', []),
  });

  constructor(
    private route: ActivatedRoute,
    private authService: AuthService,
    private productRatingService: ProductRatingService,
    private routingService: RoutingService,
  ) { }

  ngOnInit(): void {
    const orderID = this.route.snapshot.paramMap.get('orderID');
    this.getsingleReview(orderID);
    this.getAuth();
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) { 
        this.auth = res; 
        this.form.get('full_name').setValue(this.auth?.full_name);
      }
    });
  }

  private getsingleReview(orderID) {
    this.productRatingService.singleReview(orderID).subscribe(res => {
      console.log(res);
      if (res) {
        this.rateNow = res.orderDetail;
        this.form.get('sellerID').setValue(this.rateNow.seller_id);
        this.form.get('pid').setValue(this.rateNow.pid);
        this.form.get('orderID').setValue(this.rateNow.order_id);
      } else {
        this.routingService.replace(['/customer/pending-reviews']);
      }
    });
  }

  submit(){
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.productRatingService.addReview(data).subscribe(res => {
      console.log(res);
      if (res && res.status == 'success') {
        alert('Product successfully rated');
        this.routingService.replace(['/customer/pending-reviews']);
      }
    });
    console.log(this.form.value);
  }

}

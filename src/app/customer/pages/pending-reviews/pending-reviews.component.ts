import { Component, OnInit } from '@angular/core';
import { ProductRatingService } from 'src/app/data/services/customer/product-rating.service';

@Component({
  selector: 'app-pending-reviews',
  templateUrl: './pending-reviews.component.html',
  styleUrls: ['./pending-reviews.component.scss']
})
export class PendingReviewsComponent implements OnInit {

  pendingReviews = [];
  pendingCounts = 0;
  limit = 30;
  currPage = 1;
  isLoadingMore = false;
  isLoading = true;

  constructor(
    private productRatingService: ProductRatingService
  ) { }

  ngOnInit(): void {
    this.getPendingReview()
  }


  private getPendingReview(isMore = false) {
    if (isMore) {
      this.isLoading = false;
    } else {
      this.isLoading = true;
    }
    this.productRatingService.pendingReviews(this.limit, this.currPage).subscribe(res => {
      this.delayResults(res, isMore);
    });
  }


  private delayResults(response, isMore) {
    setTimeout(() => {
      if (response) {
        this.pendingCounts = response.count;
        if (isMore && response.data) {
          for (let i = 0; i < response.data.length; i++) {
            this.pendingReviews.push(response.data[i]);
          }
        } else {
          this.pendingReviews = response.data;
        }
      }
      this.isLoading = false;
      this.isLoadingMore = false;
    }, 1500);
  }

  loadMore() {
    this.isLoadingMore = true;
    if (this.pendingCounts > this.pendingReviews.length) {
      this.currPage++;
      this.getPendingReview(true);
    }
  }

}

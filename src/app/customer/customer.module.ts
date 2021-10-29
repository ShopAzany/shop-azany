import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CustomerRoutingModule } from './customer-routing.module';
import { CheckoutComponent } from './pages/checkout/checkout.component';
import { SharedModule } from '../shared/shared.module';
import { ThankYouComponent } from './pages/thank-you/thank-you.component';
import { AccountComponent } from './pages/account/account.component';
import { AddressBookComponent } from './pages/address-book/address-book.component';
import { ChangePasswordComponent } from './pages/change-password/change-password.component';
import { DashboardComponent } from './pages/dashboard/dashboard.component';
import { OrderDetailComponent } from './pages/order-detail/order-detail.component';
import { OrdersComponent } from './pages/orders/orders.component';
import { PendingReviewsComponent } from './pages/pending-reviews/pending-reviews.component';
import { ProfileComponent } from './pages/profile/profile.component';
import { RateNowComponent } from './pages/rate-now/rate-now.component';
import { RecentViewComponent } from './pages/recent-view/recent-view.component';
import { SidebarComponent } from './pages/shared/sidebar/sidebar.component';
import { WishlistComponent } from './pages/wishlist/wishlist.component';
import { Angular4PaystackModule } from 'angular4-paystack';
import { OrderTrackingComponent } from './pages/order-tracking/order-tracking.component';
import { RewardComponent } from './pages/reward/reward.component';


@NgModule({
  declarations: [
    CheckoutComponent,
    ThankYouComponent,
    DashboardComponent,
    SidebarComponent,
    AccountComponent,
    OrdersComponent,
    OrderDetailComponent,
    WishlistComponent,
    RecentViewComponent,
    ProfileComponent,
    AddressBookComponent,
    ChangePasswordComponent,
    PendingReviewsComponent,
    RateNowComponent,
    OrderTrackingComponent,
    RewardComponent
  ],
  imports: [
    CommonModule,
    CustomerRoutingModule,
    SharedModule,
    Angular4PaystackModule.forRoot(
      'pk_test_9fa542a330d00b5f96c3beed453dcf152bb96e9b'
    )
  ]
})
export class CustomerModule { }

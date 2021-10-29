import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AccountComponent } from './pages/account/account.component';
import { AddressBookComponent } from './pages/address-book/address-book.component';
import { ChangePasswordComponent } from './pages/change-password/change-password.component';
import { CheckoutComponent } from './pages/checkout/checkout.component';
import { OrderDetailComponent } from './pages/order-detail/order-detail.component';
import { OrderTrackingComponent } from './pages/order-tracking/order-tracking.component';
import { OrdersComponent } from './pages/orders/orders.component';
import { PendingReviewsComponent } from './pages/pending-reviews/pending-reviews.component';
import { ProfileComponent } from './pages/profile/profile.component';
import { RateNowComponent } from './pages/rate-now/rate-now.component';
import { RecentViewComponent } from './pages/recent-view/recent-view.component';
import { ThankYouComponent } from './pages/thank-you/thank-you.component';
import { WishlistComponent } from './pages/wishlist/wishlist.component';
import { RewardComponent} from './pages/reward/reward.component';

const routes: Routes = [
  { path: 'checkout', component: CheckoutComponent },
  { path: 'thank-you', component: ThankYouComponent },
  { path: '', component: AccountComponent },
  { path: 'orders', component: OrdersComponent },
  { path: 'orders/detail/:orderNum', component: OrderDetailComponent },
  { path: 'orders/track/:orderNum/:id', component: OrderTrackingComponent },
  { path: 'wishlist', component: WishlistComponent },
  { path: 'recent-view', component: RecentViewComponent },
  { path: 'profile', component: ProfileComponent },
  { path: 'profile', component: ProfileComponent },
  { path: 'address-book', component: AddressBookComponent },
  { path: 'change-password', component: ChangePasswordComponent },
  { path: 'pending-reviews', component: PendingReviewsComponent },
  { path: 'pending-reviews/rate/:orderID', component: RateNowComponent },
  { path: 'reward', component: RewardComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CustomerRoutingModule { }

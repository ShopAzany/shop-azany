import { Component, OnInit } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { AuthService } from 'src/app/data/services/auth.service';
import { CurrencyService } from 'src/app/data/services/currency.service';
import { OrderService } from 'src/app/data/services/customer/order.service';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';

@Component({
  selector: 'app-wishlist',
  templateUrl: './wishlist.component.html',
  styleUrls: ['./wishlist.component.scss']
})
export class WishlistComponent implements OnInit {

  closeModal = new BehaviorSubject<boolean>(false);

  auth;
  isLoading = true;
  isLoadingMore = false;
  openOrder = true;
  cancelOrder = false;
  message = false;
  currencyObj;
  wishLists = [];
  wishCounts = 0;
  limit = 20;
  currPage = 1;

  addingCart = { pid: -1, status: false };

  addCartProdName;

  pid = -1;

  removeWishID = 0;
  isRemoving = false;


  constructor(
    private authService: AuthService,
    private wishlistService: WishlistService,
    private currencyService: CurrencyService,
    private generalSettings: GeneralSettingsService,
    private shoppingCartService: ShoppingCartService,
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.getWisllist();
    this.getCurrency();
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) {
        this.auth = res;
      }
    });
  }

  private getWisllist(isMore = false) {
    if (isMore) {
      this.isLoading = false;
    } else {
      this.isLoading = true;
    }
    this.wishlistService.getWishList(this.limit, this.currPage).subscribe(res => {
      this.delayResults(res, isMore);
    });
  }

  private delayResults(response, isMore) {
    console.log(response, 'wishlist');
    // setTimeout(() => {
    if (response) {
      this.wishCounts = response.count;
      if (isMore && response.data) {
        for (let i = 0; i < response.data.length; i++) {
          this.wishLists.push(response.data[i]);
        }
      } else {
        this.wishLists = response.data;
      }
    }
    this.isLoading = false;
    this.isLoadingMore = false;
    // }, 1500);
  }

  loadMore() {
    this.isLoadingMore = true;
    if (this.wishCounts > this.wishLists.length) {
      this.currPage++;
      this.getWisllist(true);
    }
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currencyObj = res.currency;
      }
    });
  }


  removeWish(id) {
    this.removeWishID = id;
  }

  closeModalWish() {
    this.closeModal.next(true);
  }

  removeItem(pid, opener) {
    this.pid = pid;
    opener.click();
  }

  removeWishNow() {
    this.isRemoving = true;
    // const wishID = this.removeWishID;
    // console.log(wishID);
    let matchId = -1;
    this.wishLists.forEach((each, i) => {
      if (each.pid == this.pid) {
        matchId = i;
      }
    });
    this.wishlistService.removeFavorite(this.pid).subscribe(res => {
      console.log(res);
      if (res && res.status == 'success') {
        // this.ngOnInit();
        this.wishLists.splice(matchId, 1);
        this.wishCounts--;
        this.message = true;
        this.closeModal.next(true);
      }
      this.isRemoving = false;
    });
  }

  removeMessage() {
    this.message = false;
  }

  addToCart(prod) {
    this.addingCart = { pid: prod.pid, status: true };
    const tempData = {
      pid: prod.pid,
      quantity: 1,
      variation: prod.variation ? prod.variation : prod.variation[0]
    };
    const data = JSON.stringify(tempData);
    this.shoppingCartService.addToCart(data).subscribe(res => {
      if (res) {
        this.addCartProdName = prod.name;
        this.addingCart = { pid: -1, status: false };
        setTimeout(() => {
          this.addCartProdName = null;
        }, 4000);
      }
    });
  }

}

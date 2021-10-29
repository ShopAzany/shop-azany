import { Component, OnInit } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { ProductService } from 'src/app/data/services/guest/products.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';

@Component({
  selector: 'app-recent-view',
  templateUrl: './recent-view.component.html',
  styleUrls: ['./recent-view.component.scss']
})
export class RecentViewComponent implements OnInit {
  products;
  currency;
  updatingFav = { pid: -1, status: false };
  addingCart = { pid: -1, status: false };
  addCartProdName;
  pid;

  closeModal = new BehaviorSubject<boolean>(false);


  constructor(
    private productService: ProductService,
    private generalSettings: GeneralSettingsService,
    private wishListService: WishlistService,
    private shoppingCartService: ShoppingCartService,
  ) { }

  ngOnInit(): void {
    this.getCurrency();
    this.getRecentProduct();
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    });
  }

  private getRecentProduct() {
    this.productService.recentlyViewed.subscribe(res => {
      this.products = res;
    });
  }

  removeItem(pid, opener) {
    this.pid = pid;
    opener.click();
  }

  removeRecent() {
    this.productService.removeRecent(this.pid);
    this.closeModal.next(true);
  }

  updateFav(pid) {
    let matchInd = -1;
    this.products.forEach((each, i) => {
      if (each.pid == pid) {
        matchInd = i;
      }
    });
    this.updatingFav = { pid: pid, status: true };
    if (!this.products[matchInd].isFavorite) {
      this.wishListService.addFavorite(pid).subscribe(res => {
        this.updatingFav = { pid: -1, status: false };
      });
    } else {
      this.wishListService.removeFavorite(pid).subscribe(res => {
        this.updatingFav = { pid: -1, status: false };
      });
    }
  }

  addToCart(prod) {
    this.addingCart = { pid: prod.pid, status: true };
    const tempData = {
      pid: prod.pid,
      quantity: 1,
      variation: prod.variation[0]
    };
    const data = JSON.stringify(tempData);
    this.shoppingCartService.addToCart(data).subscribe(res => {
      if (res) {
        this.addCartProdName = prod.name || prod.product_name;
        this.addingCart = { pid: -1, status: false };
        setTimeout(() => {
          this.addCartProdName = null;
        }, 4000);
      }
    });
  }
}

import { Component, ElementRef, OnInit, QueryList, ViewChildren } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { CheckoutService } from 'src/app/data/services/customer/checkout.service';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';

@Component({
  selector: 'app-shopping-cart',
  templateUrl: './shopping-cart.component.html',
  styleUrls: ['./shopping-cart.component.scss']
})
export class ShoppingCartComponent implements OnInit {
  @ViewChildren('checkbox') checkboxes: QueryList<ElementRef>;
  curr = "₦";
  selItems = 0;
  updating = { id: -1, status: false };
  cartItems = [];
  updatingFav = { pid: -1, status: false };

  deleting = { id: -1, status: false };

  auth;

  proceeding = false;

  subTotal = 0;
  shipping = 0;

  checkState = [];

  get total() {
    return this.subTotal + this.shipping;
  }

  constructor(
    private configService: ConfigService,
    private router: Router,
    private shoppingCartService: ShoppingCartService,
    private generalSettings: GeneralSettingsService,
    private authService: AuthService,
    private checkoutService: CheckoutService,
    private wishListService: WishlistService,
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.getCurrency();
    this.getCart();
  }

  private getAuth() {
    this.authService.customer.subscribe(auth => {
      this.auth = auth;
    });
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.curr = res.currency.symbol;
      }
    })
  }

  private getCart() {
    this.shoppingCartService.getShoppingCart.subscribe(res => {
      console.log(res);
      if (res) {
        this.cartItems = res.items;
      }
    });
  }

  numberFormat(price) {
    if (price) {
      return this.configService.numberFormat(price, 2).split('.');
    }
    return [0, '00'];
  }

  cleanUrl(name) {
    if (name) {
      return this.configService.clearnUrl(name);
    }
    return null;
  }

  checkChange(e, i) {
    if (e.target.checked) {
      this.subTotal += this.cartItems[i].quantity * this.cartItems[i].sales_price;
      this.shipping += this.cartItems[i].quantity * this.cartItems[i].shipping_fee;
      this.selItems++;
    } else {
      this.subTotal -= (this.cartItems[i].quantity * this.cartItems[i].sales_price);
      this.shipping -= this.cartItems[i].quantity * this.cartItems[i].shipping_fee;
      this.selItems--;
    }
    this.subTotal = +this.subTotal.toFixed(2);
    if (!this.subTotal) {
      this.shipping = 0;
    }
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }

  proceedToCheckout() {
    this.proceeding = true;
    let ids = [];
    this.checkboxes.forEach((check, i) => {
      if (check.nativeElement.checked) {
        ids.push(this.cartItems[i].id);
      }
    });
    console.log(ids);
    const data = JSON.stringify(ids);
    // return;
    if (this.auth) {
      this.checkoutService.postSelectedItems(data).subscribe(res => {
        if (res) {
          console.log(res);
          this.router.navigateByUrl('/customer/checkout');
        }
      })
    } else {
      this.router.navigateByUrl('/login');
    }
  }

  allSectionChange(command) {
    this.checkboxes.forEach((each) => {
      if ((!each.nativeElement.checked && command == 'select') || (each.nativeElement.checked && command == 'deselect')) {
        each.nativeElement.click();
      }
    });
  }

  private restoreState() {
    this.shipping = 0;
    this.subTotal = 0;
    this.selItems = 0;
    this.checkState.forEach((state, i) => {
      if (state) {
        this.checkboxes.get(i).nativeElement.click();
      }
    });
  }

  updateQty(n, i) {
    this.updating = { id: i, status: true };
    this.checkState = [];
    this.checkboxes.forEach((check) => {
      let state = check.nativeElement.checked;
      this.checkState.push(state);
    });
    if (n == 1) {
      const postData = {
        pid: this.cartItems[i].pid,
        quantity: 1,
        variation: this.cartItems[i].variation
      }
      const data = JSON.stringify(postData);
      this.shoppingCartService.addToCart(data).subscribe(res => {
        console.log(res);
        if (res) {
          console.log(this.checkboxes);
          setTimeout(() => {
            this.restoreState();
          });
          // this.checkboxes.get(i).nativeElement.checked = false;
          // this.selItems--;
          // this.subTotal -= this.cartItems[i].quantity * this.cartItems[i].sales_price;
          // this.shipping -= this.cartItems[i].quantity * this.cartItems[i].shipping_fee;
          // this.cartItems[i].quantity += n;
          // this.checkboxes.get(i).nativeElement.click();
        }
        this.updating = { id: i, status: false };
      });
    } else {
      this.shoppingCartService.updateQty(this.cartItems[i].id).subscribe(res => {
        console.log(res);
        if (res) {
          setTimeout(() => {
            this.restoreState();
          });
        }
        this.updating = { id: i, status: false };
      });
    }
  }

  deleteItem(i) {
    this.deleting = { id: i, status: true };
    this.checkState = [];
    this.checkboxes.forEach((check) => {
      let state = check.nativeElement.checked;
      this.checkState.push(state);
    });
    this.shoppingCartService.removeItem(this.cartItems[i].id).subscribe(res => {
      if (res) {
        this.checkState.splice(i, 1);
        this.deleting = { id: -1, status: false };
        setTimeout(() => {
          this.restoreState();
        });
      }
    });
  }

  // toggleFav() {

  // }

  toggleFav(prod) {
    if (this.auth) {
      this.updatingFav = { pid: prod.pid, status: true };
      if (!prod.isFavorite) {
        this.wishListService.addFavorite(prod.pid).subscribe(res => {
          if (res.status == 'success') {
            this.cartItems.forEach((each) => {
              if (each.pid == prod.pid) {
                each.isFavorite = 1;
              }
            });
          }
          this.updatingFav = { pid: prod.pid, status: false };
        });
      } else {
        this.wishListService.removeFavorite(prod.pid).subscribe(res => {
          if (res.status == 'success') {
            this.cartItems.forEach((each) => {
              if (each.pid == prod.pid) {
                each.isFavorite = 0;
              }
            });
          }
          this.updatingFav = { pid: prod.pid, status: false };
        });
      }
    } else {
      this.router.navigateByUrl('/login');
    }
  }

}

import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { FavoriteService } from 'src/app/data/services/customer/favorite.service';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';

@Component({
  selector: 'app-auth-each-product',
  templateUrl: './auth-each-product.component.html',
  styleUrls: ['./auth-each-product.component.scss']
})
export class AuthEachProductComponent implements OnInit {
  @Input() owner;
  @Input() product;
  @Output() delEv = new EventEmitter();
  @Output() favEv = new EventEmitter();
  @Output() addCartEv = new EventEmitter();
  @Input() deleting;
  @Input() currency;
  @Input() updatingFav = { pid: -1, status: false };
  @Input() addingCart = { pid: -1, status: false };
  auth;
  @Input() wishlist;

  constructor(
    private configService: ConfigService,
  ) { }

  ngOnInit(): void {
  }

  get cleanUrl() {
    if (this.product) {
      return this.configService.clearnUrl(this.product.name);
    }
    return null;
  }

  get salePrice() {
    if (this.product && this.product.variation) {
      let salesPrice = this.product.variation[0] ? this.product.variation[0].sales_price : this.product.variation.sales_price;
      return this.configService.numberFormat(salesPrice, 2).split('.');
    }
    return [0, '00'];
  }

  get slug() {
    if (this.product && this.product.name) {
      return this.configService.clearnUrl(this.product.name);
    }
    return null;
  }

  get qty() {
    if (this.product && this.product.variation) {
      let quantity = this.product.variation[0] ? this.product.variation[0].quantity : this.product.variation.quantity;
      return quantity;
    }
    return 0;
  }

  get regularPrice() {
    if (this.product && this.product.variation) {
      let regPrice = this.product.variation[0] ? this.product.variation[0].regular_price : this.product.variation.regular_price;
      return regPrice;
    }
    return 0;
  }

  updateFav() {
    this.favEv.emit(this.product.pid);
  }

  get perc() {
    if (this.product && this.product.variation) {
      let discount = this.product.variation[0] ? this.product.variation[0].discount : this.product.variation.discount;
      return discount;
    }
    return 0;
  }

  get ratingArr() {
    if (this.product && this.product.average_rate) {
      return Array(+(this.product.average_rate / this.product.rate_number).toFixed(0));
    }
    return [];
  }

  get noRating() {
    return Array(5 - this.ratingArr.length);
  }

  get image() {
    if (this.product) {
      if (this.product.featured_img || this.product.images) {
        return this.product.featured_img ? this.product.featured_img : JSON.parse(this.product.images)[0];
      }
    }
    return null;
  }

  get treatedImgUrl() {
    if (this.image) {
      return this.configService.treatImgUrl(this.image);
    }
    return null;
  }

  delete() {
    this.delEv.emit(this.product.pid);
  }

  addTocart() {
    this.addCartEv.emit(this.product);
  }

}

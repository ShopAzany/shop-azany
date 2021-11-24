import { Component, OnInit } from '@angular/core';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ProductManagerService } from 'src/app/data/services/seller/product-manager.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-product-listing',
  templateUrl: './product-listing.component.html',
  styleUrls: ['./product-listing.component.scss']
})
export class ProductListingComponent implements OnInit {

  bizerr = false;

  products;
  prodCounts;
  deleting = { status: false, pid: -1 };
  currency;
  isLoading = true;

  auth;

  constructor(
    private productManagerService: ProductManagerService,
    private generalSettings: GeneralSettingsService,
    private guestHomeService: GuestHomeService,
    private authService: SellerAuthService,
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.getProducts();
    this.getCurrency();
    this.checkbiz();
  }

  private getProducts() {
    this.productManagerService.getProducts().subscribe(res => {
      if (res) {
        this.updateProducts(res);
      }
      this.isLoading = false;
    });
  }
  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    });
  }

  private getAuth() {
    this.authService.seller.subscribe(auth => {
      this.auth = auth;
      console.log(this.auth)
    });
  }

  private checkbiz() {
    console.log(this.auth)
    if (this.auth.biz_info_status == 0) {
      this.bizerr = true;
    }
  }

  private updateProducts(res) {
    this.products = res.data;
    this.prodCounts = res.count;
  }

  delete(id) {
    if (confirm('Are you sure you want to delete this product?')) {
      this.deleting = { status: true, pid: id };
      this.productManagerService.delete(id).subscribe(res => {
        this.updateProducts(res);
        this.deleting = { status: false, pid: -1 };
        this.guestHomeService.getHomeSliders().subscribe();
        this.guestHomeService.getOtherData().subscribe();
      });
    }
  }

}

import { Component, OnInit } from '@angular/core';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ProductManagerService } from 'src/app/data/services/seller/product-manager.service';

@Component({
  selector: 'app-product-listing',
  templateUrl: './product-listing.component.html',
  styleUrls: ['./product-listing.component.scss']
})
export class ProductListingComponent implements OnInit {
  products;
  prodCounts;
  deleting = { status: false, pid: -1 };
  currency;
  isLoading = true;

  constructor(
    private productManagerService: ProductManagerService,
    private generalSettings: GeneralSettingsService,
    private guestHomeService: GuestHomeService,
  ) { }

  ngOnInit(): void {
    this.getProducts();
    this.getCurrency();
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

import { isPlatformBrowser } from '@angular/common';
import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { AuthService } from './data/services/auth.service';
import { GeneralSettingsService } from './data/services/general-settings.service';
import { CategoryService } from './data/services/guest/category.service';
import { GuestHomeService } from './data/services/guest/guest-home.service';
import { ProductService } from './data/services/guest/products.service';
import { ShoppingCartService } from './data/services/guest/shopping-cart.service';
import { SellerAuthService } from './data/services/seller/seller-auth.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'azany';

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private sellerAuthService: SellerAuthService,
    private customerAuthService: AuthService,
    private categoryService: CategoryService,
    private homeService: GuestHomeService,
    private generalSettingsService: GeneralSettingsService,
    private productService: ProductService,
    private shoppingCartService: ShoppingCartService,
  ) { }
  ngOnInit() {
    this.checkSellerAuthLogin();
    this.customerAutoLogin();
    this.getHeaderCategories();
    this.getGenSettings();
    this.retrievViewedProd();
    this.getShoppingCart();
  }

  private getShoppingCart() {
    this.shoppingCartService.shoppingCart().subscribe();
  }

  private retrievViewedProd() {
    this.productService.retrieveRecentViewed();
  }


  private getGenSettings() {
    this.generalSettingsService.getGenSettings().subscribe();
  }



  private checkSellerAuthLogin() {
    this.sellerAuthService.autoLogin().subscribe();
  }
  private customerAutoLogin() {
    this.customerAuthService.autoLogin().subscribe();
  }
  private getHeaderCategories() {
    this.categoryService.getHeaderCategories().subscribe();
  }

  scrollTop(topdiv) {
    topdiv.scrollIntoView();
    if (isPlatformBrowser(this.platformId)) {
      document.body.style.overflowY = '';
    }
  }
}

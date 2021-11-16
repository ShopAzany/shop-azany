import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {
  selCountryInd = 0;
  bannerSlides;
  currency;
  bannerLoading = true;
  contentLoading = true;

  updatingFav = { pid: -1, status: false };
  addingCart = { pid: -1, status: false };

  featuredProdBanner;
  shopByCountry;
  liveStream;
  recentAdded;
  recommended;
  deals;
  topSelling;
  topCategories;
  threeGridImg;

  addCartProdName;
  auth;

  constructor(
    private homeService: GuestHomeService,
    private configService: ConfigService,
    private generalSettings: GeneralSettingsService,
    private shoppingCartService: ShoppingCartService,
    private authService: AuthService,
    private wishListService: WishlistService,
    private router: Router,
  ) { }

  ngOnInit(): void {
    this.getSlideBanners();
    this.getOtherData();
    this.getGenSettings();
    this.getAuth();
    console.log(this.shopByCountry.image);
  }

  // setCountry(country) {
  //   this.selCountry = country.toLowerCase();
  // }

  private getAuth() {
    this.authService.customer.subscribe(auth => {
      this.auth = auth;
    })
  }

  private getGenSettings() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    })
  }

  private getOtherHomeData() {
    this.homeService.getOtherData().subscribe();
  }

  private getHomeBanners() {
    this.homeService.getHomeSliders().subscribe();
  }

  private getSlideBanners() {
    this.homeService.homeBannerSliders.subscribe(res => {
      if (res) {
        this.bannerSlides = res;
        this.bannerLoading = false;
      } else {
        this.getHomeBanners();
      }
    });
  }

  private getOtherData() {
    this.homeService.homeOthers.subscribe(res => {
      if (res) {
        if (res.HomeProduct) {
          if (res.HomeProduct.feature_product_banner == 'Enabled') {
            this.featuredProdBanner = res.featProBan;
          }
          if (res.HomeProduct.shop_by_country == 'Enabled') {
            this.shopByCountry = res.shopByCountry;
            console.log(res.shopByCountry) //? res.shopByCountry.filter(each => each.selectedPro.length) : [];
          }
          this.topCategories = res.top_categories;
          if (res.HomeProduct.today_deals == 'Enabled') {
            this.deals = res.todayDeals;
          }
          if (res.HomeProduct.recommended == 'Enabled') {
            this.recommended = res.recommended;
          }
          if (res.HomeProduct.recently_added == 'Enabled') {
            this.recentAdded = res.recentlyAdded;
          }
          if (res.HomeProduct.live_stream == 'Enabled') {
            this.liveStream = res.liveStream;
          }
          if (res.HomeProduct.top_selling == 'Enabled') {
            this.topSelling = res.topSelling;
          }
          if (res.HomeProduct.three_grid_image == 'Enabled') {
            this.threeGridImg = res.threeGridImg;
          }
        }
        this.contentLoading = false;
      } else {
        this.getOtherHomeData();
      }
    })
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }

  addToCart(prod) {
    this.addingCart = { pid: prod.pid, status: true };
    const temData = {
      pid: prod.pid,
      quantity: 1,
      variation: prod.variation[0] ? prod.variation[0] : prod.variation
    }
    const data = JSON.stringify(temData);
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

  updateFav(prod) {
    if (this.auth) {
      this.updatingFav = { pid: prod.pid, status: true };
      if (!prod.isFavorite) {
        this.wishListService.addFavorite(prod.pid).subscribe(res => {
          this.updatingFav = { pid: -1, status: false };
        });
      } else {
        this.wishListService.removeFavorite(prod.pid).subscribe(res => {
          this.updatingFav = { pid: -1, status: false };
        });
      }
    } else {
      this.router.navigateByUrl('/login');
    }
  }

  // private updateHomeInfoFav(pid, fav) {
  //   this.
  // }

}

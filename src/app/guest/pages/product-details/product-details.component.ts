import { isPlatformBrowser } from '@angular/common';
import { Component, Inject, OnInit, PLATFORM_ID } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from 'src/app/data/services/auth.service';
import { ConfigService } from 'src/app/data/services/config.service';
import { CheckoutService } from 'src/app/data/services/customer/checkout.service';
import { FavoriteService } from 'src/app/data/services/customer/favorite.service';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { ProductService } from 'src/app/data/services/guest/products.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';

@Component({
  selector: 'app-product-details',
  templateUrl: './product-details.component.html',
  styleUrls: ['./product-details.component.scss']
})
export class ProductDetailsComponent implements OnInit {
  activeImg = 0;
  auth;
  isLoading = true;
  buying = false;
  prdQuant = 1924;
  // shippingFee = 5000;
  curPurcQty = 1;
  product;
  currency;

  updatingFav = false;

  breadcrumbCat;

  features;

  salesPrice = [0, '00'];
  regularPrice;

  cartItems = [];

  categoryTitle;
  productVariations;

  ratings;
  discount;
  cartVariation;

  sameProduct;

  adding = false;
  isFavorite = 0;

  // variations = [
  //   {
  //     name: 'Color',
  //     variations: [
  //       { value: 'Purple', image: 'assets/images/prodimg.png' },
  //       { value: 'White', image: 'assets/images/prodimg3.png' },
  //       { value: 'Dark-grey', image: 'assets/images/prodimg2.png' },
  //       { value: 'Black', image: 'assets/images/prodimg6.png' },
  //       { value: 'Light-grey', image: 'assets/images/prodimg7.png' },
  //     ],
  //   },
  //   {
  //     name: 'Size',
  //     variations: [
  //       { value: 'S', image: null },
  //       { value: 'M', image: null },
  //       { value: 'L', image: null },
  //       { value: 'XL', image: null },
  //       { value: 'XXL', image: null },
  //       { value: 'XXXL', image: null },
  //     ],
  //   },
  // ];

  images = [];

  slideResizeConfig = [
    { minW: 536, slideNo: 5 },
    { minW: 420, maxW: 536, slideNo: 4 },
    { minW: 320, maxW: 420, slideNo: 3 },
    { maxW: 320, slideNo: 2 }
  ];

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private authService: AuthService,
    private router: Router,
    private configService: ConfigService,
    private productService: ProductService,
    private route: ActivatedRoute,
    private generalSettings: GeneralSettingsService,
    private shoppingCartService: ShoppingCartService,
    private checkoutService: CheckoutService,
    private wishListService: WishlistService,
  ) { }

  get ratingArr() {
    if (this.product && this.product.average_rate) {
      return Array(+(this.product.average_rate / this.product.rate_number).toFixed(0)).fill(0);
    }
    return [];
  }

  get noRating() {
    return Array(5 - this.ratingArr.length).fill(0);
  }

  ngOnInit(): void {
    this.getAuth();
    this.getCurrency();
    this.getCart();
  }

  private getCart() {
    this.shoppingCartService.getShoppingCart.subscribe(res => {
      if (res) {
        this.cartItems = res.items;
      }
      this.route.params.subscribe(param => {
        if (isPlatformBrowser(this.platformId)) {
          document.body.scrollTop = 0;
        }
        this.images = [];
        setTimeout(() => {
          this.getProduct();
        });
      });
    });
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    })
  }

  qtyCheck(vari) {
    let cartQty;
    let matchProd = this.cartItems.filter(cart => {
      return cart.variation.id == vari.id;
    });
    if (matchProd.length > 0) {
      cartQty = matchProd[0].quantity;
    }
    if (vari.quantity == null) {
      return true;
    } else if ((vari.quantity - (cartQty ? cartQty : 0)) > 0) {
      return true;
    } else {
      return false;
    }
  }

  firstPass() {
    for (let i = 0; i < this.productVariations.length; i++) {
      if (this.selectable(this.productVariations[i])) {
        return i;
      }
    }
    return -1;
  }

  selectable(vari) {
    if (vari) {
      return this.qtyCheck(vari);
    }
    return false;
  }

  private getProduct() {
    const pid = this.route.snapshot.paramMap.get('pid');
    if (isNaN(+pid)) {
      this.router.navigateByUrl('/');
    }
    this.productService.localCheckProduct(pid).subscribe(res => {
      if (res) {
        this.product = res;
        if (res.features) {
          this.features = JSON.parse(res.features);
        }
        this.images = res.images.map(img => this.treatImgUrl(img));
        this.categoryTitle = res.categoryTitle;
        let catArr = res.category.split(',');
        this.breadcrumbCat = {
          mainCat: this.categoryTitle.cat_name,
          mainCatSlug: this.categoryTitle.cat_slug,
          subCat: this.categoryTitle.subcat_name,
          subCatSlug: this.categoryTitle.subcat_slug,
          subSubCat: this.categoryTitle.activeCategory,
          subSubCatSlug: catArr[2],
          subTitle: res.sub_title
        };
        this.isFavorite = res.isFavorite;
        this.sameProduct = res.sameProduct;
        this.ratings = res.ratings;
        this.productVariations = res.variation[0].name ? res.variation : null;
        let initcartProd;
        if (this.productVariations) {
          let firstVar = this.productVariations[this.firstPass()];
          firstVar = firstVar ? firstVar : this.productVariations[0];
          if (this.cartItems) {
            initcartProd = this.cartItems.filter(cart => cart.pid == this.product.pid && JSON.stringify(cart.variation) == JSON.stringify(firstVar));
            initcartProd = initcartProd.length > 0 ? initcartProd[0] : null;
          }
          this.salesPrice = this.configService.numberFormat(firstVar.sales_price, 2).split('.');
          this.regularPrice = firstVar.regular_price;
          this.prdQuant = initcartProd ? (firstVar.quantity - initcartProd.quantity) : firstVar.quantity;
          this.discount = firstVar.discount;
          this.cartVariation = this.productVariations.length == 1 && this.selectable(this.productVariations[0]) ? this.productVariations[0] : null;
        } else {
          let varia = res.variation[0];
          if (this.cartItems) {
            initcartProd = this.cartItems.filter(cart => cart.pid == this.product.pid && JSON.stringify(cart.variation) == JSON.stringify(varia));
            initcartProd = initcartProd.length > 0 ? initcartProd[0] : null;
          }
          this.salesPrice = this.configService.numberFormat(varia.sales_price, 2).split('.');
          this.regularPrice = varia.regular_price;
          this.prdQuant = initcartProd && varia.quantity ? (varia.quantity - initcartProd.quantity) : varia.quantity;
          this.discount = varia.discount;
        }
      }
      this.isLoading = false;
    });
  }

  onChnage(selVar) {
    this.salesPrice = this.configService.numberFormat(selVar.sales_price, 2).split('.');
    this.regularPrice = selVar.regular_price;
    this.discount = selVar.discount;
    let initcartProd;
    if (this.cartItems) {
      initcartProd = this.cartItems.filter(cart => cart.pid == this.product.pid && JSON.stringify(cart.variation) == JSON.stringify(selVar));
      initcartProd = initcartProd.length > 0 ? initcartProd[0] : null;
    }
    this.prdQuant = initcartProd ? (selVar.quantity - initcartProd.quantity) : selVar.quantity;
    this.curPurcQty = 1;
    // this.qntLimitErr = false;
    this.cartVariation = selVar;
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      this.auth = res;
    });
  }

  addFav() {
    if (this.auth) {
      this.updatingFav = true;
      if (!this.isFavorite) {
        this.wishListService.addFavorite(this.product.pid).subscribe(res => {
          if (res.status == 'success') {
            this.isFavorite = 1;
          }
          this.updatingFav = false;
        });
      } else {
        this.wishListService.removeFavorite(this.product.pid).subscribe(res => {
          if (res.status == 'success') {
            this.isFavorite = 0;
          }
          this.updatingFav = false;
        });
      }
    } else {
      this.router.navigateByUrl('/login');
    }
  }

  qtyCtrl(n) {
    if ((n == -1 && this.curPurcQty < 2) || (n == 1 && this.prdQuant == this.curPurcQty)) return;
    this.curPurcQty += n;
    let qtyUpdateInterval;
    function stopUpdate() {
      clearInterval(delay);
      clearInterval(qtyUpdateInterval);
      document.onmouseup = null;
    }
    document.onmouseup = stopUpdate;
    let delay = setTimeout(() => {
      qtyUpdateInterval = setInterval(() => {
        if ((this.prdQuant == this.curPurcQty && n == 1) || (n == -1 && this.curPurcQty < 2)) {
          clearInterval(qtyUpdateInterval);
          return;
        }
        this.curPurcQty += n;
      }, 100);
    }, 1000);
  }

  treatImgUrl(img) {
    return this.configService.treatImgUrl(img);
  }

  addToCart(option) {
    // this.cartVarError = null;
    const tempData = {
      pid: this.product.pid,
      quantity: this.curPurcQty,
      variation: this.cartVariation ? this.cartVariation : this.product.variation[0]
    };
    const data = JSON.stringify(tempData);
    if (option == 'addToCart') {
      this.adding = true;
      this.shoppingCartService.addToCart(data).subscribe(res => {
        if (res) {
          this.router.navigateByUrl('/shopping-cart');
        }
        this.adding = false;
      });
    } else {
      this.buying = true;
      this.shoppingCartService.addToCart(data).subscribe(res => {
        if (res) {
          let cartItems = res.items;
          let cartId = -1;
          cartItems.forEach((cart) => {
            if (JSON.stringify(tempData.variation) == JSON.stringify(cart.variation) && tempData.pid == cart.pid) {
              cartId = cart.id;
            }
          });
          const ids = JSON.stringify([cartId]);
          this.checkoutService.postSelectedItems(ids).subscribe(res => {
            if (res) {
              this.router.navigateByUrl('/customer/checkout');
            }
            this.buying = false;
          });
        }
      });
    }
    // const modalRef = this.modalService.open(ViewCartModalComponent, {
    //   centered: true
    // });
    // modalRef.componentInstance.item = item;
  }

}

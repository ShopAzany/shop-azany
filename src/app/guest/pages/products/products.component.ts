import { isPlatformBrowser } from '@angular/common';
import { Component, ElementRef, Inject, OnDestroy, OnInit, PLATFORM_ID, ViewChild } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { AuthService } from 'src/app/data/services/auth.service';
import { WishlistService } from 'src/app/data/services/customer/wishlist.service';
import { GeneralSettingsService } from 'src/app/data/services/general-settings.service';
import { CategoryService } from 'src/app/data/services/guest/category.service';
import { ProductService } from 'src/app/data/services/guest/products.service';
import { ShoppingCartService } from 'src/app/data/services/guest/shopping-cart.service';
import { PaginationService } from 'src/app/data/services/pagination.service';

@Component({
  selector: 'app-products',
  templateUrl: './products.component.html',
  styleUrls: ['./products.component.scss']
})
export class ProductsComponent implements OnInit, OnDestroy {
  @ViewChild('productListingPar') productListingPar: ElementRef;
  checkStatuses = [];
  queryInitiated = false;
  localProds = false;
  pageTitle;
  auth;
  addCartProdName;
  isLoading = true;
  sortStr = null;
  // prodStart = 1;
  // prodEnd = 10;
  prodCount = 0;

  currency;

  updatingFav = { pid: -1, status: false };
  addingCart = { pid: -1, status: false };

  sortFilter = { value: 'popularity', txt: 'Popularity' }
  searchObj;
  headObj = { heading: 'Deals And Promotions', subheading: 'Shop Today’s Deals, See all offers and Limited Time Discounts' };
  mainCat;
  subCat;
  subSubCat;
  subCats;
  subSubCats;
  // catProp;

  page = 1;
  limit = 12;

  products = [];
  paginationLinks = [];

  categoryVariations;
  filters = [];
  eachFilters = [];
  queryStr = '';

  categories;

  productGotten = false;

  get prodStart() {
    return (this.limit * (this.page - 1)) + 1;
  }

  get prodEnd() {
    return this.products.length + (this.limit * (this.page - 1));
  }

  constructor(
    @Inject(PLATFORM_ID) private platformId: Object,
    private router: Router,
    private route: ActivatedRoute,
    private routingService: RoutingService,
    private categoryService: CategoryService,
    private productService: ProductService,
    private generalSettings: GeneralSettingsService,
    private shoppingCartService: ShoppingCartService,
    private wishListService: WishlistService,
    private authService: AuthService,
    private paginationService: PaginationService,
  ) { }

  ngOnInit(): void {
    this.getCurrency();
    this.getCategories();
    this.getAuth();
    const keyword = this.route.snapshot.paramMap.get('keyword');
    const category = this.route.snapshot.paramMap.get('category');
    if (keyword || category) {
      if (keyword) {
        this.getSearch();
      } else {
        this.route.params.subscribe(param => {
          this.mainCat = param.category;
          this.subCat = param.subcategory;
          this.subSubCat = param.subsubcategory;
          this.getCatProperties();
          if (!this.router.url.includes('?')) {
            this.getCatProducts();
          }
        });
      }
    } else {
      let activeRoute = this.routingService.activeRoute.split('?')[0];
      if (activeRoute == 'deals') {
        this.pageTitle = 'today_deals';
        this.headObj.heading = 'Deals And Promotions';
        this.headObj.subheading = 'Shop Today’s Deals, See all offers and Limited Time Discounts';
      } else if (activeRoute == 'recommended') {
        this.pageTitle = 'recommended';
        this.headObj.heading = 'Recommended For You';
        this.headObj.subheading = 'Shop Today’s Deals, See all offers and Limited Time Discounts';
      } else if (activeRoute == 'top-selling') {
        this.pageTitle = 'top_selling';
        this.headObj.heading = 'Top Selling Items';
        this.headObj.subheading = 'Shop Today’s Deals, See all offers and Limited Time Discounts';
      } else if (activeRoute == 'recent') {
        this.pageTitle = 'recently_added';
        this.headObj.heading = 'Recently added to Azany';
        this.headObj.subheading = 'Shop Today’s Deals, See all offers and Limited Time Discounts';
      } else if (activeRoute == 'recently-viewed') {
        this.headObj.heading = 'Recently Viewed Products';
        this.headObj.subheading = 'Shop Today’s Deals, See all offers and Limited Time Discounts';
      } else {
        this.headObj.heading = 'All Categories';
      }
      if (!this.router.url.includes('?')) {
        this.getOtherProducts();
      }
    }
    setTimeout(() => {
      this.initiateQuery();
    });
  }

  private initiateQuery() {
    this.route.queryParams.subscribe(query => {
      let qstr = '?';
      if (this.eachFilters.length) {
        const filters = [...this.eachFilters];
        filters.forEach((filter) => {
          this.removeFilterOnly(filter);
        });
      }
      for (let key in query) {
        qstr += `${key}=${query[key]}&`;
        let eachFilter = {};
        if (query[key].includes('~')) {
          eachFilter[key] = query[key].slice(1).split('~');
          this.filters.push(eachFilter);
          let values = query[key].slice(1).split('~');
          values.forEach(val => {
            this.eachFilters.push({ key: key, value: val });
          });
        } else {
          this.eachFilters.push({ key: key, value: query[key] });
          eachFilter[key] = query[key];
          this.filters.push(eachFilter);
        }
      }
      this.queryStr = qstr.slice(0, -1);
      this.setInputStates(query);
      if (!this.searchObj) {
        if (this.mainCat) {
          this.getCatProducts(query);
        } else {
          this.getOtherProducts(query);
        }
      } else {
        this.getSearchProducts(query);
      }
    });
  }

  private getOtherProducts(query = null) {
    this.isLoading = true;
    let activeRoute = this.routingService.activeRoute.split('?')[0];
    if (activeRoute != 'recently-viewed') {
      this.localProds = false;
      this.productService.getOtherProds(
        this.pageTitle, this.limit, this.page, this.sortStr, this.queryStr
      ).subscribe(res => {
        if (res) {
          this.prodCount = res.count;
          console.log(res);
          this.products = res.data;
          this.paginationLinks = this.paginationService.links(res.count, this.limit, this.page);
          this.assignCatVariations(res);
          this.setInputStates(query);
        }
        this.isLoading = false;
      });
    } else {
      this.localProds = true;
      this.productService.recentlyViewed.subscribe(res => {
        if (res) {
          this.products = res;
          this.prodCount = res.length;
        }
        this.isLoading = false;
      })
    }
  }

  private assignCatVariations(res) {
    let modCatVar = [];
    for (let cat of res.cat_variation) {
      if (cat) {
        cat.value_obj = JSON.parse(cat.value_obj);
        cat.value_obj.forEach((each) => {
          each.values.forEach((each2, i) => {
            each.values.splice(i, 1, each2.trim());
          });
        });
        modCatVar.push(cat);
      }
    }
    let modCatVar2 = [];
    for (let i = 0; i < modCatVar.length; i++) {
      if (!modCatVar2.length) {
        modCatVar[i].value_obj.forEach((each) => {
          modCatVar2.push(each);
        });
      } else {
        let varExist = [];
        modCatVar[i].value_obj.forEach((each, j) => {
          modCatVar2.forEach((each2, k) => {
            if (each.name == each2.name) {
              varExist.push(each.name);
              each.values.forEach((val, l) => {
                if (!each2.values.includes(val)) {
                  each2.values.push(val);
                }
              });
            }
          });
        });
        modCatVar[i].value_obj.forEach((each) => {
          if (!varExist.includes(each.name)) {
            modCatVar2.push(each);
          }
        });
        // }
      }
    }
    if (!this.categoryVariations || JSON.stringify(this.categoryVariations) != JSON.stringify(modCatVar2)) {
      this.categoryVariations = modCatVar2;
    }
  }

  ngOnDestroy() {
    // this.categoryService.setSearchKeyword(null);
  }

  private getCurrency() {
    this.generalSettings.genSettings.subscribe(res => {
      if (res) {
        this.currency = res.currency.symbol;
      }
    });
  }

  private getAuth() {
    this.authService.customer.subscribe(auth => {
      this.auth = auth;
    });
  }

  private getCatProperties() {
    if (this.categories && this.categories.length) {
      let catname, catdesc;
      for (let i = 0; i < this.categories.length; i++) {
        if (!this.subCat) {
          if (this.categories[i].mainCats.cat_slug == this.mainCat) {
            catname = this.categories[i].mainCats.cat_name;
            catdesc = this.categories[i].mainCats.cat_desc;
            this.subCats = this.categories[i].Subcategories;
          }
        } else {
          for (let j = 0; j < this.categories[i].Subcategories.length; j++) {
            if (!this.subSubCat) {
              if (this.categories[i].Subcategories[j].Subcategory.subcat_slug == this.subCat && this.categories[i].mainCats.cat_slug == this.mainCat) {
                catname = this.categories[i].Subcategories[j].Subcategory.subcat_name;
                catdesc = this.categories[i].mainCats.cat_desc;
                // this.subCats = null;
                this.subSubCats = this.categories[i].Subcategories[j].SubSubcategories;
              }
            } else {
              for (let k = 0; k < this.categories[i].Subcategories[j].SubSubcategories.length; k++) {
                if (this.categories[i].mainCats.cat_slug == this.mainCat && this.categories[i].Subcategories[j].Subcategory.subcat_slug == this.subCat && this.categories[i].Subcategories[j].SubSubcategories[k].sub_subcat_slug == this.subSubCat) {
                  catname = this.categories[i].Subcategories[j].SubSubcategories[k].sub_subcat_name;
                  catdesc = this.categories[i].mainCats.cat_desc;
                  this.subSubCats = this.categories[i].Subcategories[j].SubSubcategories;
                }
              }
            }
          }
        }
      }
      this.headObj.heading = catname;
      this.headObj.subheading = catdesc;
    } else {
      setTimeout(() => {
        this.getCatProperties();
      });
    }
  }

  private getCategories() {
    this.categoryService.headerCategories.subscribe(res => {
      if (res) {
        this.categories = res;
      }
    });
  }

  private getCatProducts(query = null) {
    this.localProds = false;
    this.isLoading = true;
    const cat = this.subSubCat || this.subCat || this.mainCat;
    this.productService.getCatProd(cat, this.page, this.limit, this.sortStr, this.queryStr).subscribe(res => {
      this.products = res.data;
      this.prodCount = res.count;
      if (JSON.stringify(this.categoryVariations) != JSON.stringify(res.categoryVariations)) {
        this.categoryVariations = res.categoryVariations;
      }
      this.paginationLinks = this.paginationService.links(res.count, this.limit, this.page);
      // this.setInputStates(query);
      this.isLoading = false;
    });
  }

  private setInputStates(query) {
    if (query) {
      try {
        for (let key in query) {
          if (query[key].includes('~')) {
            let values = query[key].slice(1).split('~');
            values.forEach((val, i) => {
              let eachCheckBox = this.productListingPar.nativeElement.querySelector(`input[value*="${key}|"][value$="${val}"]`);
              eachCheckBox.checked = true;
            });
          } else {
            let eachCheckBox = this.productListingPar.nativeElement.querySelector(`input[value*="${key}|"][value$="${query[key]}"]`);
            eachCheckBox.checked = true;
          }
        }
        this.eachFilters.forEach(each => {
          let { key, value } = each;
          let txt = this.productListingPar.nativeElement.querySelector(`input[value*="${key}|"][value$="${value}"]`).parentElement.querySelector('span').innerHTML;
          each.txt = txt;
        });
      } catch (e) {
        setTimeout(() => {
          this.setInputStates(query);
        });
      }
    }
  }

  isNaN(txt) {
    return isNaN(+txt);
  }

  clearQuery() {
    const filters = [...this.eachFilters];
    filters.forEach((filter) => {
      this.removeFilterOnly(filter);
    });
    this.applyUrl();
  }

  removeFilterOnly(filter) {
    let checkInd = -1
    let radioInd = -1;
    let eachInd = -1;
    let { key, value } = filter;
    this.eachFilters.forEach((each, i) => {
      if (each.key == key && each.value == value) {
        eachInd = i;
      }
    });
    const eachInp = this.productListingPar.nativeElement.querySelector(`input[value*="${key}|"][value$="${value}"]`);
    eachInp.checked = false;
    this.eachFilters.splice(eachInd, 1);
    this.filters.forEach((each, i) => {
      // radio check;
      if (each.hasOwnProperty(key) && typeof each[key] == 'string') {
        radioInd = i;
      }
      // checkbox check;
      if (each.hasOwnProperty(key) && typeof each[key] != 'string') {
        checkInd = i;
      }
    });
    if (radioInd > -1) {
      this.filters.splice(radioInd, 1);
    }
    if (checkInd > -1) {
      let values = this.filters[checkInd][key];
      values.splice(values.indexOf(value), 1);
      if (values.length) {
        this.filters[checkInd][key] = values;
      } else {
        this.filters.splice(checkInd, 1);
      }
    }
  }

  removeFilter(filter) {
    this.removeFilterOnly(filter);
    this.applyUrl();
  }

  selectFilter(el) {
    let [name, slug, value] = el.value.split('|');
    let key = slug || name;
    let txt = el.parentElement.querySelector('span').innerHTML;
    let matchInd = -1;
    this.filters.forEach((each, i) => {
      if (each.hasOwnProperty(key)) {
        matchInd = i;
      }
    });
    let eachInd = -1;
    this.eachFilters.forEach((each, i) => {
      if (each.key == key && each.value == value) {
        eachInd = i;
      }
    });
    if (el.type == 'checkbox') {
      if (el.checked) {
        this.eachFilters.push({ key: key, value: value, txt: txt });
        if (matchInd > -1) {
          let values = this.filters[matchInd][key];
          values.push(value);
          this.filters[matchInd][key] = values;
        } else {
          let eachArrFilter = {};
          eachArrFilter[key] = [value];
          this.filters.push(eachArrFilter);
        }
      } else {
        if (eachInd > -1) {
          this.eachFilters.splice(eachInd, 1);
        }
        let values = this.filters[matchInd][key];
        let valInd = values.indexOf(value);
        values.splice(valInd, 1);
        if (values.length) {
          this.filters[matchInd][key] = values;
        } else {
          this.filters.splice(matchInd, 1);
        }
      }
    } else {
      if (el.checked) {
        this.eachFilters.forEach((each, i) => {
          if (each.key == key) {
            eachInd = i;
          }
        });
        if (eachInd > -1) {
          this.eachFilters.splice(eachInd, 1, { key: key, value: value, txt: txt });
        } else {
          this.eachFilters.push({ key: key, value: value, txt: txt });
        }
        if (matchInd > -1) {
          this.filters[matchInd][key] = value;
        } else {
          let eachFilter = {};
          eachFilter[key] = value;
          this.filters.push(eachFilter);
        }
      }
    }
    this.applyUrl();
  }

  applyUrl() {
    let qstr = this.filters.map((each) => {
      let key = Object.keys(each)[0];
      let value = each[key];
      let strVal = typeof value == 'object' ? `~${value.join('~')}` : value;
      return `${key}=${strVal}`;
    });
    let queryParam = {};
    this.queryStr = `?${qstr.join('&')}`;
    let qArr = this.queryStr.replace('?', '').split('&');
    qArr.forEach(qgroup => {
      let [key, value] = qgroup.split('=');
      queryParam[key] = value;
    });
    this.productListingPar.nativeElement.scrollIntoView();
    this.router.navigate([`${this.router.url.split('?')[0]}`], { queryParams: queryParam });
  }

  urlValue(val) {
    return encodeURIComponent(val.trim().replace(/\s/g, '_'));
  }

  setCurrPage(toPage, gridCont) {
    this.page = toPage;
    if (this.mainCat) {
      this.getCatProducts();
    } else if (this.searchObj) {
      this.getSearchProducts();
    } else {
      this.getOtherProducts();
    }
    gridCont.scrollIntoView();
  }

  private getSearch() {
    this.categoryService.getSearchObj.subscribe(res => {
      if (res) {
        this.searchObj = res;
        this.headObj.heading = `Search Results for “${res.keyword}”`;
        this.headObj.subheading = 'Shop Today’s Deals, See all offers and Limited Time Discounts';
        if (!this.router.url.includes('?')) {
          this.getSearchProducts();
        }
      }
    });
  }

  private getSearchProducts(query = null) {
    this.localProds = false;
    this.isLoading = true;
    let { category, keyword } = this.searchObj;
    this.productService.search(category, keyword, this.limit, this.page, this.sortStr, this.queryStr).subscribe(res => {
      if (res) {
        this.products = res.data;
        this.prodCount = res.count;
        this.paginationLinks = this.paginationService.links(res.count, this.limit, this.page);
        this.assignCatVariations(res);
        this.setInputStates(query);
      }
      this.isLoading = false;
    });
  }

  applySort(val, e) {
    this.sortFilter = { value: val, txt: e.target.innerHTML };
    this.sortStr = this.sortFilter.value;
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
          if (res && res.status == 'success') {
            this.products.forEach(each => {
              if (each.pid == prod.pid) {
                each.isFavorite = 1;
              }
            });
          }
          this.updatingFav = { pid: -1, status: false };
        });
      } else {
        this.wishListService.removeFavorite(prod.pid).subscribe(res => {
          if (res && res.status == 'success') {
            this.products.forEach(each => {
              if (each.pid == prod.pid) {
                each.isFavorite = 0;
              }
            });
          }
          this.updatingFav = { pid: -1, status: false };
        });
      }
    } else {
      this.router.navigateByUrl('/login');
    }
  }

}

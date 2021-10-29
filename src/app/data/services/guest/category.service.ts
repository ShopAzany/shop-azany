import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { take, tap, filter, delay } from 'rxjs/operators';
import { Subject, Observable, BehaviorSubject } from 'rxjs';

import { Category, SubCategory } from '../../model/category';
import { ConfigService } from '../config.service';
import { AdminAuthService } from '../admin-auth.service';

@Injectable({ providedIn: 'root' })
export class CategoryService {
  private serverUrl: string;
  private adminUrl: string;
  private token: string;
  private _category = new BehaviorSubject<any>(null);
  private subject = new Subject<any>();
  private _keyword = new BehaviorSubject<any>(null);
  private _categories = new BehaviorSubject<any>(null);

  constructor(
    private http: HttpClient,
    private config: ConfigService,
    private adminAuthService: AdminAuthService,
  ) {
    this.serverUrl = this.config.base_url();
    this.adminUrl = this.config.adminURL;

    this.adminAuthService.admin.subscribe(auth => {
      if (auth) { this.token = auth.token; }
    });
  }

  private requestHeader() {
    const headers = new HttpHeaders({
      /* 'AuthKey': 'my-key',
      'AuthToken': 'my-token', */
      'Content-Type': 'application/json',
    });
    return headers;
  }

  setSearchKeyword(searchObj) {
    this._keyword.next(searchObj);
  }

  get getSearchObj() {
    return this._keyword;
  }

  get categories() {
    return this._category;
  }

  get headerCategories() {
    return this._categories.asObservable();
  }

  getCategories() {
    return this.http.get<any>(this.serverUrl + 'categories/catBySlugs')
  }

  getHeaderCategories() {
    return this.http.get<any>(
      `${this.serverUrl}/categories`
    ).pipe(tap(res => {
      this._categories.next(res);
    }));
    this._categories.next([
      {
        cat_name: 'Fashion',
        cat_icon: `<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.33333 37.3333H35.6667C35.9056 37.3334 36.1417 37.282 36.359 37.1828C36.5763 37.0836 36.7697 36.9389 36.9262 36.7584C37.0827 36.5779 37.1986 36.3659 37.2659 36.1367C37.3333 35.9075 37.3506 35.6665 37.3167 35.43L33.9833 12.0967C33.9264 11.6997 33.7282 11.3365 33.4251 11.0739C33.122 10.8112 32.7344 10.6666 32.3333 10.6667H27.3333V9C27.3333 6.78987 26.4554 4.67025 24.8926 3.10745C23.3298 1.54465 21.2101 0.666672 19 0.666672C16.7899 0.666672 14.6702 1.54465 13.1074 3.10745C11.5446 4.67025 10.6667 6.78987 10.6667 9V10.6667H5.66667C5.2656 10.6666 4.87797 10.8112 4.57489 11.0739C4.27181 11.3365 4.07362 11.6997 4.01667 12.0967L0.683332 35.43C0.64941 35.6665 0.666718 35.9075 0.734082 36.1367C0.801447 36.3659 0.917295 36.5779 1.07377 36.7584C1.23025 36.9389 1.42371 37.0836 1.64102 37.1828C1.85834 37.282 2.09444 37.3334 2.33333 37.3333ZM14 9C14 7.67392 14.5268 6.40215 15.4645 5.46447C16.4021 4.52679 17.6739 4 19 4C20.3261 4 21.5979 4.52679 22.5355 5.46447C23.4732 6.40215 24 7.67392 24 9V10.6667H14V9ZM7.11167 14H10.6667V19C10.6667 19.442 10.8423 19.866 11.1548 20.1785C11.4674 20.4911 11.8913 20.6667 12.3333 20.6667C12.7754 20.6667 13.1993 20.4911 13.5118 20.1785C13.8244 19.866 14 19.442 14 19V14H24V19C24 19.442 24.1756 19.866 24.4882 20.1785C24.8007 20.4911 25.2246 20.6667 25.6667 20.6667C26.1087 20.6667 26.5326 20.4911 26.8452 20.1785C27.1577 19.866 27.3333 19.442 27.3333 19V14H30.8883L33.745 34H4.255L7.11167 14Z" fill="#505050"/>
        </svg>      
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'fashion',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
      {
        cat_name: 'Electronics',
        cat_icon: `<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M35.6667 7.33334H23.0234L26.845 3.51167C27.1486 3.19733 27.3166 2.77633 27.3128 2.33933C27.309 1.90234 27.1337 1.48432 26.8247 1.1753C26.5157 0.866291 26.0977 0.691009 25.6607 0.687212C25.2237 0.683415 24.8027 0.851405 24.4884 1.155L19 6.64334L15.1784 2.82167C14.864 2.51807 14.443 2.35008 14.006 2.35388C13.569 2.35768 13.151 2.53296 12.842 2.84197C12.533 3.15098 12.3577 3.56901 12.3539 4.006C12.3501 4.44299 12.5181 4.864 12.8217 5.17834L14.9767 7.33334H2.33335C1.89133 7.33334 1.4674 7.50893 1.15484 7.82149C0.842282 8.13405 0.666687 8.55798 0.666687 9V35.6667C0.666687 36.1087 0.842282 36.5326 1.15484 36.8452C1.4674 37.1577 1.89133 37.3333 2.33335 37.3333H35.6667C36.1087 37.3333 36.5326 37.1577 36.8452 36.8452C37.1578 36.5326 37.3334 36.1087 37.3334 35.6667V9C37.3334 8.55798 37.1578 8.13405 36.8452 7.82149C36.5326 7.50893 36.1087 7.33334 35.6667 7.33334ZM34 34H4.00002V10.6667H34V34ZM10.6667 14V30.6667C10.6667 31.1087 10.8423 31.5326 11.1548 31.8452C11.4674 32.1577 11.8913 32.3333 12.3334 32.3333H30.6667C31.1087 32.3333 31.5326 32.1577 31.8452 31.8452C32.1578 31.5326 32.3334 31.1087 32.3334 30.6667V14C32.3334 13.558 32.1578 13.1341 31.8452 12.8215C31.5326 12.5089 31.1087 12.3333 30.6667 12.3333H12.3334C11.8913 12.3333 11.4674 12.5089 11.1548 12.8215C10.8423 13.1341 10.6667 13.558 10.6667 14ZM14 15.6667H29V29H14V15.6667ZM9.00002 14V19C9.00002 19.442 8.82442 19.866 8.51186 20.1785C8.1993 20.4911 7.77538 20.6667 7.33335 20.6667C6.89133 20.6667 6.4674 20.4911 6.15484 20.1785C5.84228 19.866 5.66669 19.442 5.66669 19V14C5.66669 13.558 5.84228 13.1341 6.15484 12.8215C6.4674 12.5089 6.89133 12.3333 7.33335 12.3333C7.77538 12.3333 8.1993 12.5089 8.51186 12.8215C8.82442 13.1341 9.00002 13.558 9.00002 14ZM9.00002 24V30.6667C9.00002 31.1087 8.82442 31.5326 8.51186 31.8452C8.1993 32.1577 7.77538 32.3333 7.33335 32.3333C6.89133 32.3333 6.4674 32.1577 6.15484 31.8452C5.84228 31.5326 5.66669 31.1087 5.66669 30.6667V24C5.66669 23.558 5.84228 23.1341 6.15484 22.8215C6.4674 22.5089 6.89133 22.3333 7.33335 22.3333C7.77538 22.3333 8.1993 22.5089 8.51186 22.8215C8.82442 23.1341 9.00002 23.558 9.00002 24Z" fill="#505050"/>
        </svg>    
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'electronics',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
      {
        cat_name: 'Food & Grocery',
        cat_icon: `<svg width="31" height="38" viewBox="0 0 31 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0.488333 21.845C0.175882 21.5325 0.000356038 21.1086 0.000356038 20.6667C0.000356038 20.2247 0.175882 19.8009 0.488333 19.4883L3.82167 16.155C4.13421 15.8425 4.55806 15.667 5 15.667C5.44194 15.667 5.86579 15.8425 6.17833 16.155L8.33333 18.31L10.4883 16.155C10.8009 15.8425 11.2247 15.667 11.6667 15.667C12.1086 15.667 12.5325 15.8425 12.845 16.155L15 18.31L17.155 16.155C17.4675 15.8425 17.8914 15.667 18.3333 15.667C18.7753 15.667 19.1991 15.8425 19.5117 16.155L21.6667 18.31L23.8217 16.155C24.1342 15.8425 24.5581 15.667 25 15.667C25.4419 15.667 25.8658 15.8425 26.1783 16.155L29.5117 19.4883C29.6709 19.6421 29.7978 19.826 29.8852 20.0293C29.9725 20.2327 30.0185 20.4514 30.0204 20.6727C30.0223 20.894 29.9802 21.1134 29.8964 21.3183C29.8126 21.5231 29.6888 21.7092 29.5323 21.8657C29.3758 22.0221 29.1897 22.1459 28.9849 22.2297C28.7801 22.3135 28.5606 22.3557 28.3393 22.3537C28.118 22.3518 27.8993 22.3059 27.696 22.2185C27.4927 22.1312 27.3087 22.0042 27.155 21.845L25 19.69L22.845 21.845C22.5325 22.1574 22.1086 22.333 21.6667 22.333C21.2247 22.333 20.8009 22.1574 20.4883 21.845L18.3333 19.69L16.1783 21.845C15.8658 22.1574 15.4419 22.333 15 22.333C14.5581 22.333 14.1342 22.1574 13.8217 21.845L11.6667 19.69L9.51167 21.845C9.19912 22.1574 8.77527 22.333 8.33333 22.333C7.89139 22.333 7.46755 22.1574 7.155 21.845L5 19.69L2.845 21.845C2.53245 22.1574 2.10861 22.333 1.66667 22.333C1.22473 22.333 0.800879 22.1574 0.488333 21.845ZM0 12.3333C0.00352894 9.24022 1.23383 6.27481 3.42099 4.08765C5.60815 1.90049 8.57356 0.670196 11.6667 0.666667H18.3333C21.4264 0.670196 24.3919 1.90049 26.579 4.08765C28.7662 6.27481 29.9965 9.24022 30 12.3333C30 12.7754 29.8244 13.1993 29.5118 13.5118C29.1993 13.8244 28.7754 14 28.3333 14H1.66667C1.22464 14 0.800716 13.8244 0.488155 13.5118C0.175595 13.1993 0 12.7754 0 12.3333ZM3.5 10.6667H26.5C26.1135 8.78554 25.0901 7.09525 23.6024 5.88082C22.1147 4.66639 20.2538 4.00211 18.3333 4H11.6667C9.74624 4.00211 7.88529 4.66639 6.39761 5.88082C4.90993 7.09525 3.88654 8.78554 3.5 10.6667ZM0 25.6667C0 25.2246 0.175595 24.8007 0.488155 24.4882C0.800716 24.1756 1.22464 24 1.66667 24H15C15.2743 24 15.5444 24.0676 15.7863 24.197C16.0282 24.3264 16.2344 24.5135 16.3867 24.7417L18.3333 27.6667L20.28 24.7467C20.4317 24.5175 20.6376 24.3295 20.8796 24.1992C21.1215 24.0689 21.3919 24.0005 21.6667 24H28.3333C28.7754 24 29.1993 24.1756 29.5118 24.4882C29.8244 24.8007 30 25.2246 30 25.6667C29.9965 28.7598 28.7662 31.7252 26.579 33.9123C24.3919 36.0995 21.4264 37.3298 18.3333 37.3333H11.6667C8.57356 37.3298 5.60815 36.0995 3.42099 33.9123C1.23383 31.7252 0.00352894 28.7598 0 25.6667ZM3.5 27.3333C3.88654 29.2145 4.90993 30.9047 6.39761 32.1192C7.88529 33.3336 9.74624 33.9979 11.6667 34H18.3333C20.2538 33.9979 22.1147 33.3336 23.6024 32.1192C25.0901 30.9047 26.1135 29.2145 26.5 27.3333H22.5583L19.725 31.5917C19.5638 31.8072 19.3545 31.9822 19.1138 32.1028C18.873 32.2233 18.6075 32.2861 18.3383 32.2861C18.0691 32.2861 17.8036 32.2233 17.5629 32.1028C17.3222 31.9822 17.1129 31.8072 16.9517 31.5917L14.1083 27.3333H3.5Z" fill="#505050"/>
        </svg>    
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'food-and-grocery',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
      {
        cat_name: 'Beauty & Health',
        cat_icon: `<svg width="20" height="38" viewBox="0 0 20 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 0.666664C4.55797 0.666664 4.13405 0.842259 3.82149 1.15482C3.50893 1.46738 3.33333 1.8913 3.33333 2.33333V17.3333H1.66667C1.22464 17.3333 0.800716 17.5089 0.488156 17.8215C0.175595 18.134 0 18.558 0 19V35.6667C0 36.1087 0.175595 36.5326 0.488156 36.8452C0.800716 37.1577 1.22464 37.3333 1.66667 37.3333H18.3333C18.7754 37.3333 19.1993 37.1577 19.5118 36.8452C19.8244 36.5326 20 36.1087 20 35.6667V19C20 18.558 19.8244 18.134 19.5118 17.8215C19.1993 17.5089 18.7754 17.3333 18.3333 17.3333H16.6667V12.3333C16.6631 9.24022 15.4328 6.27481 13.2457 4.08765C11.0585 1.90049 8.09311 0.670193 5 0.666664ZM6.66667 4.16666C8.54779 4.5532 10.2381 5.57659 11.4525 7.06427C12.6669 8.55195 13.3312 10.4129 13.3333 12.3333V17.3333H6.66667V4.16666ZM5 20.6667H16.6667V24H3.33333V20.6667H5ZM3.33333 34V27.3333H16.6667V34H3.33333Z" fill="#505050"/>
        </svg>    
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'beauty-and-health',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
      {
        cat_name: 'Home & Office',
        cat_icon: `<svg width="38" height="30" viewBox="0 0 38 30" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M34 15.3067V1.66667C34 1.22464 33.8244 0.800716 33.5119 0.488155C33.1993 0.175595 32.7754 0 32.3334 0C31.8913 0 31.4674 0.175595 31.1548 0.488155C30.8423 0.800716 30.6667 1.22464 30.6667 1.66667V3.33333H7.33335V1.66667C7.33335 1.22464 7.15776 0.800716 6.8452 0.488155C6.53264 0.175595 6.10871 0 5.66669 0C5.22466 0 4.80074 0.175595 4.48818 0.488155C4.17561 0.800716 4.00002 1.22464 4.00002 1.66667V15.3067C3.02851 15.6501 2.18684 16.2854 1.59017 17.1255C0.993493 17.9656 0.670959 18.9696 0.666687 20V28.3333C0.666687 28.7754 0.842282 29.1993 1.15484 29.5118C1.4674 29.8244 1.89133 30 2.33335 30C2.77538 30 3.1993 29.8244 3.51186 29.5118C3.82443 29.1993 4.00002 28.7754 4.00002 28.3333V26.6667H34V28.3333C34 28.7754 34.1756 29.1993 34.4882 29.5118C34.8007 29.8244 35.2247 30 35.6667 30C36.1087 30 36.5326 29.8244 36.8452 29.5118C37.1578 29.1993 37.3334 28.7754 37.3334 28.3333V20C37.3291 18.9696 37.0065 17.9656 36.4099 17.1255C35.8132 16.2854 34.9715 15.6501 34 15.3067ZM30.6667 15H29V11.6667C29 11.2246 28.8244 10.8007 28.5119 10.4882C28.1993 10.1756 27.7754 10 27.3334 10H10.6667C10.2247 10 9.80074 10.1756 9.48818 10.4882C9.17561 10.8007 9.00002 11.2246 9.00002 11.6667V15H7.33335V6.66667H30.6667V15ZM12.3334 15V13.3333H17.3334V15H12.3334ZM20.6667 13.3333H25.6667V15H20.6667V13.3333ZM4.00002 20C4.00002 19.558 4.17561 19.134 4.48818 18.8215C4.80074 18.5089 5.22466 18.3333 5.66669 18.3333H32.3334C32.7754 18.3333 33.1993 18.5089 33.5119 18.8215C33.8244 19.134 34 19.558 34 20V23.3333H4.00002V20Z" fill="#505050"/>
        </svg>    
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'home-and-office',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
      {
        cat_name: 'Sports',
        cat_icon: `<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M19 37.3333C22.626 37.3333 26.1706 36.2581 29.1855 34.2436C32.2004 32.2291 34.5502 29.3658 35.9378 26.0159C37.3254 22.6659 37.6885 18.9797 36.9811 15.4233C36.2737 11.867 34.5276 8.60034 31.9636 6.03638C29.3997 3.47241 26.133 1.72633 22.5767 1.01893C19.0204 0.311539 15.3341 0.6746 11.9842 2.06221C8.63418 3.44981 5.7709 5.79964 3.75641 8.81454C1.74192 11.8294 0.666687 15.374 0.666687 19C0.686868 23.8561 2.62489 28.5075 6.05869 31.9413C9.49249 35.3751 14.1439 37.3132 19 37.3333ZM12.3334 32.4167C10.7034 31.6014 9.23514 30.4968 8.00002 29.1567C8.50581 28.9974 9.04228 28.9612 9.5649 29.0509C10.0875 29.1406 10.5812 29.3537 11.0049 29.6724C11.4287 29.9912 11.7702 30.4065 12.0013 30.8838C12.2323 31.3611 12.3462 31.8866 12.3334 32.4167ZM25.6667 32.4167C25.6539 31.8866 25.7677 31.3611 25.9988 30.8838C26.2298 30.4065 26.5714 29.9912 26.9951 29.6724C27.4189 29.3537 27.9125 29.1406 28.4351 29.0509C28.9578 28.9612 29.4942 28.9974 30 29.1567C28.7659 30.4979 27.2974 31.6026 25.6667 32.4167ZM31.2817 10.4167C32.3763 11.9978 33.1649 13.7701 33.6067 15.6417C33.0353 15.5717 32.4918 15.3549 32.0291 15.0125C31.5664 14.6701 31.2002 14.2137 30.9663 13.6878C30.7323 13.1618 30.6386 12.5842 30.6941 12.0113C30.7497 11.4383 30.9527 10.8895 31.2834 10.4183L31.2817 10.4167ZM21.7067 4.25C21.4015 4.68498 20.9961 5.04007 20.5247 5.28521C20.0532 5.53035 19.5297 5.65833 18.9984 5.65833C18.467 5.65833 17.9435 5.53035 17.472 5.28521C17.0006 5.04007 16.5952 4.68498 16.29 4.25C18.0809 3.91558 19.9185 3.9184 21.7084 4.25833L21.7067 4.25ZM6.70669 10.4167C7.038 10.8873 7.2418 11.4358 7.29824 12.0086C7.35467 12.5814 7.26182 13.159 7.02872 13.6853C6.79563 14.2116 6.43023 14.6685 5.96811 15.0117C5.50598 15.3548 4.96288 15.5724 4.39169 15.6433C4.8134 13.765 5.60366 11.989 6.71669 10.4183L6.70669 10.4167ZM8.94002 7.90666C10.1512 6.7998 11.5357 5.89896 13.0384 5.24C13.5763 6.36495 14.4216 7.31472 15.4766 7.97959C16.5315 8.64445 17.753 8.99726 19 8.99726C20.247 8.99726 21.4685 8.64445 22.5235 7.97959C23.5784 7.31472 24.4237 6.36495 24.9617 5.24C26.4643 5.89896 27.8488 6.7998 29.06 7.90666C28.1997 8.86139 27.6347 10.0451 27.4334 11.3144C27.2322 12.5837 27.4033 13.8842 27.9261 15.0582C28.4489 16.2322 29.301 17.2294 30.379 17.9291C31.4571 18.6287 32.7149 19.0007 34 19C33.9997 21.6053 33.3159 24.165 32.0167 26.4233C30.9103 25.8511 29.6651 25.6023 28.4238 25.7054C27.1825 25.8085 25.9954 26.2594 24.9986 27.0063C24.0018 27.7533 23.2357 28.766 22.7882 29.9284C22.3407 31.0908 22.2298 32.3558 22.4684 33.5783C20.1903 34.1406 17.8097 34.1406 15.5317 33.5783C15.7702 32.3558 15.6594 31.0908 15.2118 29.9284C14.7643 28.766 13.9982 27.7533 13.0014 27.0063C12.0047 26.2594 10.8176 25.8085 9.57625 25.7054C8.33495 25.6023 7.08971 25.8511 5.98335 26.4233C4.68419 24.165 4.00031 21.6053 4.00002 19C5.28519 19.0007 6.54298 18.6287 7.62102 17.9291C8.69907 17.2294 9.5511 16.2322 10.0739 15.0582C10.5967 13.8842 10.7679 12.5837 10.5666 11.3144C10.3654 10.0451 9.80034 8.86139 8.94002 7.90666ZM19 25.6667C20.3186 25.6667 21.6075 25.2757 22.7038 24.5431C23.8001 23.8106 24.6546 22.7694 25.1592 21.5512C25.6638 20.333 25.7958 18.9926 25.5386 17.6994C25.2814 16.4062 24.6464 15.2183 23.7141 14.286C22.7817 13.3536 21.5938 12.7187 20.3006 12.4614C19.0074 12.2042 17.667 12.3362 16.4488 12.8408C15.2306 13.3454 14.1894 14.1999 13.4569 15.2962C12.7243 16.3925 12.3334 17.6815 12.3334 19C12.3334 20.7681 13.0357 22.4638 14.286 23.714C15.5362 24.9643 17.2319 25.6667 19 25.6667ZM19 15.6667C19.6593 15.6667 20.3038 15.8622 20.8519 16.2284C21.4001 16.5947 21.8273 17.1153 22.0796 17.7244C22.3319 18.3335 22.3979 19.0037 22.2693 19.6503C22.1407 20.2969 21.8232 20.8908 21.357 21.357C20.8909 21.8232 20.2969 22.1407 19.6503 22.2693C19.0037 22.3979 18.3335 22.3319 17.7244 22.0796C17.1153 21.8273 16.5947 21.4001 16.2285 20.8519C15.8622 20.3037 15.6667 19.6593 15.6667 19C15.6667 18.1159 16.0179 17.2681 16.643 16.643C17.2681 16.0179 18.116 15.6667 19 15.6667Z" fill="#505050"/>
        </svg>    
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'sports',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
      {
        cat_name: 'Automobile',
        cat_icon: `<svg width="38" height="30" viewBox="0 0 38 30" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M32.3334 11.6667H31.765L27.6334 2.02333C27.3768 1.42297 26.9495 0.911179 26.4046 0.551483C25.8598 0.191787 25.2212 2.51179e-05 24.5683 0H6.92335C6.19945 0.00223639 5.49578 0.239137 4.91792 0.675163C4.34006 1.11119 3.91916 1.72283 3.71835 2.41833L0.73002 12.8767C0.72388 12.9381 0.721098 12.9999 0.721687 13.0617C0.694905 13.1503 0.676491 13.2413 0.666687 13.3333V21.6667C0.666687 22.5507 1.01788 23.3986 1.643 24.0237C2.26812 24.6488 3.11597 25 4.00002 25H4.23669C4.60047 26.4293 5.43012 27.6967 6.59455 28.6018C7.75898 29.507 9.19181 29.9984 10.6667 29.9984C12.1416 29.9984 13.5744 29.507 14.7388 28.6018C15.9033 27.6967 16.7329 26.4293 17.0967 25H20.9034C21.2671 26.4293 22.0968 27.6967 23.2612 28.6018C24.4256 29.507 25.8585 29.9984 27.3334 29.9984C28.8082 29.9984 30.2411 29.507 31.4055 28.6018C32.5699 27.6967 33.3996 26.4293 33.7634 25H34C34.8841 25 35.7319 24.6488 36.357 24.0237C36.9822 23.3986 37.3334 22.5507 37.3334 21.6667V16.6667C37.3334 15.3406 36.8066 14.0688 35.8689 13.1311C34.9312 12.1935 33.6594 11.6667 32.3334 11.6667ZM19 3.33333H24.5683L28.1384 11.6667H19V3.33333ZM6.92335 3.33333H15.6667V11.6667H4.54169L6.92335 3.33333ZM10.6667 26.6667C10.0074 26.6667 9.36295 26.4712 8.81479 26.1049C8.26662 25.7386 7.83938 25.218 7.58709 24.6089C7.3348 23.9999 7.26878 23.3296 7.3974 22.683C7.52602 22.0364 7.84349 21.4425 8.30966 20.9763C8.77584 20.5101 9.36978 20.1927 10.0164 20.0641C10.663 19.9354 11.3332 20.0014 11.9423 20.2537C12.5514 20.506 13.072 20.9333 13.4383 21.4814C13.8045 22.0296 14 22.6741 14 23.3333C14 24.2174 13.6488 25.0652 13.0237 25.6904C12.3986 26.3155 11.5507 26.6667 10.6667 26.6667ZM27.3334 26.6667C26.6741 26.6667 26.0296 26.4712 25.4815 26.1049C24.9333 25.7386 24.506 25.218 24.2538 24.6089C24.0015 23.9999 23.9354 23.3296 24.0641 22.683C24.1927 22.0364 24.5102 21.4425 24.9763 20.9763C25.4425 20.5101 26.0364 20.1927 26.6831 20.0641C27.3297 19.9354 27.9999 20.0014 28.609 20.2537C29.2181 20.506 29.7386 20.9333 30.1049 21.4814C30.4712 22.0296 30.6667 22.6741 30.6667 23.3333C30.6667 24.2174 30.3155 25.0652 29.6904 25.6904C29.0653 26.3155 28.2174 26.6667 27.3334 26.6667ZM34 21.6667H33.7634C33.3996 20.2374 32.5699 18.97 31.4055 18.0648C30.2411 17.1596 28.8082 16.6682 27.3334 16.6682C25.8585 16.6682 24.4256 17.1596 23.2612 18.0648C22.0968 18.97 21.2671 20.2374 20.9034 21.6667H17.0967C16.7329 20.2374 15.9033 18.97 14.7388 18.0648C13.5744 17.1596 12.1416 16.6682 10.6667 16.6682C9.19181 16.6682 7.75898 17.1596 6.59455 18.0648C5.43012 18.97 4.60047 20.2374 4.23669 21.6667H4.00002V15H32.3334C32.7754 15 33.1993 15.1756 33.5119 15.4882C33.8244 15.8007 34 16.2246 34 16.6667V21.6667Z" fill="#505050"/>
        </svg>        
        `,
        cat_img: 'assets/images/Vector.png',
        cat_desc: 'Clothing, Shoes, Jewelry & Watches',
        cat_slug: 'automobile',
        cat_subcategories: [
          {
            subcat_name: 'Men’s Fashion',
            subcat_slug: 'mens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Suits', subsubcat_slug: 'suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Women’s Fashion',
            subcat_slug: 'womens-fashion',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Skirts', subsubcat_slug: 'skirts' },
              { subsubcat_name: 'Gowns', subsubcat_slug: 'gowns' },
              { subsubcat_name: 'Jump Suits', subsubcat_slug: 'jump-suits' },
              { subsubcat_name: 'Sneakers', subsubcat_slug: 'sneakers' },
            ],
          },
          {
            subcat_name: 'Kids & Children',
            subcat_slug: 'kids-and-children',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Trousers', subsubcat_slug: 'trousers' },
              { subsubcat_name: 'Round necks', subsubcat_slug: 'round-necks' },
            ],
          },
          {
            subcat_name: 'Baby',
            subcat_slug: 'baby',
            subcat_subcategories: [
              { subsubcat_name: 'Shirt', subsubcat_slug: 'shirt' },
              { subsubcat_name: 'Shoes', subsubcat_slug: 'shoes' },
              { subsubcat_name: 'Shorts', subsubcat_slug: 'shorts' },
              { subsubcat_name: 'Gloves', subsubcat_slug: 'gloves' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
            ],
          },
          {
            subcat_name: 'Accessories',
            subcat_slug: 'accessories',
            subcat_subcategories: [
              { subsubcat_name: 'Sun Glasses', subsubcat_slug: 'sun-glasses' },
              { subsubcat_name: 'Watches', subsubcat_slug: 'watches' },
              { subsubcat_name: 'Scarfs', subsubcat_slug: 'scarfs' },
              { subsubcat_name: 'Hats', subsubcat_slug: 'hats' },
              { subsubcat_name: 'jewery', subsubcat_slug: 'jewery' },
              { subsubcat_name: 'Socks', subsubcat_slug: 'socks' },
            ],
          },
          {
            subcat_name: 'Brands',
            subcat_slug: 'brands',
            subcat_subcategories: [
              { subsubcat_name: 'Nike', subsubcat_slug: 'nike' },
              { subsubcat_name: 'Addidas', subsubcat_slug: 'addidas' },
              { subsubcat_name: 'Puma', subsubcat_slug: 'puma' },
              { subsubcat_name: 'Sketchers', subsubcat_slug: 'sketchers' },
              { subsubcat_name: 'Zara', subsubcat_slug: 'zara' },
              { subsubcat_name: 'New Balanace', subsubcat_slug: 'new-balance' },
              { subsubcat_name: 'Balaciaga', subsubcat_slug: 'balaciaga' },
            ],
          },
        ]
      },
    ]);
  }

  setCategory(category: string) {
    this.subject.next(category);
  }

  getCategory(): Observable<any> {
    return this.subject.asObservable();
  }

  // Admin
  manage() {
    return this.http.get<any>(
      this.serverUrl + 'category/manage/' + this.token
    );
  }

  add(postData: string) {
    return this.http.post<any>(
      this.serverUrl + 'category/add/' + this.token, postData
    );
  }

  delete(catID, level) {
    return this.http.get<any>(
      this.serverUrl + 'category/delete/' +
      this.token + '/' + catID + '/' + level
    );
  }


}

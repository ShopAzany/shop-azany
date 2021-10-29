import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormArray } from '@angular/forms';
import { StorageService } from 'src/app/data/helpers/storage.service';
import { FileUploadService } from 'src/app/data/services/file-upload.service';
import { CategoryService } from 'src/app/data/services/guest/category.service';
import { HttpEventType } from '@angular/common/http';
import { ConfigService } from 'src/app/data/services/config.service';
import { AngularEditorConfig } from '@kolkov/angular-editor';
import { ProductManagerService } from 'src/app/data/services/seller/product-manager.service';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { ActivatedRoute, Router } from '@angular/router';
import { DomSanitizer } from '@angular/platform-browser';
import { GuestHomeService } from 'src/app/data/services/guest/guest-home.service';

@Component({
  selector: 'app-add-product-details',
  templateUrl: './add-product-details.component.html',
  styleUrls: ['./add-product-details.component.scss']
})
export class AddProductDetailsComponent implements OnInit {

  categories: any;
  subCategories: any;
  realSubCategories: any;
  subChildcategories: any;
  realSubChildCategories: any;
  catVariation: any;

  fileMaxError;
  unsupportedFormat;
  selectedFile;
  selImages = [];
  selectedImg;
  viewImage = false;

  selectedFileName: string;
  uploadingProgress = 0;
  addUploadingProgress = 0;
  itemImages: any[] = [];
  fileUploadError: any;

  featuredIMG: string;

  catValue: any;
  subCatValue: any;
  subCatChildValue: any;
  variations: any;
  isSubmitting = false;
  titleUrl: any;
  countries: any;
  product: any;
  lastRoute: any;
  brandVariations = [];

  categoryOne: any;
  categoryTwo: any;
  categoryThree: any;
  newSetCategory: any;



  form = new FormGroup({
    pid: new FormControl('', []),
    category: new FormControl('', Validators.required),
    theCat: new FormControl('', Validators.required),
    theSubCat: new FormControl('', []),
    theSubCatChild: new FormControl('', []),
    pro_condition: new FormControl('', [
      Validators.required
    ]),
    title: new FormControl('', [
      Validators.required
    ]),
    sub_title: new FormControl('', []),
    featured_img: new FormControl(''),
    description: new FormControl('', Validators.required),
    brand: new FormControl(''),
    size: new FormControl('', []),
    material: new FormControl('', []),
    features: new FormArray([
      new FormGroup({ feature: new FormControl('') })
    ]),
    manufacture_country: new FormControl('', [
      Validators.required
    ]),
    images: new FormControl('', Validators.required),
  });

  get pid() {
    return this.form.get('pid');
  }
  get category() {
    return this.form.get('category');
  }
  get theCat() {
    return this.form.get('theCat');
  }
  get theSubCat() {
    return this.form.get('theSubCat');
  }
  get theSubCatChild() {
    return this.form.get('theSubCatChild');
  }
  get size() {
    return this.form.get('size');
  }
  get material() {
    return this.form.get('material');
  }
  get features() {
    return this.form.get('features') as FormArray;
  }
  get title() {
    return this.form.get('title');
  }
  get sub_title() {
    return this.form.get('sub_title');
  }
  get featured_img() {
    return this.form.get('featured_img');
  }
  get description() {
    return this.form.get('description');
  }
  get brand() {
    return this.form.get('brand');
  }
  get images() {
    return this.form.get('images');
  }
  get manufacture_country() {
    return this.form.get('manufacture_country');
  }
  get pro_condition() {
    return this.form.get('pro_condition');
  }

  constructor(
    private categoryService: CategoryService,
    private storageService: StorageService,
    private fileUploadService: FileUploadService,
    private configService: ConfigService,
    private productManagerService: ProductManagerService,
    private countryService: CountryService,
    private routingService: RoutingService,
    private route: ActivatedRoute,
    private sanitizer: DomSanitizer,
    private router: Router,
    private guestHomeService: GuestHomeService,
  ) { }

  ngOnInit(): void {
    this.lastRoute = this.routingService.activeRoute;
    this.getCategories();
    this.getItemImages();
    this.getCountry();
  }

  get sellerUrl() {
    return this.configService.sellerURL;
  }

  private getCountry() {
    this.countries = this.countryService.getCountries();
  }

  private getCategories() {
    this.categoryService.getCategories().subscribe(res => {
      this.categories = res.categories;
      this.subCategories = res.subcategories;
      this.subChildcategories = res.subChildcategories;
      this.catVariation = res.cat_variation;
      const proID = this.route.snapshot.paramMap.get('pid');
      if (this.lastRoute != 'add') {
        if (proID) {
          this.getProduct(proID);
        } else {
          this.routingService.replace([
            '/seller/auth/product-manager'
          ]);
        }
      }
    });
  }

  addMoreFeatures() {
    this.features.push(new FormGroup({ feature: new FormControl('') }));
  }

  removeFeature(i) {
    this.features.removeAt(i);
  }


  catChange(owner) {
    if (owner == 'category') {
      const selCatId = +this.categories.filter(cont => cont.cat_slug == this.theCat.value)[0].cat_id;
      this.realSubCategories = this.subCategories.filter(cont => cont.cat_id == selCatId);
    } else if (owner == 'subcategory') {
      const selId = +this.subCategories.filter(cont => cont.subcat_slug == this.theSubCat.value)[0].subcat_id;
      this.realSubChildCategories = this.subChildcategories.filter(cont => cont.subcat_id == selId);
    }
    this.category.setValue(`${this.theCat.value},${this.theSubCat.value},${this.theSubCatChild.value}`);
  }

  private validateFile(selectedFile) {
    const name = selectedFile.name;
    this.selectedFileName = selectedFile ? selectedFile.name : null;
    const size = Number(selectedFile.size);
    const maxSize = 10000000;
    const ext = name.substring(name.lastIndexOf('.') + 1);

    if (ext.toLowerCase() !== 'png' &&
      ext.toLowerCase() !== 'jpeg' &&
      ext.toLowerCase() !== 'gif' &&
      ext.toLowerCase() !== 'jpg') {
      this.fileUploadError = 'Selected file format is not supported';
      return this.fileUploadError;
    } else if (size > maxSize) {
      this.fileUploadError = 'Selected file Size exceeded the maximum required size of ' + maxSize;
      return this.fileUploadError;
    } else {
      return 'upload';
    }
  }

  private getFileName(selectedFile) {
    const name = selectedFile.name.split('.')[0];
    return (name.length < 2) ?
      'name-' + this.configService.clearnUrl(name) :
      this.configService.clearnUrl(name);
  }

  private getItemImages() {
    if (this.storageService.hasKey('itemImages')) {
      this.itemImages = JSON.parse(
        this.storageService.getString('itemImages')
      );
      for (let i = 0; i < this.itemImages.length; i++) {
        if (this.itemImages[i]['primary']) {
          this.form.get('featured_img').setValue(this.itemImages[i].resized);
        }
      }
    }
  }

  remove(index) {
    const x = 'Are you sure you want to REMOVE this Image?';
    if (confirm(x)) {
      this.selImages.splice(index, 1);
      this.images.setValue(this.selImages.length ? JSON.stringify(this.selImages) : '');
    }
  }

  setPrimary(img) {
    this.featured_img.setValue(img);
  }

  selectImage(e) {
    this.fileMaxError = false;
    this.unsupportedFormat = false;
    if (this.uploadingProgress) return;
    const selFile = e.target.files[0];
    const ext = selFile.name.split('.').slice(-1)[0];
    if (selFile.size > 1024 * 1024 * 2) {
      this.fileMaxError = true;
      return;
    } else if (ext != 'jpg' && ext != 'png' && ext != "jpeg") {
      this.unsupportedFormat = true;
      return;
    }
    let img = document.createElement('img');
    img.src = URL.createObjectURL(selFile);
    img.onload = () => {
      if (img.naturalWidth / img.naturalHeight != 1) {
        alert('Please upload an image with a square dimension');
        return;
      } else if (img.naturalWidth < 500) {
        alert('Please upload an image with a minimum resolution of 500 x 500');
        return;
      } else {
        this.selectedFile = selFile;
        let imgUrl = this.sanitizer.bypassSecurityTrustResourceUrl(URL.createObjectURL(selFile));
        this.selImages.push(imgUrl);
        this.onSelectedFile(this.selImages.length - 1);
      }
    }

  }

  onSelectedFile(i) {
    const selectedFileName = this.selectedFile.name;
    const fd = new FormData;
    fd.append('upload', this.selectedFile, selectedFileName);
    this.uploadingProgress = 1;
    this.fileUploadService.upload(
      fd, 'products', this.getFileName(this.selectedFile)
    )
      .subscribe(event => {
        if (event.type === HttpEventType.UploadProgress) {
          this.uploadingProgress = Math.round(event.loaded / event.total * 100);
        } else if (event.type === HttpEventType.Response) {
          if (event.body.status === 'success') {
            this.selImages.splice(i, 1, event.body.data.original);
            this.images.setValue(JSON.stringify(this.selImages));
          }
          this.uploadingProgress = 0;
        }
      }, err => { console.log(err); });
  }

  displayImage(img) {
    this.selectedImg = img;
    this.viewImage = true;
  }



  editorConfig: AngularEditorConfig = {
    editable: true,
    spellcheck: true,
    height: 'auto',
    minHeight: 'auto',
    maxHeight: 'auto',
    width: 'auto',
    minWidth: '0',
    translate: 'yes',
    enableToolbar: true,
    showToolbar: true,
    placeholder: 'Enter text here...',
    defaultParagraphSeparator: '',
    defaultFontName: '',
    defaultFontSize: '',
    fonts: [
      { class: 'arial', name: 'Arial' },
      { class: 'times-new-roman', name: 'Times New Roman' },
      { class: 'calibri', name: 'Calibri' },
      { class: 'comic-sans-ms', name: 'Comic Sans MS' },
      { class: 'algerian', name: 'Algerian' }
    ],
    customClasses: [
      {
        name: 'quote',
        class: 'quote',
      },
      {
        name: 'redText',
        class: 'redText'
      },
      {
        name: 'titleText',
        class: 'titleText',
        tag: 'h1',
      },
    ],
    // uploadUrl: 'v1/image',
    sanitize: true,
    toolbarPosition: 'top',
    toolbarHiddenButtons: [
      ['bold', 'italic'],
      ['fontSize']
    ]
  };





  // EDIT PRODUCTS
  private getProduct(proID) {
    this.productManagerService.single(proID).subscribe(res => {
      if (res && res.pid) {
        this.product = res;
        const catList = this.product.category.split(',');
        this.theCat.setValue(catList[0]);
        if (catList.length > 1) {
          this.theSubCat.setValue(catList[1]);
          if (catList.length > 2) {
            this.theSubCatChild.setValue(catList[2]);
          }
        }
        this.catChange('category');
        if (this.theSubCat.value) {
          this.catChange('subcategory');
        }
        // this.catChange('subsubcategory');
        try {
          this.selImages = JSON.parse(this.product.images);
        } catch (e) {
          this.selImages = this.product.images;
        }

        this.selImages = this.selImages.map(img => this.treatImgUrl(img));

        this.images.setValue(JSON.stringify(this.selImages));

        this.pid.setValue(res.pid);
        this.title.setValue(this.product.name);
        this.sub_title.setValue(this.product.sub_title);
        this.pro_condition.setValue(this.product.pro_condition);
        this.size.setValue(this.product.size);
        this.material.setValue(this.product.material);
        // this.form.get('color').setValue(this.product.color);
        this.manufacture_country.setValue(this.product.manufacture_country);
        // this.form.get('manufacture_state').setValue(this.product.manufacture_state);
        // this.features.setValue(this.product.features);
        let feat = JSON.parse(this.product.features);
        if (feat.length) {
          this.features.removeAt(0);
          feat.forEach((feature) => {
            this.features.push(new FormGroup({ feature: new FormControl(feature.feature) }));
          });
        }
        this.description.setValue(this.product.description);
        this.brand.setValue(this.product.brand);
        this.featured_img.setValue(this.treatImgUrl(this.product.featured_img));
      }
    });
  }



  submit() {
    this.isSubmitting = true;
    if (!this.featured_img.value) {
      this.featured_img.setValue(this.selImages[0]);
    }
    this.form.value.features = JSON.stringify(this.form.value.features);
    while (this.form.value.category.endsWith(',')) {
      this.form.value.category = this.form.value.category.slice(0, -1);
    }
    const data = JSON.stringify(this.form.value);
    // return;
    this.productManagerService.addProduct(data).subscribe(res => {
      if (res.status == 'success') {
        this.guestHomeService.getOtherData().subscribe();
        if (res.data.pid) {
          this.titleUrl = this.configService.clearnUrl(this.form.value.title);
          if (this.lastRoute == 'edit') {
            this.router.navigateByUrl(
              `${this.sellerUrl}/auth/product-manager/${res.data.pid}/selling/${this.titleUrl}/edit`
            )
          } else {
            this.router.navigateByUrl(
              `${this.sellerUrl}/auth/product-manager/${res.data.pid}/${this.titleUrl}/selling`
            );
          }
        }
      } else {
        alert('Oops! Something went wrong, please try it again.');
      }
      this.isSubmitting = false;
    });
  }

  treatImgUrl(url) {
    return this.configService.treatImgUrl(url);
  }



}

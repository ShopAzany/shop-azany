import { HttpEventType } from '@angular/common/http';
import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormGroup, FormControl, Validators } from '@angular/forms';
import { DomSanitizer } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { StorageService } from 'src/app/data/helpers/storage.service';
import { FileUploadService } from 'src/app/data/services/file-upload.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { SellerAuthService } from 'src/app/data/services/seller/seller-auth.service';

@Component({
  selector: 'app-business-info',
  templateUrl: './business-info.component.html',
  styleUrls: ['./business-info.component.scss']
})
export class BusinessInfoComponent implements OnInit {

  seller_id;

  auth;
  imgUrl;

  selectedFile;
  uploadingProgress;
  @ViewChild('imgPreview') imgPreview: ElementRef;
  fileMaxError = false;
  fileTouched = false;

  isSubmitting = false;

  countries;

  form = new FormGroup({
    biz_name: new FormControl('', [
      Validators.required
    ]),
    biz_type: new FormControl('', [
      Validators.required
    ]),
    biz_address: new FormControl('', [
      Validators.required
    ]),
    alternative_address: new FormControl(null),
    country: new FormControl('', [
      Validators.required
    ]),
    zip_code: new FormControl('', [
      Validators.required,
    ]),
    city: new FormControl('', [
      Validators.required,
    ]),
    biz_reg_number: new FormControl(null),
    biz_certificate: new FormControl(null),
    id_type: new FormControl('', [
      Validators.required,
    ])
  });

  get businessName() {
    return this.form.get('biz_name');
  }
  get businessType() {
    return this.form.get('biz_type');
  }
  get companyAddress() {
    return this.form.get('biz_address');
  }
  get altAddress() {
    return this.form.get('alternative_address');
  }
  get country() {
    return this.form.get('country');
  }
  get postalCode() {
    return this.form.get('zip_code');
  }
  get city() {
    return this.form.get('city');
  }
  get regNumber() {
    return this.form.get('biz_reg_number');
  }
  get certificate() {
    return this.form.get('biz_certificate');
  }
  get fileValid() {
    return this.fileTouched ? this.certificate.valid : true;
  }
  get id_type() {
    return this.form.get('id_type');
  }

  constructor(
    private route: Router,
    private countryService: CountryService,
    private saniter: DomSanitizer,
    private fileUploadService: FileUploadService,
    private storageService: StorageService,
    private authService: SellerAuthService,
  ) { }

  ngOnInit(): void {
    this.getAuth();
    this.countries = this.countryService.getCountries();
    this.get_seller_id();
  }

  sanitizeUrl(url) {
    return this.saniter.bypassSecurityTrustResourceUrl(url);
  }

  private getAuth() {
    this.authService.seller.subscribe(auth => {
      this.auth = auth;
      if (auth) {
        if (auth.bank_info_status == 1) {
          this.route.navigateByUrl('/seller/auth');
        }
        this.checkStoredForm();
      } else {
        this.route.navigateByUrl('/seller/register');
      }
    });
  }

  get_seller_id() {
    this.seller_id = this.auth.seller_id;
  }

  private checkStoredForm() {
    if (this.storageService.hasKey('biz_info')) {
      const formData = JSON.parse(this.storageService.getString('biz_info'));
      this.businessName.setValue(formData.biz_name);
      this.businessType.setValue(formData.biz_type);
      this.regNumber.setValue(formData.biz_reg_number);
      this.postalCode.setValue(formData.zip_code);
      this.altAddress.setValue(formData.alternative_address);
      this.companyAddress.setValue(formData.biz_address);
      this.certificate.setValue(formData.biz_certificate);
      this.imgUrl = this.certificate.value;
      this.city.setValue(formData.city);
      this.country.setValue(formData.country);
      this.setFieldReq();
      this.id_type.setValue(formData.id_type);
    }
  }

  setFieldReq() {
    let biztype = this.businessType.value;
    if (biztype != 'Individual') {
      this.regNumber.setValidators(Validators.required);
      this.regNumber.updateValueAndValidity();
      this.certificate.setValidators(Validators.required);
      this.certificate.updateValueAndValidity();
    } else {
      this.regNumber.clearValidators();
      this.regNumber.updateValueAndValidity();
      this.certificate.clearValidators();
      this.certificate.updateValueAndValidity();
    }
  }

  submit() {
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.storageService.storeString('biz_info', data);
    this.authService.signupBizInfo(data, this.seller_id).subscribe(res => {
      if (res) {
        if (res.status == 'success') {
          this.route.navigateByUrl('/seller/auth/register/additional-info');
        }
      }
      this.isSubmitting = false;
    })
  }

  selectFile(e) {
    if (this.uploadingProgress) return;
    const selFile = e.target.files[0];
    if (selFile.size > 1024 * 1024 * 2) {
      this.fileMaxError = true;
      return;
    }
    this.selectedFile = selFile;
    this.imgUrl = URL.createObjectURL(selFile);
    this.onSelectedFile();
  }

  onSelectedFile() {
    const selectedFileName = this.selectedFile.name;
    const fd = new FormData;
    fd.append('upload', this.selectedFile, selectedFileName);
    this.uploadingProgress = 1;
    this.fileUploadService.upload(
      fd, 'sellercertificate', `${this.auth.first_name}-${selectedFileName}`
    )
      .subscribe(event => {
        if (event.type === HttpEventType.UploadProgress) {
          this.uploadingProgress = Math.round(event.loaded / event.total * 100);
        } else if (event.type === HttpEventType.Response) {
          if (event.body.status === 'success') {
            this.certificate.setValue(event.body.data.original);
            this.imgUrl = event.body.data.original;
          }
          this.uploadingProgress = 0;
        }
      }, err => { console.log(err); });
  }

}

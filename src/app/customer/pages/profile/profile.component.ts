import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { BehaviorSubject } from 'rxjs';
import { AuthService } from 'src/app/data/services/auth.service';
import { CustomerService } from 'src/app/data/services/customer/customer.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
  providers: [DatePipe]
})
export class ProfileComponent implements OnInit {

  isSaving = false;
  auth: any;
  emailServerError: any;
  tokenServeError: any;
  phoneServerError: any;
  countries: any;
  birthdatAlert: any;
  closeModal = new BehaviorSubject<boolean>(false);

  isFormToken = false;
  changeEmailForm = true;

  genderAuth: any;
  genderNew: any;

  tokenForm = new FormGroup({
    tokenEmail: new FormControl('', []),
    token: new FormControl('', [Validators.required])
  });

  fullNameForm = new FormGroup({
    full_name: new FormControl('', [Validators.required]),
  });

  emailForm = new FormGroup({
    email: new FormControl('', [Validators.required]),
  });

  genderForm = new FormGroup({
    gender: new FormControl('', []),
  });

  birthdayForm = new FormGroup({
    date_of_birth: new FormControl('', []),
  });

  phoneForm = new FormGroup({
    phone: new FormControl('', [Validators.required]),
    country_code: new FormControl('+', [Validators.required]),
  });

  get full_name() {
    return this.fullNameForm.get('full_name');
  }

  get email() {
    return this.emailForm.get('email');
  }

  get phone() {
    return this.phoneForm.get('phone');
  }
  get country_code() {
    return this.phoneForm.get('country_code');
  }

  get token() {
    return this.tokenForm.get('token');
  }

  myDate = new Date();
  currentDate: any;

  constructor(
    private authService: AuthService,
    private countryService: CountryService,
    private customerService: CustomerService,
    private datePipe: DatePipe
  ) {
    this.currentDate = this.datePipe.transform(this.myDate, 'yyyy-MM-dd');
  }

  ngOnInit(): void {
    this.countries = this.countryService.getCountries();
    this.getAuth();
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) {
        this.auth = res;
        this.genderAuth = this.auth.gender;
        if (this.auth) {
          this.initiateFormValues();
        }
      }
    });
  }


  get validateEmail() {
    if (this.email.valid) {
      if (this.email.value.match(/^[^a-z]/i)) return false;
      let match = this.email.value.match(/[a-z0-9]+[-_\.]{0,1}[a-z0-9]+@[a-z]+\.[a-z]{2,}(?!.)/i);
      return match ? true : false;
    }
    return false;
  }

  get invalidcountry_code() {
    if (this.country_code.touched && this.country_code.valid) {
      let countryMatch = this.countryService.getCountryWithDialing(this.country_code.value);
      if (countryMatch.length) {
        return false;
      }
      return true;
    }
    return false;
  }

  get countryIso() {
    let country = this.countryService.getCountryWithDialing(this.country_code.value);
    if (country.length) {
      return country[0].iso.toLowerCase();
    }
    return null;
  }

  private initiateFormValues() {
    this.email.setValue(this.auth.email);
    this.full_name.setValue(this.auth.full_name);
    this.phone.setValue(this.auth.phone);
    this.country_code.setValue(this.auth.country_code ? this.auth.country_code : '+');
  }

  setCountryCode(i) {
    this.country_code.setValue(this.countries[i].dailing);
  }

  get invalidCountryCode() {
    if (this.country_code.touched && this.country_code.valid) {
      let countryMatch = this.countryService.getCountryWithDialing(this.country_code.value);
      if (countryMatch.length) {
        return false;
      }
      return true;
    }
    return false;
  }

  clickGender(value) {
    this.genderAuth = '';
    this.genderNew = value;
  }

  birth: any;

  submitEmail() {
    this.isSaving = true;
    const data = JSON.stringify(this.emailForm.value);
    this.customerService.changeEmail(data).subscribe(res => {
      if (res && res.status == 'success') {
        this.tokenForm.get('tokenEmail').setValue(res.data);
        this.isFormToken = true;
        this.changeEmailForm = false;
      } else {
        this.emailServerError = res.data;
      }
      this.isSaving = false;
    });
  }

  submitToken() {
    this.isSaving = true;
    const data = JSON.stringify(this.tokenForm.value);
    this.customerService.tokenForEmail(data).subscribe(res => {
      if (res && res.status == 'success') {
        this.closeModal.next(true);
        alert('Email successfully changed')
        this.isFormToken = false;
        this.changeEmailForm = true;
      } else {
        this.tokenServeError = res.data;
      }
      this.isSaving = false;
    });
  }

  submit(fg) {
    if (this.genderNew) {
      this.genderForm.get('gender').setValue(this.genderNew);
    } else {
      this.genderForm.get('gender').setValue(this.genderAuth);
    }

    this.birth = this.birthdayForm.get('date_of_birth').value;

    if (this.birth >= this.currentDate) {
      this.birthdatAlert = true
      return;
    }

    this.isSaving = true;
    const data = JSON.stringify(fg.value);
    this.customerService.updateProfile(data).subscribe(res => {
      if (res) {
        if (res.status == 'success') {
          this.closeModal.next(true);
        } else {
        }
      }
      this.isSaving = false;
    });

  }

}

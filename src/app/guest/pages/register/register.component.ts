import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { StorageService } from 'src/app/data/helpers/storage.service';
import { AuthService } from 'src/app/data/services/auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  @ViewChild('emailEl') emailGroup: ElementRef;
  @ViewChild('phoneEl') phoneGroup: ElementRef;

  emailServerError;
  phoneServerError;

  notMatched = false;
  isSubmitting = false;
  authError: any;

  form = new FormGroup({
    full_name: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required]),
    retype_password: new FormControl('', [Validators.required]),
    phone: new FormControl('', [Validators.required]),
  });

  get full_name() {
    return this.form.get('full_name');
  }
  get email() {
    return this.form.get('email');
  }
  get password() {
    return this.form.get('password');
  }
  get retype_password() {
    return this.form.get('retype_password');
  }
  get phone() {
    return this.form.get('phone');
  }

  constructor(
    private authService: AuthService,
    private router: Router,
    private storageService: StorageService,
  ) { }

  ngOnInit(): void {
    this.checkSocialData();
  }

  private checkSocialData() {
    if (this.storageService.hasKey('SocialUser')) {
      let socialData = JSON.parse(this.storageService.getString('SocialUser'));
      this.full_name.setValue(`${socialData.first_name} ${socialData.last_name}`);
      this.email.setValue(socialData.email);
    }
  }

  checkPass(event) {
    this.notMatched = true;
    const pass = this.form.get('password').value;
    if (pass == event.target.value) {
      this.notMatched = false;
    }
  }

  get validateEmail() {
    if (this.email.valid) {
      if (this.email.value.match(/^[^a-z]/i)) return false;
      let match = this.email.value.match(/[a-z0-9]+[-_\.]{0,1}[a-z0-9]+@[a-z]+\.[a-z]{2,}(?!.)/i);
      return match ? true : false;
    }
    return false;
  }

  submit() {
    this.isSubmitting = true;
    const data = JSON.stringify(this.form.value);
    this.authService.signup(data).subscribe(res => {
      if (res && res.status === 'success') {
        this.authError = null;
        this.authService.storeAuthData(res.data);
        this.storageService.remove('SocialUser');
        this.router.navigateByUrl('/customer');
      } else {
        if (res.data.toLowerCase().includes('email')) {
          this.emailServerError = res.data;
          this.emailGroup.nativeElement.scrollIntoView();
        } else {
          this.phoneServerError = res.data;
          this.phoneGroup.nativeElement.scrollIntoView();
        }
      }
      this.isSubmitting = false;
    },
      err => {
        console.log(err);
        this.isSubmitting = false;
      });
  }

}

import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { CustomerService } from 'src/app/data/services/customer/customer.service';

@Component({
  selector: 'app-change-password',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.scss']
})
export class ChangePasswordComponent implements OnInit {

  isSaving = false;
  notMatched = false;
  message = false;
  oldPwdServerError;

  @ViewChild('phoneEl') phoneGroup: ElementRef;
  @ViewChild('oldWrong') OldPassWong: ElementRef;

  form = new FormGroup({
    old_pwd: new FormControl('', [Validators.required]),
    new_pwd: new FormControl('', [Validators.required]),
    retype_new_pwd: new FormControl('', [Validators.required]),
  });

  get old_pwd(){
    return this.form.get('old_pwd');
  }
  get new_pwd(){
    return this.form.get('new_pwd');
  }
  get retype_new_pwd(){
    return this.form.get('retype_new_pwd');
  }

  constructor(
    private customerService: CustomerService
  ) { }

  ngOnInit(): void {
  }
  newPwd: any;
  newPdIcon: any;

  toggleNewPass(){
    this.newPwd = document.getElementById('new_pwd');
    this.newPdIcon = document.getElementById('newPassIcon');
    this.newPwd.type = this.newPwd.type == "text" ? "password" : "text";
    this.newPdIcon.classList.toggle('fa-eye');
    this.newPdIcon.classList.toggle('fa-eye-slash');
  }

  toggleRetPass(){
    this.newPwd = document.getElementById('retype_new_pwd');
    this.newPdIcon = document.getElementById('retypePassIcon');
    this.newPwd.type = this.newPwd.type == "text" ? "password" : "text";
    this.newPdIcon.classList.toggle('fa-eye');
    this.newPdIcon.classList.toggle('fa-eye-slash');
  }

  checkPass(event){
    this.notMatched = true;
    const pass = this.form.get('new_pwd').value;
    if (pass == event.target.value) {
      this.notMatched = false;
    }
  }

  
  submit(){
    this.isSaving = true;
    const data = JSON.stringify(this.form.value)
    this.customerService.changePassword(data).subscribe(res => {
      if (res && res.status == 'success') {
        this.message = true;
        this.form.reset();
        this.oldPwdServerError = "";
      } else {
        this.oldPwdServerError = res.data
      }
      this.isSaving = false;
      this.phoneGroup.nativeElement.scrollIntoView();
      this.OldPassWong.nativeElement.scrollIntoView();
    });
  }

  removeMessage(){
    this.message = false;
  }


}

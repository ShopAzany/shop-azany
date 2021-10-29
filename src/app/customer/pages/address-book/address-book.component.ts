import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { BehaviorSubject } from 'rxjs';
import { AuthService } from 'src/app/data/services/auth.service';
import { AddressService } from 'src/app/data/services/customer/address.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';

@Component({
  selector: 'app-address-book',
  templateUrl: './address-book.component.html',
  styleUrls: ['./address-book.component.scss']
})
export class AddressBookComponent implements OnInit {

  closeModal = new BehaviorSubject<boolean>(false);

  addresses: any;
  auth: any;
  isLoading = true;
  isSaving = false;
  isRemoving = false;
  message = false;
  countries: any;
  theMessage: any;
  addressID = 0;


  addForm = new FormGroup({
    street_addr: new FormControl('', [Validators.required]),
    city: new FormControl('', [Validators.required]),
    state: new FormControl('', [Validators.required]),
    country: new FormControl('', [Validators.required]),
  });
  
  editForm = new FormGroup({
    id: new FormControl('', []),
    street_addr: new FormControl('', [Validators.required]),
    city: new FormControl('', [Validators.required]),
    state: new FormControl('', [Validators.required]),
    country: new FormControl('', [Validators.required]),
    defaultAdd: new FormControl('', []),
  });

  get street_addr(){
    return this.addForm.get('street_addr');
  }

  get city(){
    return this.addForm.get('city');
  }

  get state(){
    return this.addForm.get('state');
  }

  get country(){
    return this.addForm.get('country');
  }

  constructor(
    private addressService: AddressService,
    private authService: AuthService,
    private countryService: CountryService
  ) { }

  ngOnInit(): void {
    this.getAddress();
    this.getAuth();
    this.countries = this.countryService.getCountries();
  }

  private getAddress(){
    this.isLoading = true;
    this.addressService.addresses().subscribe(res => {
      this.delayResults(res)
    });
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) { 
        this.auth = res; 
      }
    });
  }

  private delayResults(response) {
    setTimeout(() => {
      if (response) {
        this.addresses = response;
      }
      this.isLoading = false;
    }, 1500);
  }


  submitAdd(){
    this.isSaving = true;
    const data = JSON.stringify(this.addForm.value);
    this.addressService.add(data).subscribe(res => {
      if (res && res.status == 'success') {
        this.ngOnInit();
        this.message = true;
        this.theMessage = 'Address successfully Added';
        this.closeModal.next(true);
      }
    });
  }

  removeMessage(){
    this.message = false;
  }


  removeAddr(id){
    this.addressID = id;

    if (this.addressID) {
      let addInfo = this.addresses.filter(cont => cont.id == this.addressID)[0];
      this.editForm.get('id').setValue(addInfo.id);
      this.editForm.get('street_addr').setValue(addInfo.street_addr);
      this.editForm.get('city').setValue(addInfo.city);
      this.editForm.get('state').setValue(addInfo.state);
      this.editForm.get('country').setValue(addInfo.country);
      this.editForm.get('defaultAdd').setValue(addInfo.add_status);
    }
  }

  removeAddrNow(){
    this.isRemoving = true;
    this.addressService.delete(this.addressID).subscribe(res => {
      if (res && res.status == 'success') {
        this.ngOnInit();
        this.message = true;
        this.theMessage = 'Address successfully removed';
        this.closeModal.next(true);
      }
      this.isRemoving = true;
      this.addressID = 0;
    });
  }

  closeModalAddr(){
    this.closeModal.next(true);
  }

  submitEdit(){
    this.isSaving = true;
    const data = JSON.stringify(this.editForm.value);
    this.addressService.edit(data).subscribe(res => {
      if (res && res.status == 'success') {
        this.ngOnInit();
        this.message = true;
        this.theMessage = 'Address successfully Updated';
        this.closeModal.next(true);
      }
      this.isSaving = true;
      this.addressID = 0;
    });
  }


}

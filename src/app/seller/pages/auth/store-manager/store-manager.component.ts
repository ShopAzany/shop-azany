import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { BehaviorSubject } from 'rxjs';
import { AuthService } from 'src/app/data/services/auth.service';
//import { AddressService } from 'src/app/data/services/customer/address.service';
import { CountryService } from 'src/app/data/services/local-data/country.service';
import { ManagerService } from 'src/app/data/services/seller/manager.service'


@Component({
  selector: 'app-store-manager',
  templateUrl: './store-manager.component.html',
  styleUrls: ['./store-manager.component.scss']
})
export class StoreManagerComponent implements OnInit {

  closeModal = new BehaviorSubject<boolean>(false);

  managers: any;
  auth: any;
  isLoading = true;
  isSaving = false;
  isRemoving = false;
  message = false;
  countries: any;
  theMessage: any;
  managerID = 0;

  addForm = new FormGroup({
    manager_name: new FormControl('', [Validators.required]),
    manager_email: new FormControl('', [Validators.required]),
    manager_role: new FormControl('', [Validators.required]),
  });

  editForm = new FormGroup({
    id: new FormControl('', []),
    manager_name: new FormControl('', [Validators.required]),
    manager_email: new FormControl('', [Validators.required]),
    manager_role: new FormControl('', [Validators.required]),
    defaultAdd: new FormControl('', []),
  });

  get manager_name(){
    return this.addForm.get('manager_name');
  }

  get manager_email(){
    return this.addForm.get('manager_email');
  }

  get manager_role(){
    return this.addForm.get('manager_role');
  }

  constructor(
    //private addressService: AddressService,
    private authService: AuthService,
    private countryService: CountryService,
    private managerService: ManagerService
  ) { }

  ngOnInit(): void {
    this.getAddress();
    this.getAuth();
    //this.countries = this.countryService.getCountries();
  }

  private getAddress(){
    //this.isLoading = true;
    //this.managerService.managers().subscribe(res => {
      //this.delayResults(res)

      //NOT THERE BEFORE OOO
      this.isLoading = false;
    //});
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
        this.managers = response;
      }
      this.isLoading = false;
    }, 1500);
  }


  submitAdd(){
    this.isSaving = true;
    const data = JSON.stringify(this.addForm.value);
    //this.managerService.add(data).subscribe(res => {
      //if (res && res.status == 'success') {
        //this.ngOnInit();
        //this.message = true;
        //this.theMessage = 'Address successfully Added';
        //this.closeModal.next(true);
      //}
    //});
  }

  removeMessage(){
    this.message = false;
  }


  removeAddr(id){
    this.managerID = id;

    if (this.managerID) {
      let addInfo = this.managers.filter(cont => cont.id == this.managerID)[0];
      this.editForm.get('id').setValue(addInfo.id);
      this.editForm.get('manager_name').setValue(addInfo.street_addr);
      this.editForm.get('manager_email').setValue(addInfo.city);
      this.editForm.get('manager_role').setValue(addInfo.state);
      this.editForm.get('defaultAdd').setValue(addInfo.add_status);
    }
  }

  removeAddrNow(){
    this.isRemoving = true;
    //this.managerService.delete(this.addressID).subscribe(res => {
      //if (res && res.status == 'success') {
        //this.ngOnInit();
        //this.message = true;
        //this.theMessage = 'Address successfully removed';
        //this.closeModal.next(true);
      //}
      //this.isRemoving = true;
      //this.addressID = 0;
    //});
  }

  closeModalAddr(){
    this.closeModal.next(true);
  }

  submitEdit(){
    this.isSaving = true;
    const data = JSON.stringify(this.editForm.value);
    //this.managerService.edit(data).subscribe(res => {
      //if (res && res.status == 'success') {
        //this.ngOnInit();
        //this.message = true;
        //this.theMessage = 'Address successfully Updated';
        //this.closeModal.next(true);
      //}
      //this.isSaving = true;
      //this.addressID = 0;
    //});
  }

}

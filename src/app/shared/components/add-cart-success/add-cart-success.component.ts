import { AfterViewInit, Component, ElementRef, Input, OnInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-add-cart-success',
  templateUrl: './add-cart-success.component.html',
  styleUrls: ['./add-cart-success.component.scss']
})
export class AddCartSuccessComponent implements OnInit {
  @Input() addCartProdName;

  constructor() { }

  ngOnInit(): void {
  }

}

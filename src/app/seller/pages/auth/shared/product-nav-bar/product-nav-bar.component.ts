import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-product-nav-bar',
  templateUrl: './product-nav-bar.component.html',
  styleUrls: ['./product-nav-bar.component.scss']
})
export class ProductNavBarComponent implements OnInit {
  @Input() activeLink;
  @Input() title;
  constructor() { }

  ngOnInit(): void {
  }

}

import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'app-related-items',
  templateUrl: './related-items.component.html',
  styleUrls: ['./related-items.component.scss']
})
export class RelatedItemsComponent implements OnInit {

  @Input() productsData;

  constructor() { }

  ngOnInit(): void {
  }

}

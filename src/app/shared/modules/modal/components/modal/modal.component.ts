import { AfterViewInit, Component, ElementRef, Input, OnInit, ViewChild } from '@angular/core';

@Component({
  selector: 'app-modal',
  templateUrl: './modal.component.html',
  styleUrls: ['./modal.component.scss']
})
export class ModalComponent implements OnInit, AfterViewInit {
  @ViewChild('modalParent') modalParent: ElementRef;
  closeBtn: HTMLElement;
  closeModalDiv: HTMLElement;
  @Input() closeModal

  constructor() { }

  ngOnInit(): void {
    this.closeModal.subscribe(close => {
      if (close) {
        this.closeBtn.click();
      }
    });
  }

  ngAfterViewInit() {
    const me = this;
    this.closeBtn = this.modalParent.nativeElement.querySelector('.closeBtn');
    this.closeModalDiv = this.modalParent.nativeElement.querySelector('.closeModal');
    this.closeBtn.onclick = closeModal;
    this.closeModalDiv.onclick = closeModal;
    function closeModal() {
      me.modalParent.nativeElement.classList.remove('modalActive');
    }
  }

}

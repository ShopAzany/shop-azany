import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RegisternComponent } from './registern.component';

describe('RegisternComponent', () => {
  let component: RegisternComponent;
  let fixture: ComponentFixture<RegisternComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RegisternComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(RegisternComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

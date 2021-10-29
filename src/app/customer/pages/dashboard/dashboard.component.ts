import { Component, OnInit } from '@angular/core';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { AuthService } from 'src/app/data/services/auth.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {

  auth: any;

  constructor(
    private authService: AuthService,
    private routingService: RoutingService
  ) { }

  ngOnInit(): void {
    this.getAuth()
  }

  logout() {
    this.authService.logout();
    this.routingService.replace(['/']);
  }

  private getAuth() {
    this.authService.customer.subscribe(res => {
      if (res && res.login_id) { 
        this.auth = res; 
      }
    });
  }

}

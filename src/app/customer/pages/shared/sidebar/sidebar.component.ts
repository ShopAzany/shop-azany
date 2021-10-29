import { Component, OnInit } from '@angular/core';
import { RoutingService } from 'src/app/data/helpers/routing.service';
import { AuthService } from 'src/app/data/services/auth.service';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {

  constructor(
    private authService: AuthService,
    private routingService: RoutingService
  ) { }

  ngOnInit(): void {
  }

  logout() {
    this.authService.logout();
    this.routingService.replace(['/']);
  }

}

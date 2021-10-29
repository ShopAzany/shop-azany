import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })

export class MyDateService {

  private months = [
    'January',
    'Febuary',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
  ];

  private days = [
    'Sunday',
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday'
  ]

  getMonth(ind) {
    return this.months[ind];
  }

  currentMonth() {
    return this.months[new Date().getMonth()];
  }

  getShortMonth(ind) {
    return this.months[ind].slice(0, 3);
  }

  getMonths(): any[] {
    return this.months;
  }

  getWeekDay(ind) {
    return this.days[ind]
  }

  getShortWeekDay(ind) {
    return this.days[ind].slice(0, 3);
  }

  getYears(start: number = 0, addTo: number = 0): any[] {
    const date = new Date();
    const year = date.getFullYear();
    const yearObj = [];
    let x;

    if (start > 0 && start < 1900) { start = 1970; }
    if (addTo > 50) { addTo = 50; }

    for (x = start; x <= year + addTo; x++) {
      yearObj.push({ 'id': x, 'name': x });
    }

    return yearObj;
  }

}

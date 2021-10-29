import { AfterViewInit, Component, ElementRef, Input, OnDestroy, OnInit, ViewChild } from '@angular/core';
import { MyDateService } from 'src/app/data/services/local-data/my-date.service';

@Component({
  selector: 'app-bar-chart',
  templateUrl: './bar-chart.component.html',
  styleUrls: ['./bar-chart.component.scss']
})
export class BarChartComponent implements OnInit, AfterViewInit, OnDestroy {
  groupedArr = [];
  numArr = [];
  duration = [];
  tipRight = false;
  @ViewChild('barChartPar') barChartPar: ElementRef;
  eachSingles: NodeListOf<HTMLElement>;
  @Input() rawData;
  @Input() durationNo;
  @Input() durationUnit;
  @Input() yAxis;
  animated = false;
  allH;
  initialRawData;
  initialDurUnit;

  get checkDataChange() {
    if (this.initialRawData != JSON.stringify(this.rawData) || this.initialDurUnit != this.durationUnit) {
      this.animated = false;
      this.winResEv(false);
      this.numArr = [];
      this.groupedArr = [];
      this.duration = [];
      this.ngOnInit();
      setTimeout(() => {
        this.ngAfterViewInit();
      });
    }
    return '';
  }

  constructor(
    private dateService: MyDateService
  ) { }

  ngOnInit(): void {
    this.initialRawData = JSON.stringify(this.rawData);
    this.initialDurUnit = this.durationUnit;
    this.initiateGrouping();
    this.getNumArr();
    this.getDuration();
  }

  ngOnDestroy() {
    this.winResEv(false);
  }

  ngAfterViewInit() {
    setTimeout(() => {
      this.eachSingles = this.barChartPar.nativeElement.querySelectorAll('.eachSingle');
      this.responsive();
      this.winResEv(true);
      this.setInitial();
      this.scrollCheck();
    })
  }

  private scrollCheck() {
    const me = this;
    function scroll() {
      let svgBc = me.barChartPar.nativeElement.getBoundingClientRect();
      if (svgBc.top >= 0 && svgBc.bottom <= window.innerHeight) {
        me.plotChart();
        me.animated = true;
        document.body.removeEventListener('scroll', scroll);
      }
    }
    if (!me.animated) {
      scroll();
      document.body.addEventListener('scroll', scroll);
    } else {
      document.body.removeEventListener('scroll', scroll);
    }
  }

  private setInitial() {
    this.allH = [];
    this.groupedArr.forEach((each) => {
      each.heights.forEach((h) => this.allH.push(h));
    });
    this.eachSingles.forEach((each) => {
      each.style.height = "0px";
    });
  }

  private winResEv(add) {
    const me = this;
    function resize() {
      me.responsive();
    }
    if (add) {
      window.addEventListener('resize', resize);
    } else {
      window.removeEventListener('resize', resize);
    }
  }

  private responsive() {
    let parw = +getComputedStyle(this.barChartPar.nativeElement).width.replace('px', '');
    let finalh = parw * 351 / 672.9;
    let finalPt = parw * 80 / 672.9;
    let finalPb = parw * 50 / 672.9;
    this.barChartPar.nativeElement.style.height = `${finalh < 192.11 ? 192.11 : finalh}px`;
    this.barChartPar.nativeElement.style.padding = `${finalPt}px 0 ${finalPb}px`;
  }

  setTooltip(e) {
    const tooltip = e.target.children[0];
    let tipW = +getComputedStyle(tooltip).width.replace('px', '');
    if (window.innerWidth - e.x < tipW) {
      this.tipRight = true;
    } else {
      this.tipRight = false;
    }
  }

  private getDuration() {
    this.groupedArr.forEach((each) => {
      let eachDur;
      if (this.durationUnit == 'days') {
        eachDur = this.dateService.getShortWeekDay(new Date(each.date).getDay());
      } else if (this.durationUnit == 'months') {
        eachDur = this.dateService.getShortMonth(new Date(each.date).getMonth());
      } else if (this.durationUnit == 'years') {
        eachDur = new Date(each.date).getFullYear();
      }
      this.duration.push(eachDur);
    })
    // console.log(this.duration);
  }

  private plotChart() {
    setTimeout(() => {
      this.eachSingles.forEach((each, i) => {
        each.style.height = `${this.allH[i]}%`;
      });
    });
  }

  private getNumArr() {
    let numarr = [];
    this.groupedArr.forEach((each) => {
      each.data.forEach((each2) => {
        numarr.push(each2);
      });
    });
    // console.log(numarr);
    let max = Math.max(...numarr);
    if (max.toString().length == 1) {
      if (max < 5) {
        for (let i = 5; i >= 0; i--) {
          this.numArr.push(i);
        }
      } else {
        for (let i = 10; i >= 0; i -= 2) {
          this.numArr.push(i);
        }
      }
    } else {
      let strMax = max.toString();
      let lower5Mult = +strMax.replace(strMax.slice(-1), '5');
      let high5Mult = lower5Mult + 5;
      if (max < lower5Mult) {
        for (let i = lower5Mult; i >= 0; i -= lower5Mult / 5) {
          this.numArr.push(i);
        }
      } else {
        for (let i = high5Mult; i >= 0; i -= high5Mult / 5) {
          this.numArr.push(i);
        }
      }
    }
    // console.log(this.numArr);
    this.groupedArr.forEach((each) => {
      let maxNum = Math.max(...this.numArr);
      let heights = each.data.map(num => (num / maxNum) * 100);
      each.heights = heights;
    });
    // console.log(this.groupedArr);
  }

  private initiateGrouping() {
    for (let i = 0; i < this.rawData.length; i++) {
      this.groupData(this.rawData[i], i);
    }
    this.groupedArr.forEach((each) => {
      if (each.data.length < this.rawData.length) {
        for (let i = 0; i < this.rawData.length - each.data.length; i++) {
          each.data.push([]);
        }
      }
    });
    this.fillMissingDates();
    if (this.groupedArr.length) {
      this.appendMissingDates();
    } else {
      let endDate = new Date();
      let [y, m, d] = [endDate.getFullYear(), endDate.getMonth() + 1, endDate.getDate()];
      this.groupedArr.push({
        date: `${y}-${m < 10 ? '0' : ''}${m}-${d < 10 ? '0' : ''}${d}`,
        data: Array(this.rawData.length).fill([])
      });
      if (this.durationUnit == 'months') {
        this.groupedArr[this.groupedArr.length - 1].date = `${y}-${m < 10 ? '0' : ''}${m}-01`;
      }
    }
    this.fillFrontMissingDates();
    this.groupedArr.forEach((each) => {
      let data = []
      let totalQty = 0;
      for (let each2 of each.data) {
        for (let each3 of each2) {
          totalQty += each3[this.yAxis] ? each3[this.yAxis] : 1;
        }
        data.push(totalQty);
        totalQty = 0;
      }
      each.data = data;
    });
    // console.log(this.groupedArr, 'modified');
  }

  private fillMissingDates() {
    for (let i = 0; i < this.groupedArr.length; i++) {
      if (i != 0) {
        let lastDate = this.groupedArr[i - 1].date;
        let currDate = this.groupedArr[i].date;
        if (this.durationUnit == 'days') {
          let missDate = new Date(Date.parse(lastDate) + (24 * 60 * 60 * 1000));
          let [y, m, d] = [missDate.getFullYear(), missDate.getMonth() + 1, missDate.getDate()];
          if (Date.parse(currDate) - Date.parse(lastDate) > (24 * 60 * 60 * 1000)) {
            this.groupedArr.splice(i, 0, {
              date: `${y}-${m < 10 ? '0' : ''}${m}-${d < 10 ? '0' : ''}${d}`,
              data: Array(this.rawData.length).fill([])
            });
          }
        } else if (this.durationUnit == 'months') {
          let [curY, curM] = currDate.split('-');
          let [prevY, prevM] = lastDate.split('-');
          let missM, missY = prevY;
          if (+prevM + 1 > 12) {
            missM = '01';
            missY = `${+prevY + 1}`;
          } else {
            missM = `${+prevM + 1 < 10 ? '0' : ''}${+prevM + 1}`;
          }
          if (missM != curM) {
            this.groupedArr.splice(i, 0, {
              date: `${missY}-${missM}-01`,
              data: Array(this.rawData.length).fill([])
            });
          }
        } else if (this.durationUnit == 'years') {
          let [curY] = currDate.split('-');
          let [preY, preM, preD] = lastDate.split('-');
          let missY = +preY + 1;
          if (missY != curY) {
            this.groupedArr.splice(i, 0, {
              date: `${missY}-${preM}-${preD}`,
              data: Array(this.rawData.length).fill([])
            });
          }
        }
      }
    }
  }

  private appendMissingDates() {
    if (this.durationUnit == 'days') {
      let dayDiff = Math.floor((Date.now() - Date.parse(this.groupedArr.slice(-1)[0].date)) / (1000 * 60 * 60 * 24));
      for (let i = 0; i < dayDiff; i++) {
        let lastDate = this.groupedArr.slice(-1)[0].date;
        let nextDate = new Date(Date.parse(lastDate) + (24 * 60 * 60 * 1000));
        let [y, m, d] = [nextDate.getFullYear(), nextDate.getMonth() + 1, nextDate.getDate()];
        this.groupedArr.push({
          date: `${y}-${m < 10 ? '0' : ''}${m}-${d < 10 ? '0' : ''}${d}`,
          data: Array(this.rawData.length).fill([])
        });
      }
    } else if (this.durationUnit == 'months') {
      let monthDiff = (new Date().getMonth() + 1) - (new Date(this.groupedArr.slice(-1)[0].date).getMonth() + 1);
      if (monthDiff < 0) {
        monthDiff = new Date().getMonth() + 1;
      }
      for (let i = 0; i < monthDiff; i++) {
        let [lastY, lastM] = this.groupedArr.slice(-1)[0].date.split('-');
        let nextY = lastY, nextM;
        if (+lastM + 1 > 12) {
          nextM = '01';
          nextY = `${+lastY + 1}`;
        } else {
          nextM = `${+lastM + 1 < 10 ? '0' : ''}${+lastM + 1}`;
        }
        this.groupedArr.push({
          date: `${nextY}-${nextM}-01`,
          data: Array(this.rawData.length).fill([])
        });
      }
    } else if (this.durationUnit == 'years') {
      let yearDiff = (new Date().getFullYear() - new Date(this.groupedArr.slice(-1)[0].date).getFullYear());
      for (let i = 0; i < yearDiff; i++) {
        let [lastY, lastM, lastD] = this.groupedArr.slice(-1)[0].date.split('-');
        let nextY = lastY + 1;
        this.groupedArr.push({
          date: `${nextY}-${lastM}-${lastD}`,
          data: Array(this.rawData.length).fill([])
        });
      }
    }
  }

  private fillFrontMissingDates() {
    let durSpan = this.durationNo - 1;
    if (this.durationUnit == 'days') {
      let firstDate = Date.parse(this.groupedArr.slice(-1)[0].date) - (durSpan * 24 * 60 * 60 * 1000);
      let firstDateObj = new Date(firstDate);
      let [fy, fm, fd] = [firstDateObj.getFullYear(), firstDateObj.getMonth() + 1, firstDateObj.getDate()];
      let [iy, im, id] = this.groupedArr[0].date.split('-');
      while (fy != +iy || fm != +im || fd != +id) {
        if (this.groupedArr.length > durSpan) break;
        let insDate = new Date(Date.parse(this.groupedArr[0].date) - (24 * 60 * 60 * 1000));
        let [y, m, d] = [insDate.getFullYear(), insDate.getMonth() + 1, insDate.getDate()];
        this.groupedArr.unshift({
          date: `${y}-${m < 10 ? '0' : ''}${m}-${d < 10 ? '0' : ''}${d}`,
          data: Array(this.rawData.length).fill([])
        });
        [iy, im, id] = this.groupedArr[0].date.split('-');
      }
    } else if (this.durationUnit == 'months') {
      let [curY, curM, curD] = this.groupedArr.slice(-1)[0].date.split('-');
      let fy = +curM - durSpan <= 0 ? `${+curY - 1}` : curY;
      let fm = +curM - durSpan <= 0 ? `${(12 + (+curM - durSpan)) < 10 ? '0' : ''}${12 + (+curM - durSpan)}` : `${+curM - durSpan < 10 ? '0' : ''}${+curM - durSpan}`;
      let fd = curD;
      let [cfy, cfm, cfd] = this.groupedArr[0].date.split('-');
      while (fy != cfy || fm != cfm || fd != cfd) {
        let [iy, im, id] = this.groupedArr[0].date.split('-');
        iy = +im - 1 <= 0 ? `${+iy - 1}` : +iy;
        im = +im - 1 <= 0 ? `${(12 + (+im - 1)) < 10 ? '0' : ''}${12 + (+im - 1)}` : `${+im - 1 < 10 ? '0' : ''}${+im - 1}`;
        this.groupedArr.unshift({
          date: `${iy}-${im}-${id}`,
          data: Array(this.rawData.length).fill([])
        });
        [cfy, cfm, cfd] = this.groupedArr[0].date.split('-');
      }
    } else if (this.durationUnit == 'years') {
      let [lastY, lastM, lastD] = this.groupedArr.slice(-1)[0].date.split('-');
      let fy = +lastY - durSpan;
      let [cy, cm, cd] = this.groupedArr[0].date.split('-');
      while (fy != cy) {
        let [iy, im, id] = this.groupedArr[0].date.split('-');
        iy = +iy - 1
        this.groupedArr.unshift({
          date: `${iy}-${im}-${id}`,
          data: Array(this.rawData.length).fill([])
        });
        [cy, cm, cd] = this.groupedArr[0].date.split('-');
      }
    }
  }

  private groupData(rawData, I) {
    for (let i = 0; i < rawData.length; i++) {
      let dateExist;
      if (this.groupedArr.length) {
        dateExist = this.groupedArr.filter((each) => {
          let innerExist;
          if (each.data[I]) {
            innerExist = each.data[I].filter((each2) => {
              if (this.durationUnit == 'days') {
                return each2.created_at.split(' ')[0] == rawData[i].created_at.split(' ')[0];
              } else if (this.durationUnit == 'months') {
                return each2.created_at.split('-')[1] == rawData[i].created_at.split('-')[1];
              } else if (this.durationUnit == 'years') {
                return each2.created_at.split('-')[0] == rawData[i].created_at.split('-')[0];
              }
            });
          }
          return innerExist && innerExist.length ? true : false;
        });
        dateExist = dateExist.length ? true : false;
      }
      if (I == 0) {
        if (!this.groupedArr.length || !dateExist) {
          this.groupedArr.push({
            date: rawData[i].created_at.split(' ')[0],
            data: [rawData.filter((each) => {
              if (this.durationUnit == 'days') {
                return rawData[i].created_at.split(' ')[0] == each.created_at.split(' ')[0];
              } else if (this.durationUnit == 'months') {
                return rawData[i].created_at.split('-')[1] == each.created_at.split('-')[1];
              } else if (this.durationUnit == 'years') {
                return rawData[i].created_at.split('-')[0] == each.created_at.split('-')[0];
              }
            })]
          });
          if (this.durationUnit == 'months' || this.durationUnit == 'years') {
            let lastInd = this.groupedArr.length - 1;
            let [prevY, prevM, prevD] = this.groupedArr[lastInd].date.split('-');
            let monthDate = `${prevY}-${prevM}-01`;
            this.groupedArr[lastInd].date = monthDate;
          }
        }
      } else {
        if (!dateExist) {
          let matchInd = -1;
          this.groupedArr.filter((each, j) => {
            if (this.durationUnit == 'days') {
              if (each.date == rawData[i].created_at.split(' ')[0]) {
                matchInd = j;
              }
            } else if (this.durationUnit == 'months') {
              if (each.date.split('-')[1] == rawData[i].created_at.split('-')[1]) {
                matchInd = j;
              }
            } else if (this.durationUnit == 'years') {
              if (each.date.split('-')[0] == rawData[i].created_at.split('-')[0]) {
                matchInd = j;
              }
            }
          });
          if (matchInd != -1) {
            this.groupedArr[matchInd].data.push(rawData.filter((each) => {
              if (this.durationUnit == 'days') {
                return rawData[i].created_at.split(' ')[0] == each.created_at.split(' ')[0];
              } else if (this.durationUnit == 'months') {
                return rawData[i].created_at.split('-')[1] == each.created_at.split('-')[1];
              } else if (this.durationUnit == 'years') {
                return rawData[i].created_at.split('-')[0] == each.created_at.split('-')[0];
              }
            }));
          } else {
            let emptyArr = [];
            for (let j = 0; j < I; j++) {
              emptyArr.push([]);
            }
            this.groupedArr.push({
              date: rawData[i].created_at.split(' ')[0],
              data: [...emptyArr, rawData.filter((each) => {
                if (this.durationUnit == 'days') {
                  return rawData[i].created_at.split(' ')[0] == each.created_at.split(' ')[0];
                } else if (this.durationUnit == 'months') {
                  return rawData[i].created_at.split('-')[1] == each.created_at.split('-')[1];
                } else if (this.durationUnit == 'years') {
                  return rawData[i].created_at.split('-')[0] == each.created_at.split('-')[0];
                }
              })],
            });
            if (this.durationUnit == 'months' || this.durationUnit == 'years') {
              let lastInd = this.groupedArr.length - 1;
              let [prevY, prevM, prevD] = this.groupedArr[lastInd].date.split('-');
              let monthDate = `${prevY}-${prevM}-01`;
              this.groupedArr[lastInd].date = monthDate;
            }
          }
        }
      }
    }
    this.groupedArr.sort((a, b) => {
      return Date.parse(a.date) - Date.parse(b.date);
    });
  }

}

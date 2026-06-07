/**
 * Dashboard Analytics
 */

'use strict';

// =============================
// إعداد الألوان والخطوط من config
// =============================
document.addEventListener('DOMContentLoaded', function (e) {
  let cardColor, headingColor, legendColor, labelColor, shadeColor, borderColor, fontFamily;

  cardColor = config.colors.cardColor;
  headingColor = config.colors.headingColor;
  legendColor = config.colors.bodyColor;
  labelColor = config.colors.textMuted;
  borderColor = config.colors.borderColor;
  fontFamily = config.fontFamily;

  // =============================
  // Order Area Chart (مخطط صغير للطلبات)
  // =============================
  const orderAreaChartEl = document.querySelector('#orderChart'),
    orderAreaChartConfig = {
      chart: { height: 80, type: 'area', toolbar: { show: false }, sparkline: { enabled: true } },
      markers: { size: 6 },
      colors: [config.colors.success],
      series: [{ data: [180, 175, 275, 140, 205, 190, 295] }],
      stroke: { width: 2, curve: 'smooth' },
      dataLabels: { enabled: false },
      xaxis: { show: false },
      yaxis: { show: false }
    };

  if (orderAreaChartEl) {
    new ApexCharts(orderAreaChartEl, orderAreaChartConfig).render();
  }
});

// =============================
// Total Revenue Chart (Bar Chart لحسابات الأعمال شهرياً)
// =============================
document.addEventListener('DOMContentLoaded', function () {
  (function () {
    let cardColor = config.colors.white;
    let headingColor = config.colors.headingColor;
    let labelColor = config.colors.textMuted;
    let borderColor = config.colors.borderColor;
    let legendColor = config.colors.bodyColor;
    let fontFamily = config.fontFamily;

    const totalRevenueChartEl = document.querySelector('#totalRevenueChart'),
      totalRevenueChartOptions = {
        series: [{ name: "Business Accounts", data: window.businessAccountsData }],
        chart: { height: 300, type: 'bar', toolbar: { show: false } },
        plotOptions: { bar: { columnWidth: '30%', borderRadius: 8 } },
        colors: [config.colors.primary],
        dataLabels: { enabled: false },
        stroke: { width: 6, curve: 'smooth', colors: [cardColor] },
        legend: { show: true, position: 'top', labels: { colors: legendColor } },
        grid: { borderColor: borderColor },
        xaxis: { categories: window.months, labels: { style: { colors: labelColor } } },
        yaxis: { labels: { style: { colors: labelColor } } }
      };

    if (totalRevenueChartEl) {
      new ApexCharts(totalRevenueChartEl, totalRevenueChartOptions).render();
    }
  })();
});

// =============================
// Growth Chart (Radial Bar Chart)
// =============================
const growthChartEl = document.querySelector('#growthChart');
if (growthChartEl) {
  new ApexCharts(growthChartEl, {
    series: [78],
    labels: ['Growth'],
    chart: { type: 'radialBar', height: 200 },
    colors: [config.colors.primary]
  }).render();
}

// =============================
// Revenue Bar Chart (مخطط صغير للإيرادات)
// =============================
const revenueBarChartEl = document.querySelector('#revenueChart');
if (revenueBarChartEl) {
  new ApexCharts(revenueBarChartEl, {
    chart: { type: 'bar', height: 95 },
    series: [{ data: [40, 95, 60, 45, 90, 50, 75] }],
    colors: [config.colors.primary],
    dataLabels: { enabled: false }
  }).render();
}

// =============================
// Profit Report Line Chart
// =============================
const profileReportChartEl = document.querySelector('#profileReportChart');
if (profileReportChartEl) {
  new ApexCharts(profileReportChartEl, {
    chart: { type: 'line', height: 75, sparkline: { enabled: true } },
    series: [{ data: [110, 270, 145, 245, 205, 285] }],
    colors: [config.colors.warning],
    stroke: { width: 5, curve: 'smooth' }
  }).render();
}

// =============================
// Order Statistics Donut Chart
// =============================
const chartOrderStatistics = document.querySelector('#orderStatisticsChart');
if (chartOrderStatistics) {
  new ApexCharts(chartOrderStatistics, {
    chart: { type: 'donut', height: 165 },
    labels: ['Electronic', 'Sports', 'Decor', 'Fashion'],
    series: [50, 85, 25, 40],
    colors: [config.colors.success, config.colors.primary, config.colors.secondary, config.colors.info]
  }).render();
}

// =============================
// Income Area Chart
// =============================
const incomeChartEl = document.querySelector('#incomeChart');
if (incomeChartEl) {
  new ApexCharts(incomeChartEl, {
    chart: { type: 'area', height: 200 },
    series: [{ data: [21, 30, 22, 42, 26, 35, 29] }],
    colors: [config.colors.primary],
    stroke: { width: 3, curve: 'smooth' }
  }).render();
}

// =============================
// Weekly Expenses Radial Chart
// =============================
const weeklyExpensesEl = document.querySelector('#expensesOfWeek');
if (weeklyExpensesEl) {
  new ApexCharts(weeklyExpensesEl, {
    chart: { type: 'radialBar', height: 60 },
    series: [65],
    colors: [config.colors.primary]
  }).render();
}

// =============================
// Top Cities Pie Chart (المدن الأكثر نشاطاً)
// =============================
const citiesPieChartEl = document.querySelector('#citiesPieChart');
if (citiesPieChartEl && window.cities && window.citiesCounts) {
  new ApexCharts(citiesPieChartEl, {
    series: window.citiesCounts,
    labels: window.cities,
    chart: { type: 'pie', height: 320 },
    legend: { position: 'bottom', labels: { colors: config.colors.bodyColor } },
    dataLabels: { enabled: true },
    colors: [
      config.colors.primary,
      config.colors.info,
      config.colors.success,
      config.colors.warning,
      config.colors.danger,
      '#A855F7'
    ]
  }).render();
}

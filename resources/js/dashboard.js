import Chart from 'chart.js/auto';
import 'chartjs-adapter-date-fns';

export default function measurementDashboard() {
  return {
    selectedLineKpis: [],
    selectedPieKpis: [],
    selectedUnits: [],
    startDate: '',
    endDate: '',
    chartType: 'line', 
    chart: null,
    pieChart: null,

    async fetchLineData() {
      if (!this.selectedLineKpis.length || !this.startDate || !this.endDate) {
        console.log('Choose one or more KPI and dates for the line chart.');
        return;
      }
      
      if (new Date(this.startDate) > new Date(this.endDate)) {
        console.log('First date is later than the last.');
        return;
      }

      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      if (!token) {
        console.log('CSRF token not found!');
        return;
      }

      try {
        const response = await fetch('/api/measurements', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: JSON.stringify({
            kpi_ids: this.selectedLineKpis,
            start_date: this.startDate,
            end_date: this.endDate
          })
        });

        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        console.log('Line/Bar chart data fetched: ', data);
        this.renderChart(data);

      } catch (error) {
        console.log('Something went wrong while loading line/bar chart data.');
        console.error(error);
      }
    },

    async fetchPieData() {
      if (!this.selectedPieKpis.length || !this.selectedUnits.length) {
        console.log('Choose one or more KPI and units for the pie chart.');
        return;
      }
      
      const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      if (!token) {
        console.log('CSRF token not found!');
        return;
      }

      try {
        const response = await fetch('/api/measurements', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
          },
          body: JSON.stringify({
            kpi_ids: this.selectedPieKpis,
            units: this.selectedUnits,
            start_date:this.startDate,
            end_date: this.endDate
          })
        });
        

        if (!response.ok) throw new Error('Network response was not ok');

        const data = await response.json();
        console.log('Pie chart data fetched: ', data);
        this.renderPieChart(data);

      } catch (error) {
        console.log('Something went wrong while loading pie chart data.');
        console.error(error);
      }
    },

    renderChart(data) {
      if (this.chart) {
        this.chart.destroy();
      }

      const ctx = document.getElementById('chart').getContext('2d');
      const kpiNames = {};
      data.forEach(measurement => {
        kpiNames[measurement.kpi_id] = measurement.kpi_name;
      });

      const colors = [
        'rgba(54, 162, 235, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ];

      const minDate = new Date(this.startDate);
      const maxDate = new Date(this.endDate);

      const canvas = document.getElementById('chart');
      canvas.style.maxWidth = '';
      canvas.style.maxHeight = '';
      canvas.style.width = '';
      canvas.style.height = '';

      const grouped = {};
      data.forEach(measurement => {
        const kpiId = measurement.kpi_id;
        if (!grouped[kpiId]) grouped[kpiId] = [];
        grouped[kpiId].push({ x: new Date(measurement.date), y: measurement.value });
      });

      const datasets = Object.keys(grouped).map((kpiId, i) => {
        const color = colors[i % colors.length];
        const points = [
          { x: minDate, y: 0 },
          ...grouped[kpiId]
        ];

        return {
          label: kpiNames[kpiId] || `KPI ${kpiId}`,
          data: points,
          borderColor: color,
          backgroundColor: this.chartType === 'bar' ? color : 'transparent',
          fill: false,
          tension: 0.4,
          pointRadius: 5,
          pointHoverRadius: 8,
          pointBackgroundColor: color,
          borderWidth: 3,
          type: this.chartType
        };
      });

      this.chart = new Chart(ctx, {
        type: this.chartType,
        data: { datasets },
        options: {
          animation: {
            duration: 1500,
            easing: 'easeOutQuart',
          },
          scales: {
            x: {
              type: 'time',
              time: {
                unit: 'day',
                tooltipFormat: 'yyyy-MM-dd',
              },
              title: {
                display: true,
                text: 'Date',
                color: '#bbb',
                font: { size: 14, weight: 'bold' }
              },
              min: minDate,
              max: maxDate,
              ticks: {
                color: '#ddd',
                autoSkip: true,
                maxRotation: 0
              },
              grid: {
                color: 'rgba(255, 255, 255, 0.1)'
              }
            },
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Value',
                color: '#bbb',
                font: { size: 14, weight: 'bold' }
              },
              ticks: {
                color: '#ddd'
              },
              grid: {
                color: 'rgba(255, 255, 255, 0.1)'
              }
            }
          },
          plugins: {
            legend: {
              position: 'top',
              labels: {
                color: '#eee',
                font: {
                  size: 14,
                  weight: 'bold'
                }
              }
            },
            tooltip: {
              mode: 'nearest',
              intersect: false,
              backgroundColor: 'rgba(0, 0, 0, 0.85)',
              titleColor: '#fff',
              bodyColor: '#fff',
              padding: 10,
              cornerRadius: 6,
              displayColors: true
            }
          },
          responsive: true,
          maintainAspectRatio: false
        }
      });
    },
renderPieChart(data) {
  console.log("Raw pie chart data:", data);
  
  if (this.pieChart) {
    this.pieChart.destroy();
  }

  const kpiNames = {};
  data.forEach(m => {
    if (!kpiNames[m.kpi_id]) {
      kpiNames[m.kpi_id] = m.kpi_name || `KPI ${m.kpi_id}`;
    }
  });

  const aggregated = {};
  data.forEach(m => {
    if (!this.selectedUnits.includes(m.kpi_unit)) {
      return;
    }

    const key = `${m.kpi_id}-${m.kpi_unit}`;
    if (!aggregated[key]) {
      aggregated[key] = 0;
    }

    const val = parseFloat(m.value);
    if (isNaN(val)) {
      console.warn(`Warning: m.value is not a number: ${m.value}`);
    } else {
      aggregated[key] += val;
      console.log(`Adding value ${val} to key ${key}. Aggregated so far: ${aggregated[key]}`);
    }
  });

  const labels = Object.keys(aggregated).map(key => {
    const [kpi_id, unit] = key.split('-');
    return `${kpiNames[kpi_id]} (${unit})`;
  });
  const values = Object.values(aggregated);

  console.log("Aggregated labels:", labels);
  console.log("Aggregated values:", values);

  const colors = [
    'rgba(54, 162, 235, 1)',
    'rgba(255, 99, 132, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
  ];

  const ctx = document.getElementById('pieChart').getContext('2d');
  this.pieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels,
      datasets: [{
        label: 'Values per KPI and Unit',
        data: values,
        backgroundColor: colors,
        hoverOffset: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',                         
          labels: {
            color: '#eee',
            font: { size: 14, weight: 'bold' }
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0, 0, 0, 0.85)',
          titleColor: '#fff',
          bodyColor: '#fff',
          padding: 10,
          cornerRadius: 6,
        }
      }
    }
  });
}

  }
}  
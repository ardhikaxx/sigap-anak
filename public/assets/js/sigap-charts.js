const sigapCharts = {
  colors: {
    primary: '#2E86AB',
    secondary: '#57CC99',
    accent: '#FF6B6B',
    warning: '#FFB347',
    info: '#74C0FC',
    purple: '#9B59B6',
    danger: '#FF6B6B',
    success: '#57CC99'
  },

  createPieChart(canvasId, data, labels) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return null;

    return new Chart(ctx, {
      type: 'pie',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          backgroundColor: [
            this.colors.success,
            this.colors.warning,
            this.colors.danger,
            this.colors.info,
            this.colors.purple,
            this.colors.primary
          ],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              usePointStyle: true,
              font: {
                size: 12
              }
            }
          }
        }
      }
    });
  },

  createLineChart(canvasId, labels, datasets) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return null;

    return new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          intersect: false,
          mode: 'index'
        },
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20
            }
          }
        },
        scales: {
          y: {
            beginAtZero: false,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  },

  createBarChart(canvasId, labels, datasets) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return null;

    return new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.05)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  },

  createGrowthChart(canvasId, pemeriksaan, indicator) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return null;

    const labels = pemeriksaan.map(p => {
      const date = new Date(p.tanggal_periksa);
      return date.toLocaleDateString('id-ID', { month: 'short', year: '2-digit' });
    });

    const dataBBU = pemeriksaan.map(p => p.bb_u_zscore);
    const dataTBU = pemeriksaan.map(p => p.tb_u_zscore);
    const dataBBTB = pemeriksaan.map(p => p.bb_tb_zscore);

    let datasets = [];
    
    if (indicator === 'bb_u') {
      datasets = [{
        label: 'BB/U',
        data: dataBBU,
        borderColor: this.colors.primary,
        backgroundColor: this.colors.primary + '20',
        tension: 0.3,
        fill: true
      }];
    } else if (indicator === 'tb_u') {
      datasets = [{
        label: 'TB/U',
        data: dataTBU,
        borderColor: this.colors.secondary,
        backgroundColor: this.colors.secondary + '20',
        tension: 0.3,
        fill: true
      }];
    } else if (indicator === 'bb_tb') {
      datasets = [{
        label: 'BB/TB',
        data: dataBBTB,
        borderColor: this.colors.purple,
        backgroundColor: this.colors.purple + '20',
        tension: 0.3,
        fill: true
      }];
    }

    datasets.push({
      label: 'Median (0)',
      data: labels.map(() => 0),
      borderColor: '#ccc',
      borderDash: [5, 5],
      pointRadius: 0,
      fill: false
    });

    datasets.push({
      label: '+2 SD',
      data: labels.map(() => 2),
      borderColor: this.colors.warning,
      borderDash: [5, 5],
      pointRadius: 0,
      fill: false
    });

    datasets.push({
      label: '-2 SD',
      data: labels.map(() => -2),
      borderColor: this.colors.warning,
      borderDash: [5, 5],
      pointRadius: 0,
      fill: false
    });

    return new Chart(ctx, {
      type: 'line',
      data: { labels, datasets },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              filter: function(item) {
                return !item.text.includes('SD');
              }
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.y.toFixed(2);
              }
            }
          }
        },
        scales: {
          y: {
            min: -4,
            max: 4,
            grid: {
              color: function(context) {
                if (context.tick.value === 0) {
                  return '#000';
                }
                return 'rgba(0, 0, 0, 0.05)';
              },
              lineWidth: function(context) {
                if (context.tick.value === 0) {
                  return 2;
                }
                return 1;
              }
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });
  },

  destroyChart(canvasId) {
    const chart = Chart.getChart(canvasId);
    if (chart) {
      chart.destroy();
    }
  }
};

function initDashboardCharts(statusGizi) {
  const labels = [];
  const data = [];

  if (statusGizi) {
    Object.entries(statusGizi).forEach(([key, value]) => {
      labels.push(formatStatusLabel(key));
      data.push(value);
    });
  }

  if (labels.length > 0) {
    sigapCharts.createPieChart('statusGiziChart', data, labels);
  }
}

function formatStatusLabel(status) {
  const labels = {
    'normal': 'Normal',
    'berisiko': 'Berisiko',
    'stunting': 'Stunting',
    'wasting': 'Wasting',
    'underweight': 'Underweight',
    'overweight': 'Overweight',
    'obesitas': 'Obesitas',
    'gizi_buruk': 'Gizi Buruk'
  };
  return labels[status] || status;
}

if (typeof module !== 'undefined' && module.exports) {
  module.exports = sigapCharts;
}

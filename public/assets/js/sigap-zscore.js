function calculateZScore(measurement, median, sd) {
  return (measurement - median) / sd;
}

function statusBBU(zscore) {
  if (zscore === null || zscore === undefined) return { status: 'Data tidak lengkap', class: 'secondary', color: '#6C757D' };
  if (zscore < -3) return { status: 'Gizi Buruk', class: 'danger', color: '#C0392B' };
  if (zscore < -2) return { status: 'Gizi Kurang', class: 'warning', color: '#FFB347' };
  if (zscore <= 1) return { status: 'Gizi Baik', class: 'success', color: '#57CC99' };
  if (zscore <= 2) return { status: 'Berisiko Lebih', class: 'info', color: '#74C0FC' };
  return { status: 'Gizi Lebih', class: 'orange', color: '#E67E22' };
}

function statusTBU(zscore) {
  if (zscore === null || zscore === undefined) return { status: 'Data tidak lengkap', class: 'secondary', color: '#6C757D' };
  if (zscore < -3) return { status: 'Sangat Pendek (Severely Stunted)', class: 'danger', color: '#C0392B' };
  if (zscore < -2) return { status: 'Pendek (Stunted)', class: 'warning', color: '#FFB347' };
  if (zscore <= 3) return { status: 'Normal', class: 'success', color: '#57CC99' };
  return { status: 'Tinggi', class: 'info', color: '#74C0FC' };
}

function statusBBTB(zscore) {
  if (zscore === null || zscore === undefined) return { status: 'Data tidak lengkap', class: 'secondary', color: '#6C757D' };
  if (zscore < -3) return { status: 'Sangat Kurus (Severely Wasted)', class: 'danger', color: '#C0392B' };
  if (zscore < -2) return { status: 'Kurus (Wasted)', class: 'warning', color: '#FFB347' };
  if (zscore <= 1) return { status: 'Normal', class: 'success', color: '#57CC99' };
  if (zscore <= 2) return { status: 'Gemuk (Overweight)', class: 'orange', color: '#E67E22' };
  return { status: 'Obesitas', class: 'purple', color: '#8E44AD' };
}

function statusIMTU(zscore) {
  if (zscore === null || zscore === undefined) return { status: 'Data tidak lengkap', class: 'secondary', color: '#6C757D' };
  if (zscore < -3) return { status: 'Sangat Kurus', class: 'danger', color: '#C0392B' };
  if (zscore < -2) return { status: 'Kurus', class: 'warning', color: '#FFB347' };
  if (zscore <= 1) return { status: 'Normal', class: 'success', color: '#57CC99' };
  if (zscore <= 2) return { status: 'Gemuk', class: 'orange', color: '#E67E22' };
  return { status: 'Obesitas', class: 'purple', color: '#8E44AD' };
}

function getStatusGiziAkhir(statusBBU, statusTBU, statusBBTB) {
  if (!statusBBU || !statusTBU || !statusBBTB) return 'berisiko';
  
  const bb = statusBBU.class;
  const tb = statusTBU.class;
  const bbTB = statusBBTB.class;

  if (bb === 'danger' || bbTB === 'danger') return 'gizi_buruk';
  if (bb === 'warning' || bbTB === 'warning') return 'underweight';
  if (tb === 'danger' || tb === 'warning') return 'stunting';
  if (bbTB === 'danger' || bbTB === 'warning') return 'wasting';
  if (bb === 'purple' || bbTB === 'purple') return 'obesitas';
  if (bb === 'orange' || bbTB === 'orange') return 'overweight';
  if (bb === 'success' && tb === 'success' && bbTB === 'success') return 'normal';
  
  return 'berisiko';
}

function calculateZScoreFromInput(beratBadan, tinggiBadan, jenisKelamin, umurBulan) {
  const standarData = getStandarWHO(jenisKelamin, umurBulan);
  
  if (!standarData) {
    return {
      bb_u: null,
      tb_u: null,
      bb_tb: null,
      status_bb_u: null,
      status_tb_u: null,
      status_bb_tb: null
    };
  }

  const bb_u = calculateZScore(beratBadan, standarData.bb_u_median, (standarData.bb_u_plus2 - standarData.bb_u_minus2) / 4);
  const tb_u = calculateZScore(tinggiBadan, standarData.tb_u_median, (standarData.tb_u_plus2 - standarData.tb_u_minus2) / 4);
  
  let bb_tb = null;
  if (standarData.bb_tb_median) {
    bb_tb = calculateZScore(beratBadan, standarData.bb_tb_median, (standarData.bb_tb_plus2 - standarData.bb_tb_minus2) / 4);
  }

  return {
    bb_u: bb_u,
    tb_u: tb_u,
    bb_tb: bb_tb,
    status_bb_u: statusBBU(bb_u),
    status_tb_u: statusTBU(tb_u),
    status_bb_tb: statusBBTB(bb_tb)
  };
}

function getStandarWHO(jenisKelamin, umurBulan) {
  const data = {
    'L': {
      0: { bb_u_median: 3.3, bb_u_minus2: 2.5, bb_u_plus2: 4.4, tb_u_median: 49.9, tb_u_minus2: 45.6, tb_u_plus2: 54.2, bb_tb_median: 32.0, bb_tb_minus2: 23.4, bb_tb_plus2: 42.1 },
      1: { bb_u_median: 4.5, bb_u_minus2: 3.4, bb_u_plus2: 5.8, tb_u_median: 54.7, tb_u_minus2: 50.0, tb_u_plus2: 59.4, bb_tb_median: 37.6, bb_tb_minus2: 28.1, bb_tb_plus2: 48.0 },
      2: { bb_u_median: 5.6, bb_u_minus2: 4.3, bb_u_plus2: 7.1, tb_u_median: 58.4, tb_u_minus2: 53.4, tb_u_plus2: 63.5, bb_tb_median: 40.6, bb_tb_minus2: 30.7, bb_tb_plus2: 51.3 },
      3: { bb_u_median: 6.4, bb_u_minus2: 4.9, bb_u_plus2: 8.1, tb_u_median: 61.4, tb_u_minus2: 56.1, tb_u_plus2: 66.6, bb_tb_median: 42.9, bb_tb_minus2: 32.7, bb_tb_plus2: 53.7 },
      6: { bb_u_median: 7.9, bb_u_minus2: 6.0, bb_u_plus2: 10.2, tb_u_median: 67.6, tb_u_minus2: 61.8, tb_u_plus2: 73.5, bb_tb_median: 46.7, bb_tb_minus2: 35.8, bb_tb_plus2: 57.9 },
      12: { bb_u_median: 9.6, bb_u_minus2: 7.2, bb_u_plus2: 12.3, tb_u_median: 75.7, tb_u_minus2: 69.2, tb_u_plus2: 82.2, bb_tb_median: 48.9, bb_tb_minus2: 37.9, bb_tb_plus2: 60.3 },
      24: { bb_u_median: 12.2, bb_u_minus2: 9.2, bb_u_plus2: 15.5, tb_u_median: 87.8, tb_u_minus2: 80.5, tb_u_plus2: 95.0, bb_tb_median: 51.7, bb_tb_minus2: 40.1, bb_tb_plus2: 63.6 },
    },
    'P': {
      0: { bb_u_median: 3.2, bb_u_minus2: 2.4, bb_u_plus2: 4.2, tb_u_median: 49.1, tb_u_minus2: 45.0, tb_u_plus2: 53.2, bb_tb_median: 31.7, bb_tb_minus2: 23.0, bb_tb_plus2: 41.5 },
      1: { bb_u_median: 4.1, bb_u_minus2: 3.2, bb_u_plus2: 5.4, tb_u_median: 53.7, tb_u_minus2: 49.1, tb_u_plus2: 58.4, bb_tb_median: 37.1, bb_tb_minus2: 27.6, bb_tb_plus2: 47.3 },
      2: { bb_u_median: 5.1, bb_u_minus2: 3.9, bb_u_plus2: 6.6, tb_u_median: 57.1, tb_u_minus2: 52.2, tb_u_plus2: 62.1, bb_tb_median: 40.1, bb_tb_minus2: 30.2, bb_tb_plus2: 50.7 },
      3: { bb_u_median: 5.8, bb_u_minus2: 4.5, bb_u_plus2: 7.5, tb_u_median: 59.8, tb_u_minus2: 54.6, tb_u_plus2: 65.1, bb_tb_median: 42.3, bb_tb_minus2: 32.1, bb_tb_plus2: 53.0 },
      6: { bb_u_median: 7.3, bb_u_minus2: 5.6, bb_u_plus2: 9.4, tb_u_median: 65.7, tb_u_minus2: 60.1, tb_u_plus2: 71.3, bb_tb_median: 45.8, bb_tb_minus2: 35.2, bb_tb_plus2: 56.7 },
      12: { bb_u_median: 8.9, bb_u_minus2: 6.7, bb_u_plus2: 11.4, tb_u_median: 74.0, tb_u_minus2: 67.7, tb_u_plus2: 80.2, bb_tb_median: 48.0, bb_tb_minus2: 37.2, bb_tb_plus2: 59.2 },
      24: { bb_u_median: 11.5, bb_u_minus2: 8.7, bb_u_plus2: 14.6, tb_u_median: 86.4, tb_u_minus2: 79.3, tb_u_plus2: 93.4, bb_tb_median: 50.7, bb_tb_minus2: 39.4, bb_tb_plus2: 62.4 },
    }
  };

  const closestKey = Object.keys(data[jenisKelamin])
    .map(Number)
    .reduce((prev, curr) => 
      Math.abs(curr - umurBulan) < Math.abs(prev - umurBulan) ? curr : prev
    );

  return data[jenisKelamin][closestKey];
}

function updateStatusDisplay(statusData, elementId) {
  const element = document.getElementById(elementId);
  if (element) {
    element.innerHTML = `<span class="status-badge ${statusData.class}">${statusData.status}</span>`;
  }
}

function formatZScore(zscore) {
  if (zscore === null || zscore === undefined) return '-';
  return zscore.toFixed(2);
}

if (typeof module !== 'undefined' && module.exports) {
  module.exports = {
    calculateZScore,
    statusBBU,
    statusTBU,
    statusBBTB,
    statusIMTU,
    getStatusGiziAkhir,
    calculateZScoreFromInput,
    formatZScore
  };
}

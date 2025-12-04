<script>
// Outlier detection ranges (based on WHO standards for ages 0-60 months)
const outlierRanges = {
    bb: { min: 2, max: 30, label: 'Berat Badan' },
    tb: { min: 40, max: 120, label: 'Tinggi Badan' },
    lk: { min: 30, max: 55, label: 'Lingkar Kepala' },
    ll: { min: 10, max: 25, label: 'Lingkar Lengan' }
};

function checkOutlier(type) {
    const input = document.getElementById(type === 'bb' ? 'berat_badan' : 
                                         type === 'tb' ? 'tinggi_badan' : 
                                         type === 'lk' ? 'lingkar_kepala' : 'lingkar_lengan');
    const warning = document.getElementById(type === 'bb' ? 'warningBB' : 
                                           type === 'tb' ? 'warningTB' : 
                                           type === 'lk' ? 'warningLK' : 'warningLL');
    const value = parseFloat(input.value);
    const range = outlierRanges[type];
    
    if (isNaN(value)) {
        warning.classList.add('hidden');
        return false;
    }
    
    // Check if value is outside reasonable range
    if (value < range.min || value > range.max) {
        warning.classList.remove('hidden');
        warning.innerHTML = `
            <div class="flex items-start">
                <svg class="w-4 h-4 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-medium">Nilai ${range.label} tidak wajar!</p>
                    <p class="text-xs mt-1">Rentang normal: ${range.min} - ${range.max}</p>
                </div>
            </div>
        `;
        input.classList.add('border-yellow-400', 'bg-yellow-50');
        return true;
    } else {
        warning.classList.add('hidden');
        input.classList.remove('border-yellow-400', 'bg-yellow-50');
        return false;
    }
}

function checkAllOutliers() {
    let hasOutlier = false;
    
    ['bb', 'tb', 'lk', 'll'].forEach(type => {
        if (checkOutlier(type)) {
            hasOutlier = true;
        }
    });
    
    return hasOutlier;
}

// Advanced outlier detection based on age
function checkOutlierByAge() {
    const anakInfo = getSelectedAnakInfo();
    if (!anakInfo) return;
    
    const umurBulan = anakInfo.umur_bulan;
    const beratBadan = parseFloat(document.getElementById('berat_badan').value);
    const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
    
    // Age-specific ranges (simplified - production should use WHO lookup tables)
    let expectedBB = { min: 0, max: 100 };
    let expectedTB = { min: 0, max: 200 };
    
    if (umurBulan <= 12) {
        // 0-12 months
        expectedBB = { min: 2.5, max: 12 };
        expectedTB = { min: 45, max: 80 };
    } else if (umurBulan <= 24) {
        // 13-24 months
        expectedBB = { min: 7, max: 15 };
        expectedTB = { min: 70, max: 90 };
    } else if (umurBulan <= 36) {
        // 25-36 months
        expectedBB = { min: 9, max: 18 };
        expectedTB = { min: 80, max: 100 };
    } else {
        // 37-60 months
        expectedBB = { min: 11, max: 25 };
        expectedTB = { min: 90, max: 120 };
    }
    
    // Check BB outlier by age
    if (beratBadan < expectedBB.min || beratBadan > expectedBB.max) {
        const warning = document.getElementById('warningBB');
        warning.classList.remove('hidden');
        warning.innerHTML = `
            <div class="flex items-start">
                <svg class="w-4 h-4 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-medium">BB tidak sesuai umur ${umurBulan} bulan!</p>
                    <p class="text-xs mt-1">Rentang normal usia ini: ${expectedBB.min} - ${expectedBB.max} kg</p>
                </div>
            </div>
        `;
    }
    
    // Check TB outlier by age
    if (tinggiBadan < expectedTB.min || tinggiBadan > expectedTB.max) {
        const warning = document.getElementById('warningTB');
        warning.classList.remove('hidden');
        warning.innerHTML = `
            <div class="flex items-start">
                <svg class="w-4 h-4 text-yellow-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="font-medium">TB tidak sesuai umur ${umurBulan} bulan!</p>
                    <p class="text-xs mt-1">Rentang normal usia ini: ${expectedTB.min} - ${expectedTB.max} cm</p>
                </div>
            </div>
        `;
    }
}

// BMI/WHZ Quick Check (Berat vs Tinggi)
function checkBMIOutlier() {
    const bb = parseFloat(document.getElementById('berat_badan').value);
    const tb = parseFloat(document.getElementById('tinggi_badan').value);
    
    if (isNaN(bb) || isNaN(tb) || tb === 0) return;
    
    // BMI = BB (kg) / (TB (m))^2
    const tbMeter = tb / 100;
    const bmi = bb / (tbMeter * tbMeter);
    
    // BMI ranges for children (simplified)
    let status = '';
    let color = '';
    
    if (bmi < 14) {
        status = 'Sangat Kurus';
        color = 'red';
    } else if (bmi < 16) {
        status = 'Kurus';
        color = 'orange';
    } else if (bmi < 18) {
        status = 'Normal';
        color = 'green';
    } else if (bmi < 20) {
        status = 'Gemuk';
        color = 'orange';
    } else {
        status = 'Obesitas';
        color = 'red';
    }
    
    console.log(`BMI: ${bmi.toFixed(1)} - Status: ${status}`);
}

// Trigger BMI check when both BB and TB are filled
document.getElementById('berat_badan')?.addEventListener('change', checkBMIOutlier);
document.getElementById('tinggi_badan')?.addEventListener('change', checkBMIOutlier);
</script>